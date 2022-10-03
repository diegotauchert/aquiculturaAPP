<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Gestor\Util;

class CidadeController extends Controller
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
            $cidades = \App\Models\Cidade::select('cidades.*')
                    ->leftJoin('estados', 'estados.id', '=', 'cidades.estado_id')
                    ->where('cidades.nome', 'like', '%' . $f_p . '%')
                    ->orWhere('cidades.ibge_code', 'like', '%' . $f_p . '%')
                    ->orWhere('estados.nome', 'like', '%' . $f_p . '%')
                    ->orWhere('estados.sigla', 'like', '%' . $f_p . '%')
                    ->orderBy('cidades.id', 'desc')
                    ->paginate(15);
        } else {
            $cidades = \App\Models\Cidade::orderBy('id', 'desc')->paginate(15);
        }

        return view('gestor.cidades.lista', compact('cidades', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cidade = new \App\Models\Cidade;
        $s_estados = \App\Models\Estado::orderBy('nome', 'asc')->get();
        return view('gestor.cidades.edita', compact('cidade', 's_estados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cidade = new \App\Models\Cidade;

        $validator = $this->valid($request, $cidade);
        if ($validator->fails()) {
            return redirect()->route('gestor.cidades.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $cidade->nome = $request->f_nome;
        $cidade->ibge_code = $request->f_ibge_code;
        $cidade->estado_id = $request->f_estado;
        $cidade->save();
        return redirect()->route('gestor.cidades.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request, $cidade)
    {
        $validator = validator($request->all(), [
            'f_nome' => 'required|max:250',
            'f_ibge_code' => 'required|numeric|unique:cidades,ibge_code' . ($cidade->id ? ',' . $cidade->id : ''),
            'f_estado' => 'required'
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
        return redirect()->route('gestor.cidades.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cidade = \App\Models\Cidade::findOrFail($id);
        $s_estados = \App\Models\Estado::orderBy('nome', 'desc')->get();
        return view('gestor.cidades.edita', compact('cidade', 's_estados'));
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
        $cidade = \App\Models\Cidade::find($id);

        $validator = $this->valid($request, $cidade);
        if ($validator->fails()) {
            return redirect()->route('gestor.cidades.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $cidade->nome = $request->f_nome;
        $cidade->ibge_code = $request->f_ibge_code;
        $cidade->estado_id = $request->f_estado;
        $cidade->save();
        return redirect()->route('gestor.cidades.index')
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
        $cidade = \App\Models\Cidade::findOrFail($id);
        $cidade->delete();
        return redirect()->route('gestor.cidades.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }

}
