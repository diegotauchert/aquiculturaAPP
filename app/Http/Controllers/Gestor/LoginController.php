<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

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


    public function valid(Request $request)
    {
        $validator = validator($request->all(), [
            'f_nome' => 'required|max:250',
            'f_email' => 'required|email|max:250',
            'f_telefone' => 'required|min:14',
            'f_dt_nasc' => 'required|date_format:"d/m/Y"|min:10|max:10',
            'f_cpf' => 'required|min:14|max:14',
            'f_rg' => 'required|max:15',
            'f_cep' => 'required|min:9|max:9',
            'f_numero' => 'required|max:20',
            'f_usuario' => 'required|max:250',
            'f_password' => 'required|confirmed|min:3|max:250',
            'f_password_confirmation' => 'required|min:3|max:250'
        ]);

        return $validator;
    }

    public function logout(Request $request)
    {
        auth()->guard('gestor')->logout();

        return redirect()->route('gestor.login');
    }

    public function register(Request $request){

        $saudacao = \App\Gestor\Util::saudacao();
        $next = $request->next;

        return view('gestor.dashboard.register', compact('saudacao', 'next'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerStore(Request $request)
    {
        $userIsNotAvailable = \App\Models\Usuario::where('login', '=', strtolower($request->f_usuario))->first();

        $saudacao = \App\Gestor\Util::saudacao();
        $next = $request->next;

        if ($userIsNotAvailable) {
            return redirect()->route('gestor.register')
                            ->withInput()
                            ->with('alert', [
                                'type' => 'danger',
                                'message' => 'O Usuário já existe no sistema. Tente com outro login'
                            ]);
        }

        $cliente = new \App\Models\Cliente;

        $validator = $this->valid($request, $cliente);
        if ($validator->fails()) {
            return redirect()->route('gestor.register')
                            ->withErrors($validator)
                            ->withInput();
        }

        $cliente->nome = $request->f_nome;
        $cliente->email = $request->f_email;
        $cliente->telefone = $request->f_telefone;
        $cliente->cpf = $request->f_cpf;
        $cliente->rg = $request->f_rg;
        $cliente->uf = $request->f_uf;
        $cliente->cep = $request->f_cep;
        $cliente->endereco = $request->f_rua;
        $cliente->numero = $request->f_numero;
        $cliente->bairro = $request->f_bairro;
        $cliente->cidade = $request->f_cidade;
        $cliente->estado = $request->f_uf;
        $cliente->obs = "Cliente Externo";
        $cliente->externo = 1;
        $cliente->dt_expira = Carbon::now()->addDays(15);
        $cliente->situacao = 1;
        
        if($request->f_dt_nasc){
            $data = Carbon::createFromFormat('d/m/Y', $request->f_dt_nasc)->format('Y-m-d H:i:s');
            $cliente->dt_nasc = $data;
        }

        $isSaved = $cliente->save();

        if($isSaved){
            $this->saveUsuario($cliente, $request);
        }

        return redirect()->route('gestor.login', ['next' => $next, 'saudacao' => $saudacao])
                        ->with('alert', [
                            'type' => 'success',
                            'message' => 'Conta criada com sucesso, agora você pode logar no sistema!'
        ]);
    }

    public function saveUsuario(\App\Models\Cliente $cliente, Request $request)
    {
        $usuario = new \App\Models\Usuario;

        if ($request->f_password == $request->f_password_confirmation) {
            $usuario->password = Hash::make($request->f_password);
        }

        $usuario->password_decoded = $request->f_password;
        $usuario->nome = $cliente->nome;
        $usuario->login = $request->f_usuario;
        $usuario->cliente_id = $cliente->id;
        $usuario->email = $cliente->email ?? 'admin-'.uniqid().'@gmail.com';
        $usuario->tipo = 4;
        $usuario->situacao = 1;

        $usuario->save();
    }
}
