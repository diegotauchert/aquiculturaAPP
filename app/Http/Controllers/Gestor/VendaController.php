<?php

namespace App\Http\Controllers\Gestor;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Route;

class VendaController extends Controller
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

        if ($f_p) {
            $vendas = \App\Models\Venda::where('cliente_id', auth('gestor')->user()->cliente_id)
                    //->where('usuario_id', auth('gestor')->user()->id)
                    ->where('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('tipo', 'like', '%' . $f_p . '%')
                    ->orWhere('vl_total', 'like', '%' . $f_p . '%')
                    ->orWhere('vl_unitario', 'like', '%' . $f_p . '%')
                    ->orWhere('quantidade', 'like', '%' . $f_p . '%')
                    ->orWhere('minimo', 'like', '%' . $f_p . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(10);
        } else {
            $vendas = \App\Models\Venda::where('cliente_id', auth('gestor')->user()->cliente_id)
                                //->where('usuario_id', auth('gestor')->user()->id)
                                ->orderBy('id', 'desc')
                                ->paginate(10);
        }

        $venda = new \App\Models\Venda;

        return view('gestor.vendas.lista', compact('venda', 'vendas', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $venda = new \App\Models\Venda;

        $fazendas = \App\Models\Fazenda::where('cliente_id', auth('gestor')->user()->cliente_id)->get();
        
        if(!auth('gestor')->user()->fazenda_id && auth('gestor')->user()->tipo == 4){
            $viveiros = \App\Models\Viveiro::where('cliente_id', auth('gestor')->user()->cliente_id)
            ->get();
        }else{
            $viveiros = \App\Models\Viveiro::where('cliente_id', auth('gestor')->user()->cliente_id)
                ->where('fazenda_id', auth('gestor')->user()->fazenda_id)
                ->get();
        }
        
        return view('gestor.vendas.edita', compact('venda', 'viveiros', 'fazendas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $venda = new \App\Models\Venda;

        $validator = $this->valid($request, $venda);
        if ($validator->fails()) {
            return redirect()->route('gestor.vendas.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $venda->cliente_id = auth('gestor')->user()->cliente_id;
        $venda->fazenda_id = $request->f_fazenda ?? auth('gestor')->user()->fazenda_id;
        $venda->usuario_id = auth('gestor')->user()->id;
        $venda->viveiro_id = $request->f_viveiro;
        $venda->nome = $request->f_nome;
        $venda->cpf = $request->f_cpf;
        $venda->telefone = $request->f_telefone;
        $venda->vl_total = $request->f_vl_total;
        $venda->tipo = $request->f_tipo;
        $venda->detalhes = $request->f_detalhes;
        $venda->qtd_peixe = $request->f_qtd_peixe;
        $venda->vl_peixe = $request->f_vl_peixe;
        $venda->gramatura_peixe = $request->f_gramatura_peixe;
        $venda->qtd_camarao = $request->f_qtd_camarao;
        $venda->vl_camarao = $request->f_vl_camarao;
        $venda->gramatura_camarao = $request->f_gramatura_camarao;

        if($request->f_finalizado){
            $venda->situacao = 2;
        }else{
            $venda->situacao = 1;
        }
        
        if($request->f_data){
            $data = Carbon::createFromFormat('d/m/Y', $request->f_data)->format('Y-m-d H:i:s');
            $venda->data = $data;
        }

        $venda->save();

        return redirect()->route('gestor.vendas.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request)
    {
        $validator = validator($request->all(), [
            'f_viveiro' => 'required|numeric',
            'f_nome' => 'required|max:250',
            'f_cpf' => 'required|min:14|max:14',
            'f_telefone' => 'required|max:250',
            'f_qtd_peixe' => 'nullable|numeric|max:99999',
            'f_qtd_camarao' => 'nullable|numeric|max:99999',
            'f_data' => 'date_format:"d/m/Y"|nullable'
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
        return redirect()->route('gestor.vendas.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $venda = \App\Models\Venda::findOrFail($id);
        if(!auth('gestor')->user()->fazenda_id && auth('gestor')->user()->tipo == 4){
            $viveiros = \App\Models\Viveiro::where('cliente_id', auth('gestor')->user()->cliente_id)->get();
        }else{
            $viveiros = \App\Models\Viveiro::where('cliente_id', auth('gestor')->user()->cliente_id)
                ->where('fazenda_id', auth('gestor')->user()->fazenda_id)
                ->get();
        }

        $fazendas = null; 

        return view('gestor.vendas.edita', compact('venda', 'viveiros', 'fazendas'));
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
        $venda = \App\Models\Venda::findOrFail($id);

        $validator = $this->valid($request, $venda);
        
        if ($validator->fails()) {
            return redirect()->route('gestor.vendas.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }
        $venda->viveiro_id = $request->f_viveiro;
        $venda->nome = $request->f_nome;
        $venda->cpf = $request->f_cpf;
        $venda->telefone = $request->f_telefone;
        $venda->vl_total = $request->f_vl_total;
        $venda->tipo = $request->f_tipo;
        $venda->detalhes = $request->f_detalhes;
        $venda->qtd_peixe = $request->f_qtd_peixe;
        $venda->vl_peixe = $request->f_vl_peixe;
        $venda->gramatura_peixe = $request->f_gramatura_peixe;
        $venda->qtd_camarao = $request->f_qtd_camarao;
        $venda->vl_camarao = $request->f_vl_camarao;
        $venda->gramatura_camarao = $request->f_gramatura_camarao;

        if($request->f_finalizado){
            $venda->situacao = 2;
        }else{
            $venda->situacao = 1;
        }
        
        if($request->f_data){
            $data = Carbon::createFromFormat('d/m/Y', $request->f_data)->format('Y-m-d H:i:s');
            $venda->data = $data;
        }

        $venda->save();

        return redirect()->route('gestor.vendas.index')
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
        $venda = \App\Models\Venda::findOrFail($id);
        $venda->delete();

        return redirect()->route('gestor.vendas.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, \App\Models\Venda $venda)
    {
        if ($venda->id) {
            if ($request->hasFile('arquivo') && $request->file('arquivo')->isValid()) {
                return $this->uploadArquivo($request, $venda);
            }
        }

        return response()->json(['error' => 'Erro ao enviar']);
    }

    public function uploadArquivo($request, $venda)
    {
        $ret = [];

        $name = "arquivo-" . $venda->id . "-" . uniqid(date('YmdHis'));
        $extension = $request->arquivo->extension();
        $nameFile = "{$name}.{$extension}";

        $upload = $request->arquivo->storeAs($venda->uploadifyFiles['arquivo']['path'], $nameFile, $venda->uploadifyFiles['arquivo']);

        if (!$upload) {
            $ret['error'] = 'Erro ao enviar';
        } else {
            $venda->arquivo = $nameFile;
            $venda->save();

            $html = view('gestor.vendas.arquivo', compact('venda'))->render();
            return response()->json(['html' => $html]);
        }

        return response()->json($ret);
    }
}
