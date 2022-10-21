<?php

namespace App\Http\Controllers\Gestor;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ViveiroController extends Controller
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
            $viveiros = \App\Models\Viveiro::where('cliente_id', auth('gestor')->user()->cliente_id)
                    ->where('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('email', 'like', '%' . $f_p . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(10);
        } else {
            $viveiros = \App\Models\Viveiro::where('cliente_id', auth('gestor')->user()->cliente_id)->orderBy('id', 'desc')->paginate(10);
        }

        $cliente = null;
        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }

        return view('gestor.viveiros.lista', compact('viveiros', 'cliente', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $viveiro = new \App\Models\Viveiro;

        $fazendas = \App\Models\Fazenda::where('cliente_id', auth('gestor')->user()->cliente_id)->get();

        $cliente = null;
        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }

        return view('gestor.viveiros.edita', compact('viveiro', 'cliente', 'fazendas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $viveiro = new \App\Models\Viveiro;
        $cultivo = new \App\Models\Cultivo;

        $validator = $this->valid($request, $viveiro);
        if ($validator->fails()) {
            return redirect()->route('gestor.viveiros.create')
                            ->withErrors($validator)
                            ->withInput();
        }
        $viveiro->cliente_id = $request->cliente_id;
        $viveiro->fazenda_id = $request->f_fazenda;
        $viveiro->nome = $request->f_nome;
        $viveiro->comprimento = $request->f_comprimento;
        $viveiro->largura = $request->f_largura;
        $viveiro->profundidade = $request->f_profundidade;
        $viveiro->volume = $request->f_volume;
        $viveiro->area = $request->f_area;
        $viveiro->detalhes = $request->f_detalhes;
        $viveiro->situacao = $request->f_situacao;

        $viveiro->save();

        $cultivo->situacao = 3;
        $cultivo->categoria_id = 1;
        $cultivo->cliente_id = $request->cliente_id;
        $cultivo->fazenda_id = $request->f_fazenda;
        $cultivo->viveiro_id = $viveiro->id;
        $cultivo->usuario_id = auth('gestor')->user()->id;
        $cultivo->nome = "Cultivo para o Viveiro (".$request->f_nome.")";

        $cultivo->save();

        return redirect()->route('gestor.viveiros.index')
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
            'f_nome' => 'required|max:250',
            'f_situacao' => 'required|numeric'
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
        return redirect()->route('gestor.viveiros.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $viveiro = \App\Models\Viveiro::findOrFail($id);
        
        $fazendas = \App\Models\Fazenda::where('cliente_id', auth('gestor')->user()->cliente_id)
                                        ->get();

        $cliente = null;
        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }

        return view('gestor.viveiros.edita', compact('viveiro', 'cliente', 'fazendas'));
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
        $viveiro = \App\Models\Viveiro::findOrFail($id);

        $validator = $this->valid($request, $viveiro);
        
        if ($validator->fails()) {
            return redirect()->route('gestor.viveiros.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }
        $viveiro->cliente_id = $request->cliente_id;
        $viveiro->fazenda_id = $request->f_fazenda;
        $viveiro->nome = $request->f_nome;
        $viveiro->comprimento = $request->f_comprimento;
        $viveiro->largura = $request->f_largura;
        $viveiro->profundidade = $request->f_profundidade;
        $viveiro->volume = $request->f_volume;
        $viveiro->area = $request->f_area;
        $viveiro->detalhes = $request->f_detalhes;
        $viveiro->situacao = $request->f_situacao;

        $viveiro->save();

        return redirect()->route('gestor.viveiros.index')
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
        $viveiro = \App\Models\Viveiro::findOrFail($id);
        $viveiro->delete();

        $cultivo = \App\Models\Cultivo::where('viveiro_id', $id);
        $cultivo->delete();

        return redirect()->route('gestor.viveiros.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }
}
