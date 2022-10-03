<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DownloadController extends Controller
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
            $downloads = \App\Models\Download::where('nome', 'like', '%' . $f_p . '%')
                ->orWhere('link', 'like', '%' . $f_p . '%')
                ->orderBy('id', 'desc')
                ->paginate(15);
        } else {
            $downloads = \App\Models\Download::orderBy('id', 'desc')->paginate(15);
        }

        return view('gestor.downloads.lista', compact('downloads', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $download = new \App\Models\Download;

        return view('gestor.downloads.edita', compact('download'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $download = new \App\Models\Download;

        $validator = $this->valid($request, $download);
        if ($validator->fails()) {
            return redirect()->route('gestor.downloads.create')
                ->withErrors($validator)
                ->withInput();
        }

        $download->nome = $request->f_nome;
        $download->descricao = $request->f_descricao;
        $download->link = $request->f_link;
        $download->situacao = $request->f_situacao;
        $download->save();

        return redirect()->route('gestor.downloads.edit', ['id' => $download->id])
            ->with('alert', [
                'type' => 'success',
                'message' => 'Registro incluído com sucesso!'
            ]);
    }

    public function valid(Request $request, $download)
    {
        $validator = validator($request->all(), [
            'f_nome' => 'required|max:250',
            'f_link' => 'nullable|url',
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
        return redirect()->route('gestor.downloads.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $download = \App\Models\Download::findOrFail($id);
        return view('gestor.downloads.edita', compact('download'));
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
        $download = \App\Models\Download::findOrFail($id);

        $validator = $this->valid($request, $download);
        if ($validator->fails()) {
            return redirect()->route('gestor.downloads.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $download->nome = $request->f_nome;
        $download->descricao = $request->f_descricao;
        $download->link = $request->f_link;
        $download->situacao = $request->f_situacao;
        $download->save();

        return redirect()->route('gestor.downloads.index')
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
        $download = \App\Models\Download::findOrFail($id);
        $download->delete();

        return redirect()->route('gestor.downloads.index')
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
    public function uploadDelete(Request $request, \App\Models\Download $download)
    {
        if ($request->nome == "arquivo") {
            if ($download->arquivo) {
                $download->arquivo->delete();

                $download->arquivo = null;
                $download->save();

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
    public function upload(Request $request, \App\Models\Download $download)
    {
        if ($request->hasFile('arquivo') && $request->file('arquivo')->isValid()) {
            $ret = [];

            if ($download->arquivo) {
                $download->arquivo->delete();
            }

            $name = "arquivo-" . $download->id . "-" . uniqid(date('YmdHis'));
            $extension = $request->arquivo->extension();
            $nameFile = "{$name}.{$extension}";

            $upload = $request->arquivo->storeAs($download->uploadifyFiles['arquivo']['path'], $nameFile, $download->uploadifyFiles['arquivo']);

            if (!$upload) {
                $ret['error'] = 'Erro ao enviar';
            } else {
                $download->arquivo = $nameFile;
                $download->save();

                $html = view('gestor.downloads.arquivo', compact('download'))->render();
                return response()->json(['html' => $html]);
            }

            return response()->json($ret);
        }

        return response()->json(['error' => 'Erro ao enviar']);
    }
}
