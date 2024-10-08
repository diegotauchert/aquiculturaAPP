<?php

namespace App\Http\Controllers\Gestor;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;

class AcompanhamentoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:gestor']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $f_p = $request->f_p;
        $viveiros = DB::table('producao as p')
                                    ->select(['p.id as producao_id', 'v.id as viveiro_id', 'v.nome', 'c.situacao as situacaoCultivo', 'c.categoria_id as categoriaCultivo'])
                                    ->join('viveiros as v', function($join)
                                    {
                                        $join->on('v.id', 'p.viveiro_id')
                                             ->where('v.situacao', "1");
                                    })
                                    ->leftJoin('cultivo as c', function($join)
                                    {
                                        $join->on('c.viveiro_id', '=', 'v.id')
                                             ->where('c.cliente_id', auth('gestor')->user()->cliente_id)
                                             ->where('c.fazenda_id', auth('gestor')->user()->fazenda_id)
                                             ->where('c.situacao', "1");
                                    })
                                    ->where("p.cliente_id", auth('gestor')->user()->cliente_id)
                                    ->where("p.fazenda_id", auth('gestor')->user()->fazenda_id)
                                    ->where("p.categoria_id", 1)
                                    ->get();

        if ($f_p) {
            $acompanhamento = \App\Models\Acompanhamento::where('cliente_id', auth('gestor')->user()->cliente_id)
                    ->where('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('email', 'like', '%' . $f_p . '%')
                    ->orderBy('id', 'desc');
        } else {
            $acompanhamento = \App\Models\Acompanhamento::where('cliente_id', auth('gestor')->user()->cliente_id)->orderBy('id', 'desc');
        }

        if(auth('gestor')->user()->fazenda_id){
            $acompanhamento = $acompanhamento->where('fazenda_id', auth('gestor')->user()->fazenda_id);
        }
        $acompanhamento = $acompanhamento->paginate(10);

        $cultivo = new \App\Models\Cultivo;

        return view('gestor.acompanhamento.lista', compact('acompanhamento', 'f_p', 'viveiros', 'cultivo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $producao_id, int $viveiro_id)
    {
        $viveiro = \App\Models\Viveiro::where('cliente_id', auth('gestor')->user()->cliente_id)
                                        ->where('id', $viveiro_id)
                                        ->where('fazenda_id', auth('gestor')->user()->fazenda_id)
                                        ->first();
        if(!$viveiro){
            return redirect()->route('gestor.acompanhamento.index')
                            ->withInput();
        }
        
        $producao = DB::table('producao as p')
                        ->select(['p.id as producao_id', 'pp.nome as produto', 'pp.id as produtoId', 'p.qtd', 'p.viveiro_id', 'pp.quantidade as qtdProduto'])
                        ->leftJoin('produtos as pp', function($join)
                        {
                            $join->on('pp.id', 'p.produto_id')
                                 ->where('pp.situacao', "1")
                                 ->orderBy('pp.id', "DESC")
                                 ->limit(1);
                        })
                        ->where('p.id', $producao_id)
                        ->where('p.viveiro_id', $viveiro_id)
                        ->where('p.cliente_id', auth('gestor')->user()->cliente_id)
                        ->where('p.fazenda_id', auth('gestor')->user()->fazenda_id)
                        ->first();

        if(!$producao){
            return redirect()->route('gestor.acompanhamento.index')
                            ->withInput();
        }

        $producaoHorarios = DB::table('producao_horario as ph')
                                    ->select(['ph.id as horario_id', 'ph.hora', 'a.horario', 'a.data', 'a.arracoamento'])
                                    ->leftJoin('acompanhamento as a', function($leftJoin)
                                    {
                                        $leftJoin->on('ph.id', 'a.producao_horario_id');
                                        $leftJoin->whereBetween('a.data', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')]);
                                    })
                                    ->where('ph.cliente_id', auth('gestor')->user()->cliente_id)
                                    ->where('ph.producao_id', $producao_id)
                                    ->where('ph.viveiro_id', $viveiro_id)
                                    ->where('ph.fazenda_id', auth('gestor')->user()->fazenda_id)
                                    ->orderBy(DB::raw('HOUR(ph.hora)'))
                                    ->get();
        
        $acompanhamento = new \App\Models\Acompanhamento;

        $acompanhamentosAntigos = \App\Models\Acompanhamento::whereDate('data', '<', date("Y-m-d"))
                                                    ->where('cliente_id', auth('gestor')->user()->cliente_id)
                                                    ->where('producao_id', $producao_id)
                                                    ->where('viveiro_id', $viveiro_id)
                                                    ->where('fazenda_id', auth('gestor')->user()->fazenda_id)
                                                    ->orderBy('data', 'desc')
                                                    ->limit(20)
                                                    ->get();

        return view('gestor.acompanhamento.edita', compact('acompanhamento', 'producao', 'producaoHorarios', 'acompanhamentosAntigos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $acompanhamento = new \App\Models\Acompanhamento;

        $validator = $this->valid($request, $acompanhamento);
        if ($validator->fails()) {
            return redirect()->route('gestor.acompanhamento.create')
                            ->withErrors($validator)
                            ->withInput();
        }
        $acompanhamento->cliente_id = auth('gestor')->user()->cliente_id;
        $acompanhamento->fazenda_id = auth('gestor')->user()->fazenda_id;
        $acompanhamento->usuario_id = auth('gestor')->user()->id;
        $acompanhamento->viveiro_id = $request->viveiro_id;
        $acompanhamento->horario = $request->save_hour;
        $acompanhamento->arracoamento = $request->save_message;
        $acompanhamento->producao_id = $request->producao_id;
        $acompanhamento->producao_horario_id = $request->producao_horario_id;
        $acompanhamento->data = date('Y-m-d H:i:s');
        $acompanhamento->situacao = 1;

        $acompanhamento->save();

        if($request->qtd_lote){
            $produto = \App\Models\Produto::findOrFail($request->produto_id);

            $produto->quantidade = intval($produto->quantidade) - intval($request->qtd_lote);
            $produto->save();
        }

        return redirect()->route('gestor.acompanhamento.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request)
    {
        $validator = validator($request->all(), [
            'producao_id' => 'required|numeric',
            'producao_horario_id' => 'required|numeric',
            'viveiro_id' => 'required|numeric',
            'save_hour' => 'required|max:5',
            'save_message' => 'required|max:250'
        ]);

        return $validator;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('gestor.acompanhamento.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $acompanhamento = \App\Models\Acompanhamento::findOrFail($id);
        $fazendas = \App\Models\Fazenda::where('cliente_id', auth('gestor')->user()->cliente_id)->get();

        $cliente = null;
        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }

        return view('gestor.acompanhamento.edita', compact('acompanhamento', 'cliente', 'fazendas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $acompanhamento = \App\Models\Acompanhamento::findOrFail($id);

        $validator = $this->valid($request, $acompanhamento);
        
        if ($validator->fails()) {
            return redirect()->route('gestor.acompanhamento.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }
        $acompanhamento->cliente_id = auth('gestor')->user()->cliente_id;
        $acompanhamento->fazenda_id = auth('gestor')->user()->fazenda_id;
        $acompanhamento->usuario_id = auth('gestor')->user()->id;
        $acompanhamento->viveiro_id = $request->viveiro_id;
        $acompanhamento->horario = $request->save_hour;
        $acompanhamento->arracoamento = $request->save_message;
        $acompanhamento->producao_id = $request->producao_id;
        $acompanhamento->producao_horario_id = $request->producao_horario_id;
        $acompanhamento->data = date('Y-m-d H:i:s');
        $acompanhamento->situacao = 1;

        $acompanhamento->save();

        if($request->qtd_lote){
            $produto = \App\Models\Produto::findOrFail($request->produto_id);

            $produto->quantidade = intval($produto->quantidade) - intval($request->qtd_lote);
            $produto->save();
        }

        return redirect()->route('gestor.acompanhamento.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro alterado com sucesso!'
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $acompanhamento = \App\Models\Acompanhamento::findOrFail($id);
        $acompanhamento->delete();

        return redirect()->route('gestor.acompanhamento.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }
}
