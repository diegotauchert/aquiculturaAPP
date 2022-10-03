<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InteressadoController extends Controller
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
            $interessados = \App\Models\Interessado::select('interessados.*')
                    ->where('interessados.nome', 'like', '%' . $f_p . '%')
                    ->orWhere('interessados.obs', 'like', '%' . $f_p . '%')
                    ->orderBy('interessados.id', 'desc')
                    ->paginate(15);
        } else {
            $interessados = \App\Models\Interessado::orderBy('id', 'desc')->paginate(15);
        }

        return view('gestor.interessados.lista', compact('interessados', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $interessado = new \App\Models\Interessado;
        return view('gestor.interessados.edita', compact('interessado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $interessado = new \App\Models\Interessado;

        $validator = $this->valid($request, $interessado);
        if ($validator->fails()) {
            return redirect()->route('gestor.interessados.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $interessado->nome = $request->f_nome;
        $interessado->email = $request->f_email;
        $interessado->obs = $request->f_obs;
        $interessado->situacao = $request->f_situacao;
        $interessado->save();

        return redirect()->route('gestor.interessados.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request, $interessado)
    {
        $validator = validator($request->all(), [
            'f_nome' => 'required|max:250',
            'f_email' => 'required|email|unique:interessados,email',
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
        return redirect()->route('gestor.interessados.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $interessado = \App\Models\Interessado::findOrFail($id);

        return view('gestor.interessados.edita', compact('interessado'));
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
        $interessado = \App\Models\Interessado::findOrFail($id);

        $validator = $this->valid($request, $interessado);
        if ($validator->fails()) {
            return redirect()->route('gestor.interessados.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $interessado->nome = $request->f_nome;
        $interessado->email = $request->f_email;
        $interessado->obs = $request->f_obs;
        $interessado->situacao = $request->f_situacao;

        $interessado->save();

        return redirect()->route('gestor.interessados.index')
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
        $interessado = \App\Models\Interessado::findOrFail($id);
        $interessado->delete();
        return redirect()->route('gestor.interessados.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }

}
