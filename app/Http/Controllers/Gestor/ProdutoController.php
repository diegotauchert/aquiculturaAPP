<?php

namespace App\Http\Controllers\Gestor;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProdutoController extends Controller
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
        $f_categoria = $request->f_categoria;

        if ($f_p) {
            $produtos = \App\Models\Produto::where('cliente_id', auth('gestor')->user()->cliente_id)
                    ->where('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('tipo', 'like', '%' . $f_p . '%')
                    ->orWhere('vl_total', 'like', '%' . $f_p . '%')
                    ->orWhere('vl_unitario', 'like', '%' . $f_p . '%')
                    ->orWhere('quantidade', 'like', '%' . $f_p . '%')
                    ->orWhere('minimo', 'like', '%' . $f_p . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(10);
        } else {
            $produtos = \App\Models\Produto::where('cliente_id', auth('gestor')->user()->cliente_id)->orderBy('id', 'desc')->paginate(10);
        }

        if($f_categoria){
            $produtos = \App\Models\Produto::where('cliente_id', auth('gestor')->user()->cliente_id)
                    ->where('categoria_id', $f_categoria)
                    ->orderBy('id', 'desc')
                    ->paginate(10);
        }

        $cliente = null;
        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }
        $produto = new \App\Models\Produto;

        return view('gestor.produtos.lista', compact('produto', 'produtos', 'cliente', 'f_p', 'f_categoria'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produto = new \App\Models\Produto;

        $fazendas = \App\Models\Fazenda::where('cliente_id', auth('gestor')->user()->cliente_id)->get();

        $cliente = null;
        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }

        return view('gestor.produtos.edita', compact('produto', 'cliente', 'fazendas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produto = new \App\Models\Produto;

        $validator = $this->valid($request, $produto);
        if ($validator->fails()) {
            return redirect()->route('gestor.produtos.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $produto->cliente_id = $request->cliente_id;
        $produto->fazenda_id = $request->f_fazenda;
        $produto->nome = $request->f_nome;
        $produto->categoria_id = $request->f_categoria;
        $produto->quantidade = $request->f_quantidade;
        $produto->quantidadeInicial = $request->f_quantidade;
        $produto->minimo = $request->f_minimo;
        $produto->vl_unitario = $request->f_vl_unitario;
        $produto->vl_total = $request->f_vl_total;
        $produto->tipo = $request->f_tipo;
        $produto->detalhes = $request->f_detalhes;
        $produto->situacao = $request->f_situacao;
        
        if($request->f_validade){
            $validade = Carbon::createFromFormat('d/m/Y', $request->f_validade)->format('Y-m-d H:i:s');
            $produto->validade = $validade;
        }

        $produto->save();

        return redirect()->route('gestor.produtos.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request)
    {
        $validator = validator($request->all(), [
            'cliente_id' => 'required|numeric',
            'f_fazenda' => 'required|numeric',
            'f_categoria' => 'required|numeric',
            'f_nome' => 'required|max:250',
            'f_situacao' => 'required|numeric',
            'f_quantidade' => 'required|numeric',
            'f_minimo' => 'required|numeric',
            'f_validade' => 'date_format:"d/m/Y"|nullable'
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
        return redirect()->route('gestor.produtos.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produto = \App\Models\Produto::findOrFail($id);
        $fazendas = \App\Models\Fazenda::where('cliente_id', auth('gestor')->user()->cliente_id)->get();
        $lotes = \App\Models\Lote::where('produto_id',$id)->get();

        $cliente = null;
        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }

        return view('gestor.produtos.edita', compact('produto', 'cliente', 'fazendas', 'lotes'));
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
        $produto = \App\Models\Produto::findOrFail($id);

        $validator = $this->valid($request, $produto);
        
        if ($validator->fails()) {
            return redirect()->route('gestor.produtos.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }
        $produto->fazenda_id = $request->f_fazenda;
        $produto->nome = $request->f_nome;
        $produto->categoria_id = $request->f_categoria;
        $produto->quantidade = $request->f_quantidade;
        $produto->quantidadeInicial = $request->f_quantidade;
        $produto->minimo = $request->f_minimo;
        $produto->vl_unitario = $request->f_vl_unitario;
        $produto->vl_total = $request->f_vl_total;
        $produto->tipo = $request->f_tipo;
        $produto->detalhes = $request->f_detalhes;
        $produto->situacao = $request->f_situacao;
        
        if($request->f_validade){
            $validade = Carbon::createFromFormat('d/m/Y', $request->f_validade)->format('Y-m-d H:i:s');
            $produto->validade = $validade;
        }

        $produto->save();

        return redirect()->route('gestor.produtos.index')
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
        $produto = \App\Models\Produto::findOrFail($id);
        $produto->delete();

        return redirect()->route('gestor.produtos.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }
}
