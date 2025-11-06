<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckForAnyToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $header = $request->header('Authorization');

        if ($header && str_starts_with($header, 'Bearer ')) {
            $token = substr($header, 7);
            $accessToken = PersonalAccessToken::findToken($token);

            if ($accessToken) {
                // ✅ Properly authenticate the user with Laravel's auth system
                Auth::setUser($accessToken->tokenable);
                
                // Also set the user on the request for consistency
                $request->setUserResolver(function () use ($accessToken) {
                    return $accessToken->tokenable;
                });
            }
        }

        return $next($request);
    }
}