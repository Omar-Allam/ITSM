<?php

namespace App\Http\Middleware;

use Closure;

class CheckLanguage
{

    public function handle($request, Closure $next)
    {
        if(\Auth::user()->login){

        }

        return $next($request);
    }
}
