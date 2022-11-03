<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Gestor\Util;

class CadastroController extends Controller
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
            $usuarios = \App\Models\Usuario::where('usuarios.tipo', '>=', auth('gestor')->user()->tipo)
                            ->where('cliente_id', auth('gestor')->user()->cliente_id)
                            ->where(function($query) use ($f_p) {
                                $query->where('nome', 'like', '%' . $f_p . '%')
                                ->orWhere('login', 'like', '%' . $f_p . '%')
                                ->orWhere('email', 'like', '%' . $f_p . '%');
                            })
                            ->orderBy('id', 'desc');
        } else {
            $usuarios = \App\Models\Usuario::where('usuarios.tipo', '>=', auth('gestor')->user()->tipo)
                            ->where('cliente_id', auth('gestor')->user()->cliente_id)
                            ->orderBy('id', 'desc');
        }

        if(auth('gestor')->user()->fazenda_id){
            $usuarios = $usuarios->where('fazenda_id', auth('gestor')->user()->fazenda_id);
        }
        $usuarios = $usuarios->paginate(10);

        $usuario = new \App\Models\Usuario;

        $cliente = null;
        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }

        return view('gestor.cadastro.lista', compact('usuarios', 'usuario', 'cliente', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $usuario = new \App\Models\Usuario;
        $cliente = null;
        $f_p = $request->f_p;
        if ($f_p) {
            $usuarios = \App\Models\Usuario::where('usuarios.tipo', '>=', auth('gestor')->user()->tipo)
                            ->where('cliente_id', auth('gestor')->user()->cliente_id)
                            ->where(function($query) use ($f_p) {
                                $query->where('nome', 'like', '%' . $f_p . '%')
                                ->orWhere('login', 'like', '%' . $f_p . '%')
                                ->orWhere('email', 'like', '%' . $f_p . '%');
                            })
                            ->orderBy('id', 'desc')->paginate(10);
        } else {
            $usuarios = \App\Models\Usuario::where('usuarios.tipo', '>=', auth('gestor')->user()->tipo)
                            ->where('cliente_id', auth('gestor')->user()->cliente_id)
                            ->orderBy('id', 'desc')->paginate(10);
        }

        if(auth('gestor')->user()->cliente_id){
            $cliente = \App\Models\Cliente::findOrFail(auth('gestor')->user()->cliente_id);
        }

        return view('gestor.cadastro.lista', compact('usuario', 'usuarios', 'cliente', 'f_p'));
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
            return redirect()->back()
                            ->with('alert', [
                                'type' => 'danger',
                                'message' => 'O Usuário já existe no sistema'
                            ]);
        }

        $usuario = new \App\Models\Usuario;

        $validator = $this->valid($request, $usuario);

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

        return redirect()->route('gestor.cadastro.index')->with('alert', ['type' => 'success',
                    'message' => 'Registro incluído com sucesso!']);
    }

    public function valid(Request $request, $usuario)
    {
        $validator = validator($request->all(), [
            'f_usuario' => 'required|alpha_num|min:3|max:250|unique:usuarios,login',
            'f_password' => 'required|confirmed|min:3|max:100',
            'f_nome' => 'required|max:250',
            'f_tipo' => 'required|numeric',
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
        return redirect()->route('gestor.cadastro.index');
    }
}