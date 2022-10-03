<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Gestor\Util;

class ColunistaCategoriaController extends Controller
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
            $categorias = \App\Models\ColunistaCategoria::where('nome', 'like', '%' . $f_p . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(15);
        } else {
            $categorias = \App\Models\ColunistaCategoria::orderBy('id', 'desc')->paginate(15);
        }

        return view('gestor.colunistas-categorias.lista', compact('categorias', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoria = new \App\Models\ColunistaCategoria;

        $s_categorias = \App\Models\ColunistaCategoria::where('situacao', '=', 1)
                ->orderBy('nome', 'asc')->get();

        return view('gestor.colunistas-categorias.edita', compact('categoria', 's_categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoria = new \App\Models\ColunistaCategoria;

        $validator = $this->valid($request, $categoria);

        if ($validator->fails()) {
            return redirect()->route('gestor.colunistas-categorias.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $categoria->nome = $request->f_nome;
        $categoria->ordem = $request->f_ordem;
        $categoria->situacao = $request->f_situacao;

        $categoria->save();

        return redirect()->route('gestor.colunistas-categorias.index')
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
        return redirect()->route('gestor.colunistas-categorias.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = \App\Models\ColunistaCategoria::findOrFail($id);
        $s_categorias = \App\Models\ColunistaCategoria::where('situacao', '=', 1)
                ->where('id', '<>', $id)
                ->orderBy('nome', 'asc')->get();

        return view('gestor.colunistas-categorias.edita', compact('categoria', 's_categorias'));
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
        $categoria = \App\Models\ColunistaCategoria::findOrFail($id);

        $validator = $this->valid($request, $categoria);

        if ($validator->fails()) {
            return redirect()->route('gestor.colunistas-categorias.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $categoria->nome = $request->f_nome;
        $categoria->ordem = $request->f_ordem;
        $categoria->situacao = $request->f_situacao;

        $categoria->save();

        return redirect()->route('gestor.colunistas-categorias.index')
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
        $categoria = \App\Models\ColunistaCategoria::findOrFail($id);
        $categoria->delete();

        return redirect()->route('gestor.colunistas-categorias.index')
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
     public function uploadDelete(Request $request, \App\Models\ColunistaCategoria $categoria)
     {
         if ($request->nome == "imagem") {
             if ($categoria->imagem) {
                 Storage::disk($categoria->uploadifyImages['imagem']['disk'])->delete($categoria->uploadifyImages['imagem']['path'] . 'w_50/' . $categoria->imagem);
                 $categoria->imagem->delete();
    
                 $categoria->imagem = null;
                 $categoria->save();
    
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
 public function upload(Request $request, $id)
 {
     $categoria = \App\Models\ColunistaCategoria::findOrFail($id);

     if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
         return $this->uploadArquivo($request, $categoria);
     }

     return response()->json(['error' => 'Erro ao enviar']);
 }

 public function uploadArquivo(Request $request, \App\Models\ColunistaCategoria $categoria)
 {
     $ret = [];

     $validator = $this->valid($request, $categoria);
    
     if ($categoria->foto) {
         Storage::disk($categoria->uploadifyImages['foto']['disk'])->delete($categoria->uploadifyImages['foto']['path'] . 'w_50/' . $categoria->foto);
         $categoria->foto->delete();
     }

     $name = "foto-" . $categoria->id . "-" . uniqid(date('YmdHis'));
     $extension = $request->foto->extension();
     $nameFile = "{$name}.{$extension}";
     
     Util::resize($request->file('foto'), 1600, 650);
     $upload = $request->foto->storeAs($categoria->uploadifyImages['foto']['path'], $nameFile, $categoria->uploadifyImages['foto']);

     Util::resize($request->file('foto'), 50, 50);
     $upload = $request->foto->storeAs($categoria->uploadifyImages['foto']['path'] . 'w_50/', $nameFile, $categoria->uploadifyImages['foto']);
     
     if (!$upload) {
         $ret['error'] = 'Erro ao enviar';
     } else {
         $categoria->foto = $nameFile;
         $categoria->save();

         $html = view('gestor.colunistas-categorias.foto', compact('categoria'))->render();
         return response()->json(['html' => $html]);
     }

     return response()->json($ret);
 }

}
