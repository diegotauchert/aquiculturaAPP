<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if (Route::is('gestor.*')) {
                $uri = $request->getRequestUri();
                
                return route('gestor.login', ['next' => $uri]);
            }

            if (Route::is('web.*')) {
                $uri = $request->getRequestUri();
                
                return route('web.home');
            }
            
            return route('login');
        }
    }
}
