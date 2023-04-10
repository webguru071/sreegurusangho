<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageManager
{
    public function handle(Request $request, Closure $next)
    {

        if(session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        }

        // $language = (session()->has('locale') == null) ? "en" :  session()->has('locale');
        // App::setLocale($language);

        return $next($request);
    }
}
