<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OptionalAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        $authorization = $request->header('Authorization');

        if ($authorization && str_starts_with($authorization, 'Bearer ')) {
            $token = substr($authorization, 7);

            $accessToken = PersonalAccessToken::findToken($token);

            if ($accessToken) {
                Auth::login($accessToken->tokenable);
            }
        }

        return $next($request);
    }
}
