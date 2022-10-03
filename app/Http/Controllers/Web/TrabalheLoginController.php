<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrabalheLoginController extends Controller
{

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

    public function username()
    {
        return 'email';
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

        return view('web.trabalhe.login', compact('pagina', 'vagas', 'next'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loginPost(Request $request)
    {
        $validator = $this->validLogin($request);
        if ($validator->fails()) {
            return redirect()->route('web.trabalhe.login', ['next' => $request->next])
                            ->withErrors($validator)->withInput();
        }

        $credencials = [
            'email' => $request->f_email,
            'password' => $request->f_password,
            'situacao' => 1,
        ];

        if (auth()->guard('trabalhe')->attempt($credencials)) {

            if ($request->next) {
                return redirect($request->next);
            }

            return redirect()->route('web.trabalhe.register');
        } else {
            return redirect()->route('web.trabalhe.login', ['next' => $request->next])
                            ->with('alert', ['type' => 'danger',
                                'message' => '<b>Usuário</b> e/ou <b>Senha</b> inválidos!'
                            ])->withInput();
        }
    }

    public function validLogin(Request $request)
    {
        $rule = [
            'f_email' => 'required|email|max:250',
            'f_password' => 'required|min:3|max:100'
        ];

        $validator = validator($request->all(), $rule);

        return $validator;
    }

    public function logout()
    {
        auth('trabalhe')->logout();

        return redirect()->route('web.trabalhe.login');
    }

}
