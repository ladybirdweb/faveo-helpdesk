<?php

namespace App\Http\Middleware;

use Cache;
use Closure;
// use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class LanguageMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Cache::has('language') and array_key_exists(Cache::get('language'), Config::get('languages'))) {
            App::setLocale(Cache::get('language'));
        } else { // This is optional as Laravel will automatically set the fallback language if there is none specified
            App::setLocale(Config::get('app.fallback_locale'));
        }

        return $next($request);
    }
}
