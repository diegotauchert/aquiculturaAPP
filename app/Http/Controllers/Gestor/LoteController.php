<?php

namespace App\Http\Controllers\Gestor;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoteController extends Controller
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
            $produtos = \App\Models\Lote::where('cliente_id', auth('gestor')->user()->cliente_id)
                    ->where('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('nome', 'like', '%' . $f_p . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(15);
        } else {
            $produtos = \App\Models\Lote::where('cliente_id', auth('gestor')->user()->cliente_id)->orderBy('id', 'desc')->paginate(15);
        }

        $cliente = null;
        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }

        return view('gestor.produtos.lista', compact('produtos', 'cliente', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $lote = new \App\Models\Lote;
        $produto = \App\Models\Produto::where('cliente_id', auth('gestor')->user()->cliente_id)
            ->findOrFail($request->id);

        $fazendas = \App\Models\Fazenda::where('cliente_id', auth('gestor')->user()->cliente_id)->get();

        $cliente = null;
        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }

        return view('gestor.produtos.lote', compact('lote', 'produto', 'cliente', 'fazendas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produto = new \App\Models\Lote;

        $validator = $this->valid($request, $produto);
        if ($validator->fails()) {
            return redirect()->route('gestor.produtos.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $produto->cliente_id = $request->cliente_id;
        $produto->fazenda_id = $request->f_fazenda;
        $produto->produto_id = $request->produto_id;
        $produto->nome = $request->f_nome;
        $produto->categoria_id = $request->f_categoria;
        $produto->quantidade = $request->f_quantidade;
        $produto->vl_unitario = $request->f_vl_unitario;
        $produto->vl_total = $request->f_vl_total;
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
            'produto_id' => 'required|numeric',
            'f_fazenda' => 'required|numeric',
            'f_categoria' => 'required|numeric',
            'f_nome' => 'required|max:250',
            'f_situacao' => 'required|numeric',
            'f_quantidade' => 'required|numeric',
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
        $produto = \App\Models\Lote::findOrFail($id);
        $fazendas = \App\Models\Fazenda::where('cliente_id', auth('gestor')->user()->cliente_id)->get();

        $cliente = null;
        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }

        return view('gestor.produtos.lote', compact('produto', 'cliente', 'fazendas'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lote = \App\Models\Lote::findOrFail($id);
        $lote->delete();

        return redirect()->route('gestor.produtos.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }
}
