<?php

namespace App\Http\Middleware;

use Closure;

class CheckLanguage
{

    private $local;
    public function handle($request, Closure $next)
    {
//        if (\Auth::user()->login) {
////get user language
//        }
        if (\Session::has('lang')) {
            $local = \Session::get('lang');
            \App::setLocale($local);
        }
        else{
            \App::setLocale(\Config::get('app.locale'));
        }


        return $next($request);
    }
}
