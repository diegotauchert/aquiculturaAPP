<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EstadoController extends Controller
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
            $estados = \App\Models\Estado::where('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('sigla', 'like', '%' . $f_p . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(10);
        } else {
            $estados = \App\Models\Estado::orderBy('id', 'desc')->paginate(10);
        }

        return view('gestor.estados.lista', compact('estados', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estado = new \App\Models\Estado;
        return view('gestor.estados.edita', compact('estado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $estado = new \App\Models\Estado;

        $validator = $this->valid($request, $estado);
        if ($validator->fails()) {
            return redirect()->route('gestor.estados.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $estado->nome = $request->f_nome;
        $estado->sigla = $request->f_sigla;
        $estado->save();
        return redirect()->route('gestor.estados.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request, $estado)
    {
        $validator = validator($request->all(), [
            'f_nome' => 'required|max:250',
            'f_sigla' => 'required|max:2'
        ]);

        return $validator;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function json()
    {
        $estados = \App\Models\Estado::all('id', 'nome', 'sigla');
        return $estados->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('gestor.estados.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $estado = \App\Models\Estado::findOrFail($id);
        return view('gestor.estados.edita', compact('estado'));
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
        $estado = \App\Models\Estado::findOrFail($id);

        $validator = $this->valid($request, $estado);
        if ($validator->fails()) {
            return redirect()->route('gestor.estados.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $estado->nome = $request->f_nome;
        $estado->sigla = $request->f_sigla;
        $estado->save();
        return redirect()->route('gestor.estados.index')
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
        $estado = \App\Models\Estado::findOrFail($id);
        $estado->delete();
        $estado->delete();
        return redirect()->route('gestor.estados.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }

}
