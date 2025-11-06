<?php

namespace App\Http\Middleware;

use Closure;

class TrimStrings
{
    /**
     * The names of the attributes that should not be trimmed.
     *
     * @var array
     */
    protected $except = [
        'password',
        'password_confirmation',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        $input = $request->all();

        array_walk_recursive($input, function (&$value, $key) {
            if (!in_array($key, $this->except) && is_string($value)) {
                $value = trim($value);
            }
        });

        $request->merge($input);

        return $next($request);
    }
}
