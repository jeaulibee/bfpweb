<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $allowed = explode('|', $roles);

        if (! in_array($request->user()->role, $allowed)) {
            abort(Response::HTTP_FORBIDDEN, 'Unauthorized access.');
        }

        return $next($request);
    }
}
