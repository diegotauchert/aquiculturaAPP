<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LangController extends Controller
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
            $langs = \App\Models\Lang::where('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('sigla', 'like', '%' . $f_p . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(15);
        } else {
            $langs = \App\Models\Lang::orderBy('id', 'desc')->paginate(15);
        }

        return view('gestor.langs.lista', compact('langs', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lang = new \App\Models\Lang;
        return view('gestor.langs.edita', compact('lang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lang = new \App\Models\Lang;

        $validator = $this->valid($request, $lang);
        if ($validator->fails()) {
            return redirect()->route('gestor.langs.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $lang->nome = $request->f_nome;
        $lang->sigla = $request->f_sigla;
        $lang->situacao = $request->f_situacao;
        $lang->save();

        return redirect()->route('gestor.langs.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request, $lang)
    {
        $validator = validator($request->all(), [
            'f_nome' => 'required|max:250',
            'f_sigla' => 'required|max:250',
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
        return redirect()->route('gestor.langs.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lang = \App\Models\Lang::findOrFail($id);
        return view('gestor.langs.edita', compact('lang'));
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
        $lang = \App\Models\Lang::findOrFail($id);

        $validator = $this->valid($request, $lang);
        if ($validator->fails()) {
            return redirect()->route('gestor.langs.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $lang->nome = $request->f_nome;
        $lang->sigla = $request->f_sigla;
        $lang->situacao = $request->f_situacao;
        $lang->save();

        return redirect()->route('gestor.langs.index')
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
        $lang = \App\Models\Lang::findOrFail($id);
        $lang->delete();
        return redirect()->route('gestor.langs.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }

}
