<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ChangeLangForApi
{
    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->header('Accept-Language')?:'ar';
        if (!in_array($lang, config('app.locales'))) {
            $lang = 'ar';
        }
        App::setLocale($lang);
        return $next($request);
    }
}
