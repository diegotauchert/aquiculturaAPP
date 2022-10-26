<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Gestor\Util;

class UsuarioController extends Controller
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
            $usuarios = \App\Models\Usuario::where('usuarios.tipo', '>=', auth('gestor')->user()->tipo)
                            ->where(function($query) use ($f_p) {
                                $query->where('nome', 'like', '%' . $f_p . '%')
                                ->orWhere('login', 'like', '%' . $f_p . '%')
                                ->orWhere('email', 'like', '%' . $f_p . '%');
                            })
                            ->orderBy('id', 'desc')->paginate(10);
        } else {
            $usuarios = \App\Models\Usuario::where('usuarios.tipo', '>=', auth('gestor')->user()->tipo)
                            ->orderBy('id', 'desc')->paginate(10);
        }

        return view('gestor.usuarios.lista', compact('usuarios', 'f_p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuario = new \App\Models\Usuario;
        $modulos = \App\Models\Modulo::whereNull('modulo_id')
                        ->orderBy('nome', 'asc')->get();

        return view('gestor.usuarios.edita', compact('usuario', 'modulos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuario = new \App\Models\Usuario;

        if ($request->f_tipo < auth('gestor')->user()->tipo) {
            return redirect()->route('gestor.usuarios.index')->with('alert', Util::msgPermissao('gestor'));
        }

        $validator = $this->valid($request, $usuario);
        if ($validator->fails()) {
            return redirect()->route('gestor.usuarios.create')->withErrors($validator)->withInput();
        }

        $usuario->nome = $request->f_nome;
        $usuario->login = $request->f_login;
        if ($request->f_password == $request->f_password_confirmation) {
            $usuario->password = Hash::make($request->f_password);
        }
        $usuario->email = $request->f_email;
        $usuario->tipo = ($request->f_tipo >= auth('gestor')->user()->tipo ? $request->f_tipo : auth('gestor')->user()->tipo);
        $usuario->situacao = $request->f_situacao;
        $usuario->save();

        $this->permissoes($request, $usuario);

        return redirect()->route('gestor.usuarios.index')->with('alert', ['type' => 'success',
                    'message' => 'Registro incluído com sucesso!']);
    }

    public function valid(Request $request, $usuario)
    {
        $rule = [];
        $rule['f_login'] = 'required|alpha_num|min:3|max:250|unique:usuarios,login' . ($usuario->id ? ',' . $usuario->id : '');
        $rule['f_email'] = 'required|email|max:250|unique:usuarios,email' . ($usuario->id ? ',' . $usuario->id : '');

        if ($usuario->id) {
            if ($request->f_password_new) {
                $rule['f_password_new'] = 'required|confirmed|min:3|max:100';
            }
        } else {
            $rule['f_password'] = 'required|confirmed|min:3|max:100';
        }
        $rule['f_situacao'] = 'required|numeric';
        $rule['f_tipo'] = 'required|numeric';
        $rule['f_nome'] = 'required|max:250';

        $validator = validator($request->all(), $rule);

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
        return redirect()->route('gestor.usuarios.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = \App\Models\Usuario::findOrFail($id);

        if ($usuario->tipo < auth('gestor')->user()->tipo) {
            return redirect()->route('gestor.usuarios.index')
                            ->with('alert', Util::msgPermissao('gestor'));
        }

        $modulos = \App\Models\Modulo::whereNull('modulo_id')
                ->orderBy('nome', 'asc')
                ->get();

        $logs = $usuario->logs()
                ->orderBy('data', 'desc')
                ->paginate(5);

        return view('gestor.usuarios.edita', compact('usuario', 'modulos', 'logs'));
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
        $usuario = \App\Models\Usuario::findOrFail($id);

        if ($usuario->tipo < auth('gestor')->user()->tipo) {
            return redirect()->route('gestor.usuarios.index')->with('alert', Util::msgPermissao('gestor'));
        }

        $validator = $this->valid($request, $usuario);
        if ($validator->fails()) {
            return redirect()->route('gestor.usuarios.edit', $id)->withErrors($validator)->withInput();
        }

        $usuario->nome = $request->f_nome;
        $usuario->login = $request->f_login;
        if ($request->f_password_new && ($request->f_password_new == $request->f_password_new_confirmation)) {
            $usuario->password = Hash::make($request->f_password_new);
        }
        $usuario->email = $request->f_email;
        $usuario->tipo = ($request->f_tipo >= auth('gestor')->user()->tipo ? $request->f_tipo : auth('gestor')->user()->tipo);
        $usuario->situacao = $request->f_situacao;
        $usuario->save();

        $this->permissoes($request, $usuario);

        return redirect()->route('gestor.usuarios.index')->with('alert', ['type' => 'success',
                    'message' => 'Registro alterado com sucesso!']);
    }

    private function permissoes(Request $request, \App\Models\Usuario $usuario)
    {
        if ($usuario->id) {
            \App\Models\Permissao::where('usuario_id', '=', $usuario->id)->delete();

            if ($request->permissoes && (count($request->permissoes) > 0)) {
                foreach ($request->permissoes as $mod) {
                    $modulo = \App\Models\Modulo::findOrFail($mod);

                    if (Util::permissao('gestor', $modulo->link)) {
                        $permissao = new \App\Models\Permissao;
                        $permissao->usuario_id = $usuario->id;
                        $permissao->modulo_id = $mod;

                        $permissao->save();
                    }
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
        $usuario = \App\Models\Usuario::findOrFail($id);
        if ($usuario->tipo >= auth('gestor')->user()->tipo && $usuario->id != auth('gestor')->user()->id
        ) {
            $usuario->delete();

            return redirect()->route('gestor.usuarios.index')
                            ->with('alert', [
                                'type' => 'success',
                                'message' => 'Registro excluído com sucesso!'
            ]);
        }

        return redirect()->route('gestor.usuarios.index')
                        ->with('alert', Util::msgPermissao('gestor'));
    }

}
