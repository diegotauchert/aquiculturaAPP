<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VaiPraOndeController extends Controller
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
            $posts = \App\Models\VaiPraOnde::where('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('texto', 'like', '%' . $f_p . '%')
                    ->orWhere('seo_keyword', 'like', '%' . $f_p . '%')
                    ->orWhere('seo_description', 'like', '%' . $f_p . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(15);
        } else {
            $posts = \App\Models\VaiPraOnde::orderBy('id', 'desc')->paginate(15);
        }

        return view('gestor.vaipraonde.lista', compact('posts', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new \App\Models\VaiPraOnde;

        $s_categorias = \App\Models\VaiPraOndeCategoria::where('situacao', '=', 1)
                        ->orderBy('nome', 'asc')->get();
        ;

        return view('gestor.vaipraonde.edita', compact('post', 's_categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new \App\Models\VaiPraOnde;

        $validator = $this->valid($request, $post);
        if ($validator->fails()) {
            return redirect()->route('gestor.vaipraonde.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $post->nome = $request->f_nome;
        $post->local = $request->f_local;
        $post->instagram = $request->f_instagram;
        $post->video = $request->f_video;
        $post->data = $request->f_data . ' ' . $request->f_hora;
        $post->texto = $request->f_texto;
        $post->situacao = $request->f_situacao;

        $post->resetSEOKeywordAttribute();
        foreach ($request->f_seo_keyword as $f_seo_keyword) {
            $post->setSEOKeywordAttribute($f_seo_keyword);
        }

        $post->seo_description = $request->f_seo_description;
        $post->categoria_id = $request->f_categoria;

        $post->save();

        return redirect()->route('gestor.vaipraonde.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request, $post)
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
        return redirect()->route('gestor.vaipraonde.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = \App\Models\VaiPraOnde::findOrFail($id);

        $s_categorias = \App\Models\VaiPraOndeCategoria::where('situacao', '=', 1)
                        ->orderBy('nome', 'asc')->get();
        ;

        return view('gestor.vaipraonde.edita', compact('post', 's_categorias'));
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
        $post = \App\Models\VaiPraOnde::findOrFail($id);

        $validator = $this->valid($request, $post);
        if ($validator->fails()) {
            return redirect()->route('gestor.vaipraonde.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $post->nome = $request->f_nome;
        $post->local = $request->f_local;
        $post->instagram = $request->f_instagram;
        $post->video = $request->f_video;
        $post->data = $request->f_data . ' ' . $request->f_hora;
        $post->texto = $request->f_texto;
        $post->situacao = $request->f_situacao;

        $post->resetSEOKeywordAttribute();
        foreach ($request->f_seo_keyword as $f_seo_keyword) {
            $post->setSEOKeywordAttribute($f_seo_keyword);
        }

        $post->seo_description = $request->f_seo_description;
        $post->categoria_id = $request->f_categoria;


        $post->save();

        $this->anexos($request, $post);

        return redirect()->route('gestor.vaipraonde.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro alterado com sucesso!'
        ]);
    }

    public function anexos(Request $request, $post)
    {
        if ($request->f_foto) {
            if (count($request->f_foto['descricao']) > 0) {
                $k = 0;
                foreach ($request->f_foto['descricao'] as $k => $descricao) {
                    $anexo = \App\Models\VaiPraOndeAnexo::find($request->f_foto['codigo'][$k]);
                    $anexo->descricao = $descricao ? $descricao : ' ';
                    $anexo->ordem = $k + 1;
                    $anexo->save();
                }
            }
        }

        if ($request->f_arquivo) {
            if (count($request->f_arquivo['descricao']) > 0) {
                $k = 0;
                foreach ($request->f_arquivo['descricao'] as $k => $descricao) {
                    $anexo = \App\Models\VaiPraOndeAnexo::find($request->f_arquivo['codigo'][$k]);
                    $anexo->descricao = $descricao ? $descricao : ' ';
                    $anexo->ordem = $k + 1;
                    $anexo->save();
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = \App\Models\VaiPraOnde::findOrFail($id);
        $post->delete();

        return redirect()->route('gestor.vaipraonde.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }
}
