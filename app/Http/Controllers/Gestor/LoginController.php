<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    use AuthenticatesUsers;

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

    public function username()
    {
        return 'login';
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

        return view('gestor.dashboard.login', compact('saudacao', 'next'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = $this->validLogin($request);
        if ($validator->fails()) {
            return redirect()->route('gestor.login', ['next' => $request->next])
                            ->withErrors($validator)
                            ->withInput();
        }

        $credencials = [
            'login' => $request->f_login,
            'password' => $request->f_password,
            'situacao' => 1,
        ];

        if (auth()->guard('gestor')->attempt($credencials)) {

            if ($request->next) {
                return redirect($request->next);
            }

            return redirect()->route('gestor.dashboard');
        } else {
            return redirect()->route('gestor.login', ['next' => $request->next])
                            ->with('alert', [
                                'type' => 'danger',
                                'message' => '<b>Usuário</b> e/ou <b>Senha</b> inválidos!'
                            ])
                            ->withInput();
        }
    }

    public function validLogin(Request $request)
    {
        $validator = validator($request->all(), [
            'f_login' => 'required|alpha_num|min:3|max:250',
            'f_password' => 'required|min:3|max:100',
        ]);

        return $validator;
    }

    public function logout(Request $request)
    {
        auth()->guard('gestor')->logout();

        return redirect()->route('gestor.login');
    }

}
