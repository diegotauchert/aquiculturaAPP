<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegiaoController extends Controller
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
            $regioes = \App\Models\Regiao::where('nome', 'like', '%' . $f_p . '%')
                ->orderBy('id', 'desc')
                ->paginate(10);
        } else {
            $regioes = \App\Models\Regiao::orderBy('id', 'desc')->paginate(10);
        }

        return view('gestor.regioes.lista', compact('regioes', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regiao = new \App\Models\Regiao;

        return view('gestor.regioes.edita', compact('regiao'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $regiao = new \App\Models\Regiao;

        $validator = $this->valid($request, $regiao);
        if ($validator->fails()) {
            return redirect()->route('gestor.regioes.create')
                ->withErrors($validator)
                ->withInput();
        }

        $regiao->nome = $request->f_nome;
        $regiao->pontos = $request->f_pontos;
        $regiao->situacao = $request->f_situacao;
        $regiao->save();

        return redirect()->route('gestor.regioes.edit', ['id' => $regiao->id])
            ->with('alert', [
                'type' => 'success',
                'message' => 'Registro incluído com sucesso!'
            ]);
    }

    public function valid(Request $request, $regiao)
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
        return redirect()->route('gestor.regioes.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $regiao = \App\Models\Regiao::findOrFail($id);
        return view('gestor.regioes.edita', compact('regiao'));
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
        $regiao = \App\Models\Regiao::findOrFail($id);

        $validator = $this->valid($request, $regiao);
        if ($validator->fails()) {
            return redirect()->route('gestor.regioes.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $regiao->nome = $request->f_nome;
        $regiao->pontos = $request->f_pontos;
        $regiao->situacao = $request->f_situacao;
        $regiao->save();

        return redirect()->route('gestor.regioes.index')
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
        $regiao = \App\Models\Regiao::findOrFail($id);
        $regiao->delete();

        return redirect()->route('gestor.regioes.index')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Registro excluído com sucesso!'
            ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadDelete(Request $request, \App\Models\Regiao $regiao)
    {
        if ($request->nome == "arquivo") {
            if ($regiao->arquivo) {
                $regiao->arquivo->delete();

                $regiao->arquivo = null;
                $regiao->save();

                return response()->json(['ok']);
            }
        }

        return response()->json([]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, \App\Models\Regiao $regiao)
    {
        if ($request->hasFile('arquivo') && $request->file('arquivo')->isValid()) {
            $ret = [];

            if ($regiao->arquivo) {
                $regiao->arquivo->delete();
            }

            $name = "arquivo-" . $regiao->id . "-" . uniqid(date('YmdHis'));
            $extension = $request->arquivo->extension();
            $nameFile = "{$name}.{$extension}";

            $upload = $request->arquivo->storeAs($regiao->uploadifyFiles['arquivo']['path'], $nameFile, $regiao->uploadifyFiles['arquivo']);

            if (!$upload) {
                $ret['error'] = 'Erro ao enviar';
            } else {
                $regiao->arquivo = $nameFile;
                $regiao->save();

                $html = view('gestor.regioes.arquivo', compact('regiao'))->render();
                return response()->json(['html' => $html]);
            }

            return response()->json($ret);
        }

        return response()->json(['error' => 'Erro ao enviar']);
    }
}
