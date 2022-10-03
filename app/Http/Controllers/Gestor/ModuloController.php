<?php

namespace App\Http\Controllers\Gestor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModuloController extends Controller
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
            $modulos = \App\Models\Modulo::where('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('link', 'like', '%' . $f_p . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(15);
        } else {
            $modulos = \App\Models\Modulo::orderBy('id', 'desc')->paginate(15);
        }

        return view('gestor.modulos.lista', compact('modulos', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modulo = new \App\Models\Modulo;
        $s_modulos = \App\Models\Modulo::where('situacao', '=', 1)
                ->orderBy('nome', 'asc')->get();
        return view('gestor.modulos.edita', compact('modulo', 's_modulos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $modulo = new \App\Models\Modulo;

        $validator = $this->valid($request, $modulo);
        if ($validator->fails()) {
            return redirect()->route('gestor.modulos.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $modulo->resetLinkAttribute();
        foreach ($request->f_link as $f_link) {
            $modulo->setLinkAttribute($f_link);
        }

        $modulo->nome = $request->f_nome;
        $modulo->menu = $request->f_menu;
        $modulo->situacao = $request->f_situacao;
        $modulo->exibe = $request->f_exibe;
        $modulo->modulo_id = $request->f_modulo;

        $modulo->save();

        $this->permissao($modulo->id, 1);

        return redirect()->route('gestor.modulos.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request, $modulo)
    {
        $validator = validator($request->all(), [
            'f_nome' => 'required|max:250',
            'f_situacao' => 'required|numeric',
            'f_exibe' => 'required|numeric',
//            'f_link' => 'required|max:250|unique:modulos,link' . ($modulo->id ? ',' . $modulo->id : ''),
            'f_menu' => 'required|numeric',
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
        return redirect()->route('gestor.modulos.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $modulo = \App\Models\Modulo::findOrFail($id);
        $s_modulos = \App\Models\Modulo::where('id', '<>', $id)
                ->where('situacao', '=', 1)
                ->orderBy('id', 'asc')->orderBy('nome', 'asc')
                ->get();
        return view('gestor.modulos.edita', compact('modulo', 's_modulos'));
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
        $modulo = \App\Models\Modulo::findOrFail($id);

        $validator = $this->valid($request, $modulo);
        if ($validator->fails()) {
            return redirect()->route('gestor.modulos.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $modulo->resetLinkAttribute();
        foreach ($request->f_link as $f_link) {
            $modulo->setLinkAttribute($f_link);
        }

        $modulo->nome = $request->f_nome;
        $modulo->menu = $request->f_menu;
        $modulo->situacao = $request->f_situacao;
        $modulo->exibe = $request->f_exibe;
        $modulo->modulo_id = $request->f_modulo;
        $modulo->save();
        return redirect()->route('gestor.modulos.index')
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
        $modulo = \App\Models\Modulo::findOrFail($id);
        $modulo->delete();
        return redirect()->route('gestor.modulos.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }

    public function permissao($id, $tipo = 1) {
        $usuarios = \App\Models\Usuario::where('tipo', '=', $tipo)->get();

        foreach ($usuarios as $usuario) {
            $permissao = new \App\Models\Permissao;
            $permissao->usuario_id = $usuario->id;
            $permissao->modulo_id = $id;
            $permissao->save();
        }
    }
}
