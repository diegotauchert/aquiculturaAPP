<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class LangDefault
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
        /* Define lang */

        if (!empty($request->lang) || empty($request->session()->get('lang'))) {
            $request->session()->put('lang', "pt-br");
        }

        return $next($request);
    }
}
