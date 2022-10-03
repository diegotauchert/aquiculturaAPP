<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Web\NovaSenha;

class TrabalhePasswordController extends Controller
{

    use ResetsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    protected function guard()
    {
        return Auth::guard('trabalhe');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $next = $request->next;

        $pagina = \App\Models\Pagina::where('situacao', '1')
            ->where('link', 'trabalhe')->firstOrFail();

        $vagas = \App\Models\Vaga::select('vagas.*')
                ->where('situacao', '=', '1')
                ->orderBy('nome', 'asc');

        if (auth('trabalhe')->user()) {
            return view('web.trabalhe.password_update', compact('pagina', 'vagas', 'next'));
        }

        return view('web.trabalhe.password', compact('pagina', 'vagas', 'next'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function passwordPost(Request $request)
    {
        if (auth('trabalhe')->user()) {
            return $this->senhaUpdate($request);
        }

        return $this->senhaReset($request);
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
            return redirect()->route('web.trabalhe.password')->withErrors($validator)->withInput();
        }

        $usuario = auth()->guard('trabalhe')->user();

        if (!Hash::check($request->f_password_current, $usuario->password)) {
            return redirect()->route('web.trabalhe.password')
                            ->with('alert', ['type' => 'danger',
                                'message' => 'Senha Atual inválida!'
                            ])->withInput();
        }

        if (($request->f_password_new == $request->f_password_new_confirmation) &&
                (Hash::check($request->f_password_current, $usuario->password))) {
            $usuario->password = Hash::make($request->f_password_new);
            $usuario->save();
        }

        return redirect()->route('web.trabalhe.password')
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

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function senhaReset(Request $request)
    {
        $validator = $this->validReset($request);
        if ($validator->fails()) {
            return redirect()->route('web.trabalhe.password', ['next' => $request->next])
                            ->withErrors($validator)
                            ->withInput();
        }

        $credencials = [
            'email' => $request->f_email,
            'situacao' => 1,
        ];

        $usuario = \App\Models\Curriculo::where('email', '=', $credencials['email'])
                        ->where('situacao', '=', $credencials['situacao'])->get();

        if (count($usuario) > 0) {
            if ($usuario[0]->email == $credencials['email']) {

                $senha = \Illuminate\Support\Str::random(12);
                $usuario[0]->password = Hash::make($senha);
                $usuario[0]->save();

                Mail::to($usuario[0]->email)->send(new NovaSenha($usuario[0], $senha));

                return redirect()->route('web.trabalhe.login', ['next' => $request->next])
                                ->with('alert', [
                                    'type' => 'success',
                                    'message' => 'Uma nova senha foi enviada para: <b>' . $request->f_email . '</b>!'
                ]);
            }
        }

        return redirect()->route('web.trabalhe.password', ['next' => $request->next])
                        ->with('alert', [
                            'type' => 'danger',
                            'message' => 'Desculpe, <b>E-mail</b> não cadastrado!'
                        ])
                        ->withInput();
    }

    public function validReset(Request $request)
    {
        $validator = validator($request->all(), [
            'f_email' => 'required|email|max:250',
        ]);

        return $validator;
    }

}
