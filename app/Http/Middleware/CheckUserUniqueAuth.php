<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use App\Gestor\Util;

class CheckUserUniqueAuth
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        /* Verifica se o valor da coluna/sessão "token_access" NÃO é compatível com o valor da sessão que criamos quando o usuário fez login
         */

        if (Route::is('gestor.*')) {
            $act = Route::currentRouteName();

            $def = [
                'gestor.dashboard',
                'gestor.mudar-senha',
                'gestor.mudar-senha-post',
                'gestor.editar-perfil',
                'gestor.editar-perfil-post',
            ];

            if (!in_array($act, $def)) {
                if (!Util::permissao($guard, $act)) {
                    return redirect()
                                    ->route('gestor.dashboard')
                                    ->with('alert', Util::msgPermissao($guard));
                }
            }
        }

        $msg = 'A sessão deste <b>usuário</b> está ativa em outro dispositivo!';
        $situacao = false;

        if (auth()->guard($guard)->user()->situacao != 1) {
            $msg = 'Este <b>usuário</b> está bloqueado!';
            $situacao = true;
        }

        if ((auth()->guard($guard)->user()->token_access != session()->get('access_token')) || $situacao) {
            // Faz o logout do usuário
            auth()->guard($guard)->logout();

            // Redireciona o usuário para a página de login, com session flash "message"
            if (Route::is('gestor.*')) {
                return redirect()
                                ->route('gestor.login')
                                ->with('alert', [
                                    'type' => 'danger',
                                    'message' => $msg
                ]);
            }

            return redirect()
                            ->route('login')
                            ->with('alert', [
                                'type' => 'danger',
                                'message' => $msg
            ]);
        }

        // Permite o acesso, continua a requisição
        return $next($request);
    }

}
