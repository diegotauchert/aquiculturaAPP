<?php

namespace App\Http\Controllers\Gestor;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Route;

class MensagemController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:gestor']);
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
            $mensagens = \App\Models\Mensagem::where('cliente_id', auth('gestor')->user()->cliente_id)
                    ->where('usuario_id_remetente', auth('gestor')->user()->id)
                    ->where('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('tipo', 'like', '%' . $f_p . '%')
                    ->orWhere('vl_total', 'like', '%' . $f_p . '%')
                    ->orWhere('vl_unitario', 'like', '%' . $f_p . '%')
                    ->orWhere('quantidade', 'like', '%' . $f_p . '%')
                    ->orWhere('minimo', 'like', '%' . $f_p . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(15);
        } else {
            $mensagens = \App\Models\Mensagem::where('cliente_id', auth('gestor')->user()->cliente_id)->where('usuario_id_remetente', auth('gestor')->user()->id)->orderBy('id', 'desc')->paginate(15);
        }

        $cliente = null;
        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }
        $mensagem = new \App\Models\Mensagem;

        return view('gestor.mensagens.lista', compact('mensagem', 'mensagens', 'cliente', 'f_p'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function recebidas(Request $request)
    {
        $f_p = $request->f_p;

        if ($f_p) {
            $mensagens = \App\Models\Mensagem::where('cliente_id', auth('gestor')->user()->cliente_id)
                    ->where('usuario_id_destino', auth('gestor')->user()->id)
                    ->where('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('tipo', 'like', '%' . $f_p . '%')
                    ->orWhere('vl_total', 'like', '%' . $f_p . '%')
                    ->orWhere('vl_unitario', 'like', '%' . $f_p . '%')
                    ->orWhere('quantidade', 'like', '%' . $f_p . '%')
                    ->orWhere('minimo', 'like', '%' . $f_p . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(15);
        } else {
            $mensagens = \App\Models\Mensagem::where('cliente_id', auth('gestor')->user()->cliente_id)->where('usuario_id_destino', auth('gestor')->user()->id)->orderBy('id', 'desc')->paginate(15);
        }

        $cliente = null;
        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }
        $mensagem = new \App\Models\Mensagem;

        return view('gestor.mensagens.recebida', compact('mensagem', 'mensagens', 'cliente', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ver = false;
        $mensagem = new \App\Models\Mensagem;

        $fazendas = \App\Models\Fazenda::where('cliente_id', auth('gestor')->user()->cliente_id)->get();
        $usuarios = \App\Models\Usuario::where('cliente_id', auth('gestor')->user()->cliente_id)->where('id', '!=', auth('gestor')->user()->id)->get();

        $cliente = null;
        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }

        return view('gestor.mensagens.edita', compact('mensagem', 'cliente', 'fazendas', 'usuarios', 'ver'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mensagem = new \App\Models\Mensagem;

        $validator = $this->valid($request, $mensagem);
        if ($validator->fails()) {
            return redirect()->route('gestor.mensagens.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $mensagem->cliente_id = $request->cliente_id;
        $mensagem->fazenda_id = $request->f_fazenda;
        $mensagem->usuario_id_remetente = auth('gestor')->user()->id;
        $mensagem->usuario_id_destino = $request->f_usuario_destino;
        $mensagem->categoria_id = $request->f_categoria;
        $mensagem->mensagem = $request->f_detalhes;
        $mensagem->situacao = 1;
        
        if($request->f_data){
            $data = Carbon::createFromFormat('d/m/Y', $request->f_data)->format('Y-m-d H:i:s');
            $mensagem->data = $data;
        }

        $mensagem->save();

        return redirect()->route('gestor.mensagens.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request)
    {
        $validator = validator($request->all(), [
            'cliente_id' => 'required|numeric',
            'f_fazenda' => 'required|numeric',
            'f_detalhes' => 'required',
            'f_usuario_destino' => 'required|numeric',
            'f_data' => 'date_format:"d/m/Y"|nullable'
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
        return redirect()->route('gestor.mensagens.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mensagem = \App\Models\Mensagem::findOrFail($id);

        $ver = false;
        if(Route::currentRouteName() == "gestor.mensagens.see"){
            $mensagem->viewed = 1;
            $mensagem->save();

            $ver = true;
        }

        $fazendas = \App\Models\Fazenda::where('cliente_id', auth('gestor')->user()->cliente_id)->get();
        $usuarios = \App\Models\Usuario::where('cliente_id', auth('gestor')->user()->cliente_id)->where('id', '!=', auth('gestor')->user()->id)->get();

        $cliente = null;
        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }

        return view('gestor.mensagens.edita', compact('mensagem', 'cliente', 'fazendas', 'usuarios', 'ver'));
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
        $mensagem = \App\Models\Mensagem::findOrFail($id);

        $validator = $this->valid($request, $mensagem);
        
        if ($validator->fails()) {
            return redirect()->route('gestor.mensagens.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }
        $mensagem->cliente_id = $request->cliente_id;
        $mensagem->fazenda_id = $request->f_fazenda;
        $mensagem->usuario_id_remetente = auth('gestor')->user()->id;
        $mensagem->usuario_id_destino = $request->f_usuario_destino;
        $mensagem->categoria_id = $request->f_categoria;
        $mensagem->mensagem = $request->f_detalhes;
        $mensagem->situacao = 1;
        
        if($request->f_data){
            $data = Carbon::createFromFormat('d/m/Y', $request->f_data)->format('Y-m-d H:i:s');
            $mensagem->data = $data;
        }

        $mensagem->save();

        return redirect()->route('gestor.mensagens.index')
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
        $mensagem = \App\Models\Mensagem::findOrFail($id);
        $mensagem->delete();

        return redirect()->route('gestor.mensagens.index')
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
    public function upload(Request $request, \App\Models\Mensagem $mensagem)
    {
        if ($mensagem->id) {
            if ($request->hasFile('arquivo') && $request->file('arquivo')->isValid()) {
                return $this->uploadArquivo($request, $mensagem);
            }
        }

        return response()->json(['error' => 'Erro ao enviar']);
    }

    public function uploadArquivo($request, $mensagem)
    {
        $ret = [];

        $name = "arquivo-" . $mensagem->id . "-" . uniqid(date('YmdHis'));
        $extension = $request->arquivo->extension();
        $nameFile = "{$name}.{$extension}";

        $upload = $request->arquivo->storeAs($mensagem->uploadifyFiles['arquivo']['path'], $nameFile, $mensagem->uploadifyFiles['arquivo']);

        if (!$upload) {
            $ret['error'] = 'Erro ao enviar';
        } else {
            $mensagem->arquivo = $nameFile;
            $mensagem->save();

            $html = view('gestor.mensagens.arquivo', compact('mensagem'))->render();
            return response()->json(['html' => $html]);
        }

        return response()->json($ret);
    }
}
