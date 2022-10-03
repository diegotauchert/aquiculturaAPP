<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Gestor\Util;
use Illuminate\Support\Facades\Storage;

class PaginaAnexoController extends Controller
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
    public function delete(Request $request, \App\Models\PaginaAnexo $anexo)
    {
        if ($anexo->arquivo || $anexo->foto) {
            if ($anexo->foto) {
                Storage::disk($anexo->uploadifyImages['foto']['disk'])->delete($anexo->uploadifyImages['foto']['path'] . 'w_400/' . $anexo->foto);
            }

            $anexo->delete();

            return response()->json(['ok']);
        }

        return response()->json([]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, $pagina, $tipo)
    {
        $pagina = \App\Models\Pagina::find($pagina);

        if ($pagina->id) {
            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {

                return $this->uploadFoto($request, $pagina, $tipo);
            }

            if ($request->hasFile('arquivo') && $request->file('arquivo')->isValid()) {

                return $this->uploadArquivo($request, $pagina, $tipo);
            }
        }

        return response()->json(['error' => 'Erro ao enviar']);
    }

    public function uploadFoto($request, $pagina, $tipo)
    {
        $anexo = new \App\Models\PaginaAnexo([
            'tipo' => $tipo,
            'pagina_id' => $pagina->id,
        ]);
        $anexo->save();

        $ret = [];

        $name = "foto-" . $anexo->id . "-" . uniqid(date('YmdHis'));
        $extension = $request->foto->extension();
        $nameFile = "{$name}.{$extension}";

        Util::resize($request->file('foto'), 1024, 1024);

        $upload = $request->foto->storeAs($anexo->uploadifyImages['foto']['path'], $nameFile, $anexo->uploadifyImages['foto']);

        Util::resize($request->file('foto'), 400, 400);

        $upload = $request->foto->storeAs($anexo->uploadifyImages['foto']['path'] . 'w_400/', $nameFile, $anexo->uploadifyImages['foto']);

        if (!$upload) {
            $ret['error'] = 'Erro ao enviar';
        } else {
            $anexo->foto = $nameFile;
            $anexo->save();

            $html = view('gestor.paginas.foto', compact('anexo'))->render();
            return response()->json(['html' => $html]);
        }

        return response()->json($ret);
    }

    public function uploadArquivo($request, $pagina, $tipo)
    {
        $anexo = new \App\Models\PaginaAnexo([
            'tipo' => $tipo,
            'pagina_id' => $pagina->id,
        ]);
        $anexo->save();

        $ret = [];

        $name = "arquivo-" . $anexo->id . "-" . uniqid(date('YmdHis'));
        $extension = $request->arquivo->extension();
        $nameFile = "{$name}.{$extension}";

        $upload = $request->arquivo->storeAs($anexo->uploadifyFiles['arquivo']['path'], $nameFile, $anexo->uploadifyFiles['arquivo']);

        if (!$upload) {
            $ret['error'] = 'Erro ao enviar';
        } else {
            $anexo->arquivo = $nameFile;
            $anexo->save();

            $html = view('gestor.paginas.arquivo', compact('anexo'))->render();
            return response()->json(['html' => $html]);
        }

        return response()->json($ret);
    }

}
