<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NovaSenha;

class PasswordController extends Controller
{

    use ResetsPasswords;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = '/gestor/dashboard';
    protected function redirectTo()
    {
        return route('gestor.dashboard');
    }

    protected function guard()
    {
        return Auth::guard('gestor');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth:gestor')->except('login');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $saudacao = \App\Gestor\Util::saudacao();
        $next = $request->next;

        return view('gestor.dashboard.password', compact('saudacao', 'next'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function password(Request $request)
    {
        $validator = $this->validPassword($request);
        if ($validator->fails()) {
            return redirect()->route('gestor.password', ['next' => $request->next])
                            ->withErrors($validator)
                            ->withInput();
        }

        $credencials = [
            'email' => $request->f_email,
            'situacao' => 1,
        ];

        $usuario = \App\Models\Usuario::where('email', '=', $credencials['email'])
                        ->where('situacao', '=', $credencials['situacao'])->get();

        if (count($usuario) > 0) {
            if ($usuario[0]->email == $credencials['email']) {

                $senha = \Illuminate\Support\Str::random(12);
                $usuario[0]->password = Hash::make($senha);
                $usuario[0]->save();

                $usuario[0]->registerLogs(null, $_SERVER['REMOTE_ADDR'], session_id(), $_SERVER['HTTP_USER_AGENT'], 2);

                Mail::to($usuario[0]->email)->send(new NovaSenha($usuario[0], $senha));

                return redirect()->route('gestor.login', ['next' => $request->next])
                                ->with('alert', [
                                    'type' => 'success',
                                    'message' => 'Uma nova senha foi enviada para: <b>' . $request->f_email . '</b>!'
                ]);
            }
        }

        return redirect()->route('gestor.password', ['next' => $request->next])
                        ->with('alert', [
                            'type' => 'danger',
                            'message' => 'Desculpe, <b>E-mail</b> não cadastrado!'
                        ])
                        ->withInput();

//        if (auth()->guard('gestor')->attempt($credencials)) {
//            return redirect()->route('gestor.dashboard');
//        } else {
//        }
    }

    public function validPassword(Request $request)
    {
        $validator = validator($request->all(), [
            'f_email' => 'required|email|max:250',
        ]);

        return $validator;
    }

}
