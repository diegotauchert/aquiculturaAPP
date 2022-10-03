<?php

namespace App\Http\Controllers\Gestor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Gestor\Util;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
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
            $banners = \App\Models\Banner::select('banners.*')
                    ->where('banners.nome', 'like', '%' . $f_p . '%')
                    ->orWhere('banners.texto', 'like', '%' . $f_p . '%')
                    ->orderBy('banners.id', 'desc')
                    ->paginate(15);
        } else {
            $banners = \App\Models\Banner::orderBy('id', 'desc')->paginate(15);
        }

        return view('gestor.banners.lista', compact('banners', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banner = new \App\Models\Banner;

        $s_categorias = \App\Models\BannerCategoria::where('situacao', '=', 1)
                        ->orderBy('nome', 'asc')->get();
        ;

        return view('gestor.banners.edita', compact('banner', 's_categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $banner = new \App\Models\Banner;

        $validator = $this->valid($request, $banner);
        if ($validator->fails()) {
            return redirect()->route('gestor.banners.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $banner->link = $request->f_link;
        $banner->video = $request->f_video;
        $banner->dt_inicio = $request->f_dt_inicio;
        $banner->dt_fim = $request->f_dt_fim;
        $banner->ordem = $request->f_ordem;
        $banner->tipo = $request->f_tipo;
        $banner->nome = $request->f_nome;
        $banner->categoria = $request->f_categoria;
        $banner->texto = $request->f_texto;
        $banner->situacao = $request->f_situacao;
        $banner->categoria_id = $request->f_categoria_id;

        $banner->save();

        return redirect()->route('gestor.banners.edit', ['id' => $banner->id])
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request, $banner)
    {
        $validator = validator($request->all(), [
            'f_nome' => 'required',
            'f_tipo' => 'required|numeric',
            'f_ordem' => 'nullable|numeric',
            'f_situacao' => 'required|numeric',
            'f_dt_inicio' => 'nullable|date_format:"d/m/Y"',
            'f_dt_fim' => 'nullable|required_with:f_dt_inicio|date_format:"d/m/Y"|after_or_equal:f_dt_inicio',
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
        return redirect()->route('gestor.banners.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = \App\Models\Banner::findOrFail($id);

        $s_categorias = \App\Models\BannerCategoria::where('situacao', '=', 1)
                        ->orderBy('nome', 'asc')->get();
        ;

        return view('gestor.banners.edita', compact('banner', 's_categorias'));
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
        $banner = \App\Models\Banner::findOrFail($id);

        $validator = $this->valid($request, $banner);
        if ($validator->fails()) {
            return redirect()->route('gestor.banners.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $banner->link = $request->f_link;
        $banner->video = $request->f_video;
        $banner->dt_inicio = $request->f_dt_inicio;
        $banner->dt_fim = $request->f_dt_fim;
        $banner->ordem = $request->f_ordem;
        $banner->tipo = $request->f_tipo;
        $banner->nome = $request->f_nome;
        $banner->categoria = $request->f_categoria;
        $banner->texto = $request->f_texto;
        $banner->situacao = $request->f_situacao;
        $banner->categoria_id = $request->f_categoria_id;

        $banner->save();

        return redirect()->route('gestor.banners.index')
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
        $banner = \App\Models\Banner::findOrFail($id);
        $banner->delete();
        return redirect()->route('gestor.banners.index')
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
    public function uploadDelete(Request $request, $banner)
    {
        $banner = \App\Models\Banner::findOrFail($banner);

        if ($request->nome == "arquivo") {
            if ($banner->arquivo) {
                Storage::disk($banner->uploadifyImages['arquivo']['disk'])->delete($banner->uploadifyImages['arquivo']['path'] . 'w_50/' . $banner->arquivo);
                $banner->arquivo->delete();

                $banner->arquivo = null;
                $banner->save();

                return response()->json(['ok']);
            }
        }

        if ($request->nome == "responsivo") {
            if ($banner->responsivo) {
                Storage::disk($banner->uploadifyImages['responsivo']['disk'])->delete($banner->uploadifyImages['responsivo']['path'] . 'w_50/' . $banner->responsivo);
                $banner->responsivo->delete();

                $banner->responsivo = null;
                $banner->save();

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
    public function upload(Request $request, $banner)
    {

        $banner = \App\Models\Banner::findOrFail($banner);

        if ($request->hasFile('arquivo') && $request->file('arquivo')->isValid()) {
            return $this->uploadArquivo($request, $banner);
        }

        if ($request->hasFile('responsivo') && $request->file('responsivo')->isValid()) {
            return $this->uploadResponsivo($request, $banner);
        }

        return response()->json(['error' => 'Erro ao enviar']);
    }

    public function uploadArquivo(Request $request, \App\Models\Banner $banner)
    {
        $ret = [];

        if ($banner->arquivo) {
            Storage::disk($banner->uploadifyImages['arquivo']['disk'])->delete($banner->uploadifyImages['arquivo']['path'] . 'w_50/' . $banner->arquivo);
            $banner->arquivo->delete();
        }

        $name = "arquivo-" . $banner->id . "-" . uniqid(date('YmdHis'));
        $extension = $request->arquivo->extension();
        $nameFile = "{$name}.{$extension}";

        Util::resize($request->file('arquivo'), 1030, 684);

        $upload = $request->arquivo->storeAs($banner->uploadifyImages['arquivo']['path'], $nameFile, $banner->uploadifyImages['arquivo']);

        Util::resize($request->file('arquivo'), 50, 50);

        $upload = $request->arquivo->storeAs($banner->uploadifyImages['arquivo']['path'] . 'w_50/', $nameFile, $banner->uploadifyImages['arquivo']);

        if (!$upload) {
            $ret['error'] = 'Erro ao enviar';
        } else {
            $banner->arquivo = $nameFile;
            $banner->save();

            $html = view('gestor.banners.arquivo', compact('banner'))->render();
            return response()->json(['html' => $html]);
        }

        return response()->json($ret);
    }

    public function uploadResponsivo(Request $request, \App\Models\Banner $banner)
    {
        $ret = [];

        if ($banner->responsivo) {
            Storage::disk($banner->uploadifyImages['responsivo']['disk'])->delete($banner->uploadifyImages['responsivo']['path'] . 'w_50/' . $banner->responsivo);
            $banner->responsivo->delete();
        }

        $name = "responsivo-" . $banner->id . "-" . uniqid(date('YmdHis'));
        $extension = $request->responsivo->extension();
        $nameFile = "{$name}.{$extension}";

        Util::resize($request->file('responsivo'), 600, 500);

        $upload = $request->responsivo->storeAs($banner->uploadifyImages['responsivo']['path'], $nameFile, $banner->uploadifyImages['responsivo']);

        Util::resize($request->file('responsivo'), 50, 50);

        $upload = $request->responsivo->storeAs($banner->uploadifyImages['responsivo']['path'] . 'w_50/', $nameFile, $banner->uploadifyImages['responsivo']);

        if (!$upload) {
            $ret['error'] = 'Erro ao enviar';
        } else {
            $banner->responsivo = $nameFile;
            $banner->save();

            $html = view('gestor.banners.responsivo', compact('banner'))->render();
            return response()->json(['html' => $html]);
        }

        return response()->json($ret);
    }
}
