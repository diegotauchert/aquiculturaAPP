<?php

namespace App\Http\Controllers\Gestor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Gestor\Util;
use Illuminate\Support\Facades\Storage;

class DepoimentoController extends Controller
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
            $depoimentos = \App\Models\Depoimento::select('depoimentos.*')
                    ->where('depoimentos.nome', 'like', '%' . $f_p . '%')
                    ->orWhere('depoimentos.descricao', 'like', '%' . $f_p . '%')
                    ->orderBy('depoimentos.id', 'desc')
                    ->paginate(15);
        } else {
            $depoimentos = \App\Models\Depoimento::orderBy('id', 'desc')->paginate(15);
        }

        return view('gestor.depoimentos.lista', compact('depoimentos', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $depoimento = new \App\Models\Depoimento;

        return view('gestor.depoimentos.edita', compact('depoimento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $depoimento = new \App\Models\Depoimento;

        $validator = $this->valid($request, $depoimento);
        if ($validator->fails()) {
            return redirect()->route('gestor.depoimentos.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $depoimento->ordem = $request->f_ordem;
        $depoimento->nota = $request->f_nota;
        $depoimento->nome = $request->f_nome;
        $depoimento->descricao = $request->f_descricao;
        $depoimento->situacao = $request->f_situacao;

        $depoimento->save();

        return redirect()->route('gestor.depoimentos.edit', ['id' => $depoimento->id])
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request, $depoimentos)
    {
        $validator = validator($request->all(), [
            'f_nome' => 'required',
            'f_ordem' => 'nullable|numeric',
            'f_situacao' => 'required|numeric',
            'foto' => 'mimetypes:jpg,png,gif,jpeg,bmp'
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
        return redirect()->route('gestor.depoimentos.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $depoimento = \App\Models\Depoimento::findOrFail($id);

        return view('gestor.depoimentos.edita', compact('depoimento'));
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
        $depoimento = \App\Models\Depoimento::findOrFail($id);

        $validator = $this->valid($request, $depoimento);
        if ($validator->fails()) {
            return redirect()->route('gestor.depoimentos.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $depoimento->ordem = $request->f_ordem;
        $depoimento->nota = $request->f_nota;
        $depoimento->nome = $request->f_nome;
        $depoimento->descricao = $request->f_descricao;
        $depoimento->situacao = $request->f_situacao;
        //$depoimento->foto = $request->f_foto;

        $depoimento->save();

        return redirect()->route('gestor.depoimentos.index')
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
        $depoimento = \App\Models\Depoimento::findOrFail($id);
        $depoimento->delete();
        return redirect()->route('gestor.depoimentos.index')
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
    public function uploadDelete(Request $request, \App\Models\Depoimento $depoimento)
    {
        if ($request->nome == "foto") {
            if ($depoimento->foto) {
                Storage::disk($depoimento->uploadifyImages['foto']['disk'])->delete($depoimento->uploadifyImages['foto']['path'] . 'w_50/' . $depoimento->foto);
                $depoimento->foto->delete();

                $depoimento->foto = null;
                $depoimento->save();

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
    public function upload(Request $request, \App\Models\Depoimento $depoimento)
    {
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            return $this->uploadArquivo($request, $depoimento);
        }

        return response()->json(['error' => 'Erro ao enviar']);
    }

    public function uploadArquivo(Request $request, \App\Models\Depoimento $depoimento)
    {
        $ret = [];

        if ($depoimento->foto) {
            Storage::disk($depoimento->uploadifyImages['foto']['disk'])->delete($depoimento->uploadifyImages['foto']['path'] . 'w_50/' . $depoimento->foto);
            $depoimento->foto->delete();
        }

        $name = "foto-" . $depoimento->id . "-" . uniqid(date('YmdHis'));
        $extension = $request->foto->extension();
        $nameFile = "{$name}.{$extension}";

        Util::resize($request->file('foto'), 600, 600);

        $upload = $request->foto->storeAs($depoimento->uploadifyImages['foto']['path'], $nameFile, $depoimento->uploadifyImages['foto']);

        Util::resize($request->file('foto'), 50, 50);

        $upload = $request->foto->storeAs($depoimento->uploadifyImages['foto']['path'] . 'w_50/', $nameFile, $depoimento->uploadifyImages['foto']);

        if (!$upload) {
            $ret['error'] = 'Erro ao enviar';
        } else {
            $depoimento->foto = $nameFile;
            $depoimento->save();

            $html = view('gestor.depoimentos.foto', compact('depoimento'))->render();
            return response()->json(['html' => $html]);
        }

        return response()->json($ret);
    }
}
