<?php

namespace App\Http\Controllers\Gestor;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FazendaController extends Controller
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
            $fazendas = \App\Models\Fazenda::where('cliente_id', auth('gestor')->user()->cliente_id)
                    ->where('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('nome', 'like', '%' . $f_p . '%')
                    ->orWhere('email', 'like', '%' . $f_p . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(10);
        } else {
            $fazendas = \App\Models\Fazenda::where('cliente_id', auth('gestor')->user()->cliente_id)->orderBy('id', 'desc')->paginate(10);
        }

        $cliente = null;
        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }

        return view('gestor.fazendas.lista', compact('fazendas', 'cliente', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fazenda = new \App\Models\Fazenda;

        $usuario = null;

        $cliente = null;
        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }

        $planos = \App\Models\Plano::get();

        return view('gestor.fazendas.edita', compact('fazenda', 'cliente', 'planos', 'usuario'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userIsNotAvailable = \App\Models\Usuario::where('login', '=', strtolower($request->f_usuario))->first();

        if ($userIsNotAvailable) {
            return redirect()->route('gestor.fazendas.create')
                            ->with('alert', [
                                'type' => 'danger',
                                'message' => 'O Usuário já existe no sistema'
                            ]);
        }

        $fazenda = new \App\Models\Fazenda;

        $validator = $this->valid($request, $fazenda);
        if ($validator->fails()) {
            return redirect()->route('gestor.fazendas.create')
                            ->withErrors($validator)
                            ->withInput();
        }
        $fazenda->cliente_id = $request->cliente_id;
        $fazenda->plano_id = $request->f_plano;
        $fazenda->nome = $request->f_nome;
        $fazenda->email = $request->f_email;
        $fazenda->telefone = $request->f_telefone;
        $fazenda->cep = $request->f_cep;
        $fazenda->endereco = $request->f_endereco;
        $fazenda->numero = $request->f_numero;
        $fazenda->bairro = $request->f_bairro;
        $fazenda->cidade = $request->f_cidade;
        $fazenda->estado = $request->f_estado;
        $fazenda->complemento = $request->f_complemento;
        $fazenda->situacao = $request->f_situacao;

        $isSaved = $fazenda->save();

        if($isSaved){
            $this->saveUsuario($fazenda, $request);
        }

        return redirect()->route('gestor.fazendas.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro incluído com sucesso!'
        ]);
    }

    public function valid(Request $request)
    {
        $validator = validator($request->all(), [
            'cliente_id' => 'required|numeric',
            'f_plano' => 'required|numeric',
            'f_nome' => 'required|max:250',
            'f_situacao' => 'required|numeric',
            'f_usuario' => 'nullable|max:250',
            'f_password' => 'nullable|confirmed|min:3|max:250',
            'f_password_confirmation' => 'nullable|min:3|max:250'
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
        return redirect()->route('gestor.fazendas.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fazenda = \App\Models\Fazenda::findOrFail($id);
        $usuario = \App\Models\Usuario::where('cliente_id', auth('gestor')->user()->cliente_id)->first();

        $cliente = null;
        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }

        $planos = \App\Models\Plano::get();

        return view('gestor.fazendas.edita', compact('fazenda', 'cliente', 'usuario', 'planos'));
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
        $fazenda = \App\Models\Fazenda::findOrFail($id);

        $validator = $this->valid($request, $fazenda);
        
        if ($validator->fails()) {
            return redirect()->route('gestor.fazendas.edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }
        $fazenda->plano_id = $request->f_plano;
        $fazenda->nome = $request->f_nome;
        $fazenda->email = $request->f_email;
        $fazenda->telefone = $request->f_telefone;
        $fazenda->cep = $request->f_cep;
        $fazenda->endereco = $request->f_endereco;
        $fazenda->numero = $request->f_numero;
        $fazenda->bairro = $request->f_bairro;
        $fazenda->cidade = $request->f_cidade;
        $fazenda->estado = $request->f_estado;
        $fazenda->complemento = $request->f_complemento;
        $fazenda->situacao = $request->f_situacao;

        $isSaved = $fazenda->save();

        return redirect()->route('gestor.fazendas.index')
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
        $fazenda = \App\Models\Fazenda::findOrFail($id);
        $fazenda->delete();

        $this->destroyUsuarioByFazenda($id);

        return redirect()->route('gestor.fazendas.index')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Registro excluído com sucesso!'
        ]);
    }

    public function saveUsuario(\App\Models\Fazenda $fazenda, Request $request)
    {
        $userIsNotAvailable = \App\Models\Usuario::where('login', '=', strtolower($request->f_usuario))->first();
        
        if ($userIsNotAvailable) {
            return redirect()->back()
                            ->with('alert', [
                                'type' => 'danger',
                                'message' => 'O Usuário já existe no sistema'
                            ]);
        }

        $usuario = new \App\Models\Usuario;

        $validator = $this->validUser($request, $usuario);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->f_password == $request->f_password_confirmation) {
            $usuario->password = Hash::make($request->f_password);
        }

        $usuario->password_decoded = $request->f_password;
        $usuario->nome = $request->f_nome ?? $fazenda->nome;
        $usuario->login = $request->f_usuario;
        $usuario->cliente_id = $request->cliente_id;
        $usuario->fazenda_id = $request->fazenda_id ?? $fazenda->id;
        $usuario->email = $fazenda->email ?? 'admin-'.uniqid().'@gmail.com';
        $usuario->tipo = $request->f_tipo ?? 5;
        $usuario->situacao = $request->f_situacao ?? 1;

        $usuario->save();
        
        return redirect()->route('gestor.fazendas.usuario', ["fazenda_id" => $request->fazenda_id ?? $fazenda->id])->with('alert', ['type' => 'success',
                    'message' => 'Usuário criado com sucesso!']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUsuario(Request $request, $id)
    {
        $usuario = \App\Models\Usuario::findOrFail($id);

        $userIsNotAvailable = \App\Models\Usuario::where('login', '=', strtolower($request->f_usuario))
                                                ->where('id', '!=', $id)
                                                ->first();
        if ($userIsNotAvailable) {
            return redirect()->route('gestor.fazendas.usuario', ["fazenda_id" => $request->fazenda_id, "id" => $id])
                            ->with('alert', [
                                'type' => 'danger',
                                'message' => 'O Usuário já existe no sistema'
                            ]);
        }

        $validator = $this->validUserEdit($request, $usuario);

        if ($validator->fails()) {
            return redirect()->route('gestor.fazendas.usuario', ["fazenda_id" => $request->fazenda_id, "id" => $id])->withErrors($validator)->withInput();
        }

        if ($request->f_password == $request->f_password_confirmation) {
            $usuario->password = Hash::make($request->f_password);
        }

        $usuario->password_decoded = $request->f_password;
        $usuario->nome = $request->f_nome ?? $fazenda->nome;
        $usuario->login = $request->f_usuario;
        $usuario->cliente_id = $request->cliente_id;
        $usuario->fazenda_id = $request->fazenda_id ?? $fazenda->id;
        $usuario->email = $fazenda->email ?? 'admin-'.uniqid().'@gmail.com';
        $usuario->tipo = $request->f_tipo;
        $usuario->situacao = $request->f_situacao;

        try{
            $usuario->save();
        } catch(PDOException $e){
            echo $e->getMessage();
        }

        return redirect()->route('gestor.fazendas.usuario', ["fazenda_id" => $request->fazenda_id, "id" => $id])->with('alert', ['type' => 'success',
                    'message' => 'Usuário editado com sucesso!']);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function usuario($fazenda_id, $id = null)
    {
        $fazenda = \App\Models\Fazenda::findOrFail($fazenda_id);
        $usuarios = \App\Models\Usuario::where('cliente_id', auth('gestor')->user()->cliente_id)->where('fazenda_id', $fazenda_id)->get();
        
        $usuario = new \App\Models\Usuario;
        if($id){
            $usuario = $usuario->where('cliente_id', auth('gestor')->user()->cliente_id)
                                            ->where('fazenda_id', $fazenda_id)
                                            ->where('id', $id)
                                            ->first();
        }

        $cliente = null;
        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }

        return view('gestor.fazendas.usuario', compact('fazenda', 'cliente', 'usuarios', 'usuario'));
    }

    public function validUser(Request $request)
    {
        $validator = validator($request->all(), [
            'f_usuario' => 'required|alpha_num|min:3|max:250|unique:usuarios,login',
            'f_password' => 'required|confirmed|min:3|max:100',
            'f_nome' => 'required|max:250',
        ]);

        return $validator;
    }

    public function validUserEdit(Request $request)
    {
        $validator = validator($request->all(), [
            'f_usuario' => 'required|alpha_num|min:3|max:250',
            'f_password' => 'required|confirmed|min:3|max:100',
            'f_nome' => 'required|max:250',
            'f_tipo' => 'required|numeric',
            'f_situacao' => 'required|numeric',
        ]);

        return $validator;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyUsuario($fazenda_id, $id)
    {
        $usuario = \App\Models\Usuario::findOrFail($id);

        $usuario->login = $usuario->login.'-deletado'.'-'.md5(uniqid(rand(), true));
        $usuario->situacao = 2;
        $usuario->save();

        $usuario->delete();

        return redirect()->route('gestor.fazendas.usuario', $fazenda_id)
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Usuário excluído com sucesso!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyUsuarioByFazenda($fazenda_id)
    {
        $usuario = \App\Models\Usuario::where("fazenda_id", $fazenda_id)->get();

        if($usuario){
            foreach($usuario as $u){
                $u->login = $u->login.'-deletado'.'-'.md5(uniqid(rand(), true));
                $u->situacao = 2;
                $u->save();
                $u->delete();
            }
        }
    }
}
