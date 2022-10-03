<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VagaController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:gestor', 'auth.unique.user']);
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
            $vagas = \App\Models\Vaga::where('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('texto', 'like', '%' . $f_p . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(15);
        } else {
            $vagas = \App\Models\Vaga::orderBy('id', 'desc')->paginate(15);
        }

        return view('gestor.vagas.lista', compact('vagas', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vaga = new \App\Models\Vaga;
        
        return view('gestor.vagas.edita', compact('vaga'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vaga = new \App\Models\Vaga;

        $validator = $this->valid($request, $vaga);
        if ($validator->fails()) {
            return redirect()->route('gestor.vagas.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $vaga->nome = $request->f_nome;
        $vaga->texto = $request->f_texto;
        $vaga->situacao = $request->f_situacao;
        $vaga->save();

        return redirect()->route('gestor.vagas.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request, $vaga)
    {
        $validator = validator($request->all(), [
            'f_nome' => 'required|max:250',
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
        return redirect()->route('gestor.vagas.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vaga = \App\Models\Vaga::findOrFail($id);
        return view('gestor.vagas.edita', compact('vaga'));
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
        $vaga = \App\Models\Vaga::findOrFail($id);

        $validator = $this->valid($request, $vaga);
        if ($validator->fails()) {
            return redirect()->route('gestor.vagas.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $vaga->nome = $request->f_nome;
        $vaga->texto = $request->f_texto;
        $vaga->situacao = $request->f_situacao;
        $vaga->save();
        
        return redirect()->route('gestor.vagas.index')
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
        $vaga = \App\Models\Vaga::findOrFail($id);
        $vaga->delete();
        
        return redirect()->route('gestor.vagas.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }

}
