<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Gestor\Util;
use Illuminate\Support\Facades\Storage;

class UsuarioPerfilController extends Controller
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
     * Lista informacoes perfil usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function perfil()
    {
        $usuario = auth()->guard('gestor')->user();
        $logs = $usuario->logs()
                ->orderBy('data', 'desc')
                ->paginate(5);
        return view('gestor.usuarios.perfil', compact('usuario', 'logs'));
    }

    /**
     * Atualiza informacoes perfil usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function perfilUpdate(Request $request)
    {
        $usuario = auth()->guard('gestor')->user();

        $validator = $this->validPerfil($request, $usuario);
        if ($validator->fails()) {
            return redirect()->route('gestor.editar-perfil')
                            ->withErrors($validator)
                            ->withInput();
        }

        $usuario->nome = $request->f_nome;
        $usuario->login = $request->f_login;
        $usuario->email = $request->f_email;
        $usuario->save();

        return redirect()->route('gestor.editar-perfil')
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Perfil Atualizado com sucesso!'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadDelete(Request $request, $id)
    {
        $usuario = auth()->guard('gestor')->user();

        if ($request->nome == "foto") {
            if ($usuario->foto) {
                Storage::disk($usuario->uploadifyImages['foto']['disk'])->delete($usuario->uploadifyImages['foto']['path'] . 'w_200/' . $usuario->foto);
                $usuario->foto->delete();

                $usuario->foto = null;
                $usuario->save();

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
        $usuario = auth()->guard('gestor')->user();

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $ret = [];

            if ($usuario->foto) {
                Storage::disk($usuario->uploadifyImages['foto']['disk'])->delete($usuario->uploadifyImages['foto']['path'] . 'w_200/' . $usuario->foto);
                $usuario->foto->delete();
            }

            $name = "foto-" . $usuario->id . "-" . uniqid(date('YmdHis'));
            $extension = $request->foto->extension();
            $nameFile = "{$name}.{$extension}";

            Util::resize($request->file('foto'), 1024, 1024);

            $upload = $request->file('foto')->storeAs($usuario->uploadifyImages['foto']['path'], $nameFile, $usuario->uploadifyImages['foto']);

            Util::resize($request->file('foto'), 200, 200);

            $upload = $request->file('foto')->storeAs($usuario->uploadifyImages['foto']['path'] . 'w_200/', $nameFile, $usuario->uploadifyImages['foto']);

            if (!$upload) {
                $ret['error'] = 'Erro ao enviar';
            } else {
                $usuario->foto = $nameFile;
                $usuario->save();

                $html = view('gestor.usuarios.perfil-foto', compact('usuario'))->render();
                return response()->json(['html' => $html]);
            }

            return response()->json($ret);
        }

        return response()->json(['error' => 'Erro ao enviar']);
    }

    public function validPerfil(Request $request, $usuario)
    {
        $validator = validator($request->all(), [
            'f_login' => 'required|alpha_num|min:3|max:250|unique:usuarios,login' . ($usuario->id ? ',' . $usuario->id : ''),
            'f_email' => 'required|email|max:250|unique:usuarios,email' . ($usuario->id ? ',' . $usuario->id : ''),
            'f_nome' => 'required|max:250',
            'f_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1000',
        ]);

        return $validator;
    }

    /**
     * View formulario mudar senha
     *
     * @return \Illuminate\Http\Response
     */
    public function senha()
    {
        return view('gestor.usuarios.senha');
    }

    /**
     * Muda senha do usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function senhaUpdate(Request $request)
    {
        $validator = $this->validSenha($request);
        if ($validator->fails()) {
            return redirect()->route('gestor.mudar-senha')->withErrors($validator)->withInput();
        }

        $usuario = auth()->guard('gestor')->user();

        if (!Hash::check($request->f_password_current, $usuario->password)) {
            return redirect()->route('gestor.mudar-senha')
                            ->with('alert', ['type' => 'danger',
                                'message' => 'Senha Atual inválida!'
                            ])->withInput();
        }

        if (($request->f_password_new == $request->f_password_new_confirmation) &&
                (Hash::check($request->f_password_current, $usuario->password))) {
            $usuario->password = Hash::make($request->f_password_new);
            $usuario->save();
        }

        return redirect()->route('gestor.mudar-senha')
                        ->with('alert', ['type' => 'success',
                            'message' => 'Senha alterada com sucesso!'
        ]);
    }

    public function validSenha(Request $request)
    {
        $validator = validator($request->all(), [
            'f_password_current' => 'required|min:3|max:100',
            'f_password_new' => 'required|confirmed|min:3|max:100',
        ]);

        return $validator;
    }

}
