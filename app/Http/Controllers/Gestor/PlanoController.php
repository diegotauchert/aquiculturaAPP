<?php

namespace App\Http\Controllers\Gestor;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PlanoController extends Controller
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
        if(auth('gestor')->user()->tipo <= 4){
            $f_p = $request->f_p;

            if ($f_p) {
                $planos = \App\Models\Plano::where('nome', 'like', '%' . $f_p . '%')
                        ->orWhere('nome', 'like', '%' . $f_p . '%')
                        ->orderBy('id', 'desc')
                        ->paginate(10);
            } else {
                $planos = \App\Models\Plano::orderBy('id', 'desc')->paginate(10);
            }
        }

        return view('gestor.planos.lista', compact('planos', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth('gestor')->user()->tipo <= 4){
            $plano = new \App\Models\Plano;
        }

        return view('gestor.planos.edita', compact('plano'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $plano = new \App\Models\Plano;

        $validator = $this->valid($request, $plano);
        if ($validator->fails()) {
            return redirect()->route('gestor.planos.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $plano->nome = $request->f_nome;
        $plano->qtd_viveiros = $request->f_qtd_viveiros;
        $plano->valor = $request->f_valor;
        $plano->carencia = 0;
        $plano->situacao = $request->f_situacao;

        $plano->save();

        return redirect()->route('gestor.planos.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request)
    {
        $validator = validator($request->all(), [
            'f_nome' => 'required|max:250',
            'f_qtd_viveiros' => 'required|numeric',
            'f_valor' => 'required|max:250',
            'f_situacao' => 'required|numeric',
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
        return redirect()->route('gestor.planos.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth('gestor')->user()->tipo <= 4){
            $plano = \App\Models\Plano::findOrFail($id);
        }

        return view('gestor.planos.edita', compact('plano'));
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
        $plano = \App\Models\Plano::findOrFail($id);

        $validator = $this->valid($request, $plano);
        
        if ($validator->fails()) {
            return redirect()->route('gestor.planos.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $plano->nome = $request->f_nome;
        $plano->qtd_viveiros = $request->f_qtd_viveiros;
        $plano->valor = $request->f_valor;
        $plano->carencia = 0;
        $plano->situacao = $request->f_situacao;

        $plano->save();

        return redirect()->route('gestor.planos.index')
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
        $plano = \App\Models\Plano::findOrFail($id);
        $plano->delete();

        return redirect()->route('gestor.planos.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }
}
