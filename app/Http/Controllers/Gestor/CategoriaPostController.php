<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriaPostController extends Controller
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
            $categorias = \App\Models\CategoriaPost::where('nome', 'like', '%' . $f_p . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(15);
        } else {
            $categorias = \App\Models\CategoriaPost::orderBy('id', 'desc')->paginate(15);
        }

        return view('gestor.categorias-posts.lista', compact('categorias', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoria = new \App\Models\CategoriaPost;
        $s_categorias = \App\Models\CategoriaPost::where('situacao', '=', 1)
                ->orderBy('nome', 'asc')->get();
        return view('gestor.categorias-posts.edita', compact('categoria', 's_categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoria = new \App\Models\CategoriaPost;

        $validator = $this->valid($request, $categoria);
        if ($validator->fails()) {
            return redirect()->route('gestor.categorias-posts.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $categoria->nome = $request->f_nome;
        $categoria->ordem = $request->f_ordem;
        $categoria->situacao = $request->f_situacao;
        $categoria->categoria_id = $request->f_categoria;
        $categoria->save();
        return redirect()->route('gestor.categorias-posts.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request, $categoria)
    {
        $validator = validator($request->all(), [
            'f_nome' => 'required|max:250',
            'f_situacao' => 'required|numeric',
            'f_ordem' => 'nullable|numeric',
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
        return redirect()->route('gestor.categorias-posts.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = \App\Models\CategoriaPost::findOrFail($id);
        $s_categorias = \App\Models\CategoriaPost::where('situacao', '=', 1)
                ->where('id', '<>', $id)
                ->orderBy('nome', 'asc')->get();
        return view('gestor.categorias-posts.edita', compact('categoria', 's_categorias'));
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
        $categoria = \App\Models\CategoriaPost::findOrFail($id);

        $validator = $this->valid($request, $categoria);
        if ($validator->fails()) {
            return redirect()->route('gestor.categorias-posts.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $categoria->nome = $request->f_nome;
        $categoria->ordem = $request->f_ordem;
        $categoria->situacao = $request->f_situacao;
        $categoria->categoria_id = $request->f_categoria;
        $categoria->save();
        return redirect()->route('gestor.categorias-posts.index')
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
        $categoria = \App\Models\CategoriaPost::findOrFail($id);
        $categoria->delete();
        return redirect()->route('gestor.categorias-posts.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }

}
