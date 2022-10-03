<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClienteController extends Controller
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
            $clientes = \App\Models\Cliente::where('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('texto', 'like', '%' . $f_p . '%')
                    ->orWhere('seo_keyword', 'like', '%' . $f_p . '%')
                    ->orWhere('seo_description', 'like', '%' . $f_p . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(15);
        } else {
            $clientes = \App\Models\Cliente::orderBy('id', 'desc')->paginate(15);
        }

        return view('gestor.clientes.lista', compact('clientes', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cliente = new \App\Models\Cliente;

        $s_categorias = \App\Models\CategoriaPost::where('situacao', '=', 1)
                        ->orderBy('nome', 'asc')->get();
        ;
        return view('gestor.clientes.edita', compact('cliente', 's_categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cliente = new \App\Models\Cliente;

        $validator = $this->valid($request, $cliente);
        if ($validator->fails()) {
            return redirect()->route('gestor.clientes.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $cliente->nome = $request->f_nome;
        $cliente->video = $request->f_video;
        $cliente->data = $request->f_data . ' ' . $request->f_hora;
        $cliente->texto = $request->f_texto;
        $cliente->situacao = $request->f_situacao;

        $cliente->resetSEOKeywordAttribute();
        foreach ($request->f_seo_keyword as $f_seo_keyword) {
            $cliente->setSEOKeywordAttribute($f_seo_keyword);
        }

        $cliente->seo_description = $request->f_seo_description;
        $cliente->categoria_id = $request->f_categoria;

        $cliente->save();

        return redirect()->route('gestor.clientes.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request, $cliente)
    {
        $validator = validator($request->all(), [
            'f_nome' => 'required|max:250',
            'f_situacao' => 'required|numeric',
            'f_data' => 'required|date_format:"d/m/Y"',
            'f_hora' => 'required|date_format:"H:i:s"',
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
        return redirect()->route('gestor.clientes.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = \App\Models\Cliente::findOrFail($id);

        $s_categorias = \App\Models\CategoriaPost::where('situacao', '=', 1)
                        ->orderBy('nome', 'asc')->get();

        return view('gestor.clientes.edita', compact('cliente', 's_categorias'));
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
        $cliente = \App\Models\Cliente::findOrFail($id);

        $validator = $this->valid($request, $cliente);
        if ($validator->fails()) {
            return redirect()->route('gestor.clientes.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $cliente->nome = $request->f_nome;
        $cliente->video = $request->f_video;
        $cliente->data = $request->f_data . ' ' . $request->f_hora;
        $cliente->texto = $request->f_texto;
        $cliente->situacao = $request->f_situacao;

        $cliente->resetSEOKeywordAttribute();
        foreach ($request->f_seo_keyword as $f_seo_keyword) {
            $cliente->setSEOKeywordAttribute($f_seo_keyword);
        }

        $cliente->seo_description = $request->f_seo_description;
        $cliente->categoria_id = $request->f_categoria;

        $cliente->save();

        $this->anexos($request, $cliente);

        return redirect()->route('gestor.clientes.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro alterado com sucesso!'
        ]);
    }

    public function anexos(Request $request, $cliente)
    {
        if ($request->f_foto) {
            if (count($request->f_foto['descricao']) > 0) {
                $k = 0;
                foreach ($request->f_foto['descricao'] as $k => $descricao) {
                    $anexo = \App\Models\PostAnexo::find($request->f_foto['codigo'][$k]);
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
                    $anexo = \App\Models\PostAnexo::find($request->f_arquivo['codigo'][$k]);
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
        $cliente = \App\Models\Cliente::findOrFail($id);
        $cliente->delete();
        return redirect()->route('gestor.clientes.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }
}
