<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaginaController extends Controller
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
            $paginas = \App\Models\Pagina::where('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('descricao', 'like', '%' . $f_p . '%')
                    ->orWhere('link', 'like', '%' . $f_p . '%')
                    ->orWhere('texto', 'like', '%' . $f_p . '%')
                    ->orWhere('seo_keyword', 'like', '%' . $f_p . '%')
                    ->orWhere('seo_description', 'like', '%' . $f_p . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(15);
        } else {
            $paginas = \App\Models\Pagina::orderBy('id', 'desc')->paginate(15);
        }

        return view('gestor.paginas.lista', compact('paginas', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pagina = new \App\Models\Pagina;

        return view('gestor.paginas.edita', compact('pagina'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pagina = new \App\Models\Pagina;

        $validator = $this->valid($request, $pagina);
        if ($validator->fails()) {
            return redirect()->route('gestor.paginas.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $pagina->nome = $request->f_nome;
        $pagina->video = $request->f_video;
        $pagina->descricao = $request->f_descricao;
        $pagina->link = $request->f_link;

        $pagina->resetEmailAttribute();

        foreach ($request->f_email as $f_email) {
            $pagina->setEmailAttribute($f_email);
        }

        $pagina->texto = $request->f_texto;
        $pagina->texto_full = $request->f_texto_full;
        $pagina->situacao = $request->f_situacao;

        $pagina->resetSEOKeywordAttribute();
        foreach ($request->f_seo_keyword as $f_seo_keyword) {
            $pagina->setSEOKeywordAttribute($f_seo_keyword);
        }

        $pagina->seo_description = $request->f_seo_description;
        $pagina->save();

        return redirect()->route('gestor.paginas.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request, $pagina)
    {
        $validator = validator($request->all(), [
            'f_nome' => 'required|max:250',
            'f_situacao' => 'required|numeric',
            'f_texto_full' => 'required|numeric',
            'f_link' => 'required|max:250|unique:paginas,link' . ($pagina->id ? ',' . $pagina->id : ''),
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
        return redirect()->route('gestor.paginas.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pagina = \App\Models\Pagina::findOrFail($id);

        return view('gestor.paginas.edita', compact('pagina'));
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
        $pagina = \App\Models\Pagina::findOrFail($id);

        $validator = $this->valid($request, $pagina);
        if ($validator->fails()) {
            return redirect()->route('gestor.paginas.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $pagina->nome = $request->f_nome;
        $pagina->video = $request->f_video;
        $pagina->descricao = $request->f_descricao;
        $pagina->link = $request->f_link;

        $pagina->resetEmailAttribute();
        foreach ($request->f_email as $f_email) {
            $pagina->setEmailAttribute($f_email);
        }

        $pagina->texto = $request->f_texto;
        $pagina->texto_full = $request->f_texto_full;
        $pagina->situacao = $request->f_situacao;

        $pagina->resetSEOKeywordAttribute();
        foreach ($request->f_seo_keyword as $f_seo_keyword) {
            $pagina->setSEOKeywordAttribute($f_seo_keyword);
        }

        $pagina->seo_description = $request->f_seo_description;
        $pagina->save();

        $this->anexos($request, $pagina);

        return redirect()->route('gestor.paginas.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro alterado com sucesso!'
        ]);
    }

    public function anexos(Request $request, $pagina)
    {
        if ($request->f_foto) {
            if (count($request->f_foto['descricao']) > 0) {
                $k = 0;
                foreach ($request->f_foto['descricao'] as $k => $descricao) {
                    $anexo = \App\Models\PaginaAnexo::find($request->f_foto['codigo'][$k]);
                    $anexo->descricao = $descricao;
                    $anexo->ordem = $k + 1;
                    $anexo->save();
                }
            }
        }

        if ($request->f_arquivo) {
            if (count($request->f_arquivo['descricao']) > 0) {
                $k = 0;
                foreach ($request->f_arquivo['descricao'] as $k => $descricao) {
                    $anexo = \App\Models\PaginaAnexo::find($request->f_arquivo['codigo'][$k]);
                    $anexo->descricao = $descricao;
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
        $pagina = \App\Models\Pagina::findOrFail($id);
        $pagina->delete();

        return redirect()->route('gestor.paginas.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }
}
