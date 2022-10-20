<?php

namespace App\Http\Controllers\Gestor;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProducaoController extends Controller
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
        $viveiros = \App\Models\Viveiro::where('cliente_id', auth('gestor')->user()->cliente_id)->get();
        return view('gestor.producao.lista', compact('viveiros'));
    }

    public function categoria($viveiro_id)
    {
        $viveiro = \App\Models\Viveiro::where('cliente_id', auth('gestor')->user()->cliente_id)->where('id', $viveiro_id)->first();
        if(!$viveiro){
            return redirect()->route('gestor.producao.index')
                            ->withInput();
        }

        $producao = new \App\Models\Producao;
        
        return view('gestor.producao.categoria', compact('viveiro', 'producao'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save($viveiro_id, $categoria_id)
    {
        $viveiro = \App\Models\Viveiro::where('cliente_id', auth('gestor')->user()->cliente_id)->where('id', $viveiro_id)->first();
        if(!$viveiro){
            return redirect()->route('gestor.producao.index')
                            ->withInput();
        }

        $produtos = \App\Models\Produto::where('cliente_id', auth('gestor')->user()->cliente_id)
                            ->where('fazenda_id', auth('gestor')->user()->fazenda_id)
                            ->get();

        $producao = new \App\Models\Producao;
        $producao->categoria_id = $categoria_id;

        $racao = null;
        $racaoHorario = [];
        $acompanhamentos = null;

        if($categoria_id == 1){
            $racao = \App\Models\Producao::where('categoria_id', $categoria_id)
                                            ->where('fazenda_id', auth('gestor')->user()->fazenda_id)
                                            ->where('cliente_id', auth('gestor')->user()->cliente_id)
                                            ->where('viveiro_id', $viveiro_id)
                                            ->orderBy('id', 'DESC')
                                            ->first();
            if($racao && $racao->id){
                $racaoHorario = \App\Models\ProducaoHorario::where('fazenda_id', auth('gestor')->user()->fazenda_id)
                                            ->where('cliente_id', auth('gestor')->user()->cliente_id)
                                            ->where('viveiro_id', $viveiro_id)
                                            ->where('producao_id', $racao->id)
                                            ->get();
            }
        }else{
            $acompanhamentos = \App\Models\Producao::where('categoria_id', $categoria_id)
                                            ->where('fazenda_id', auth('gestor')->user()->fazenda_id)
                                            ->where('cliente_id', auth('gestor')->user()->cliente_id)
                                            ->where('viveiro_id', $viveiro_id)
                                            ->orderBy('id', 'DESC')
                                            ->limit(20)
                                            ->get();
                                        }

        return view('gestor.producao.edita', compact('producao', 'produtos', 'viveiro', 'categoria_id', 'racao', 'racaoHorario', 'acompanhamentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $producao = new \App\Models\Producao;

        return view('gestor.producao.edita', compact('producao'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $producao = new \App\Models\Producao;

        $validator = $this->valid($request, $producao);
        if ($validator->fails()) {
            return redirect()->route('gestor.producao.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $producao->cliente_id = auth('gestor')->user()->cliente_id;
        $producao->fazenda_id = auth('gestor')->user()->fazenda_id;
        $producao->usuario_id = auth('gestor')->user()->id;
        $producao->viveiro_id = $request->f_viveiro;
        $producao->categoria_id = $request->f_categoria;
        $producao->qtd = $request->f_qtd;
        $producao->produto_id = $request->f_produto;
        $producao->ph = $request->f_ph;
        $producao->salinidade = $request->f_salinidade;
        $producao->turbidez = $request->f_turbidez;
        $producao->alcalinidade = $request->f_alcalinidade;
        $producao->oxigenio = $request->f_oxigenio;
        $producao->temperatura = $request->f_temperatura;
        $producao->gramatura = $request->f_gramatura;
        $producao->tara = $request->f_tara;
        $producao->situacao = 1;
        
        if($request->f_despesca){
            $despesca = Carbon::createFromFormat('d/m/Y', $request->f_despesca)->format('Y-m-d H:i:s');
            $producao->despesca = $despesca;
        }

        $producao->save();

        $this->storeHorario($request, $producao);

        return redirect()->route('gestor.producao.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function storeHorario(Request $request, \App\Models\Producao $producao)
    {
        if($request->f_horario){
            foreach($request->f_horario as $key => $horario){
                $producaoHorario = $request->f_horario_id[$key] ? \App\Models\ProducaoHorario::find($request->f_horario_id[$key]) : new \App\Models\ProducaoHorario;

                $producaoHorario->cliente_id = auth('gestor')->user()->cliente_id;
                $producaoHorario->fazenda_id = auth('gestor')->user()->fazenda_id;
                $producaoHorario->usuario_id = auth('gestor')->user()->id;
                $producaoHorario->viveiro_id = $request->f_viveiro;
                $producaoHorario->producao_id = $producao->id;
                $producaoHorario->hora = $horario;
                
                $producaoHorario->save();
            }
        }
    }

    public function valid(Request $request)
    {
        $validator = validator($request->all(), [
            'f_categoria' => 'required|numeric',
            'f_viveiro' => 'required|numeric'
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
        return redirect()->route('gestor.producao.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producao = \App\Models\Producao::findOrFail($id);
        
        return view('gestor.producao.edita', compact('producao'));
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
        $producao = \App\Models\Producao::find($id);

        $validator = $this->valid($request, $producao);
        if ($validator->fails()) {
            return redirect()->route('gestor.producao.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $producao->cliente_id = auth('gestor')->user()->cliente_id;
        $producao->fazenda_id = auth('gestor')->user()->fazenda_id;
        $producao->usuario_id = auth('gestor')->user()->id;
        $producao->viveiro_id = $request->f_viveiro;
        $producao->categoria_id = $request->f_categoria;
        $producao->qtd = $request->f_qtd;
        $producao->produto_id = $request->f_produto;
        $producao->ph = $request->f_ph;
        $producao->salinidade = $request->f_salinidade;
        $producao->turbidez = $request->f_turbidez;
        $producao->alcalinidade = $request->f_alcalinidade;
        $producao->oxigenio = $request->f_oxigenio;
        $producao->temperatura = $request->f_temperatura;
        $producao->gramatura = $request->f_gramatura;
        $producao->tara = $request->f_tara;
        $producao->situacao = 1;
        
        if($request->f_despesca){
            $despesca = Carbon::createFromFormat('d/m/Y', $request->f_despesca)->format('Y-m-d H:i:s');
            $producao->despesca = $despesca;
        }

        $producao->save();

        $this->storeHorario($request, $producao);

        return redirect()->route('gestor.producao.index')
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
        $producao = \App\Models\Producao::findOrFail($id);
        $producao->delete();

        return redirect()->route('gestor.producao.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }
}
