<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Middleware imports
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\PreventRequestsDuringMaintenance;
use App\Http\Middleware\TrimStrings;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use App\Http\Middleware\UpdateUserLastSeen;
use App\Http\Middleware\CheckForAnyToken;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
    /*
    |--------------------------------------------------------------------------
    | Global Middleware
    |--------------------------------------------------------------------------
    */
    $middleware->use([
        \App\Http\Middleware\Cors::class, // 👈 add this line
        PreventRequestsDuringMaintenance::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
    ]);


        /*
        |--------------------------------------------------------------------------
        | Web Middleware Group
        |--------------------------------------------------------------------------
        */
        $middleware->group('web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            UpdateUserLastSeen::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | API Middleware Group (Mobile + Token-based requests)
        |--------------------------------------------------------------------------
        | Sanctum automatically handles Bearer tokens.
        | Do NOT include EnsureFrontendRequestsAreStateful here.
        */
        $middleware->group('api', [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Route Middleware Aliases
        |--------------------------------------------------------------------------
        */
        $middleware->alias([
    'auth' => Authenticate::class,
    'guest' => RedirectIfAuthenticated::class,
    'update.lastseen' => UpdateUserLastSeen::class,
    'check.token' => \App\Http\Middleware\CheckForAnyToken::class, // ✅ add this
]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
