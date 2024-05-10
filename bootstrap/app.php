<?php

use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\RedirectFromOwnProfile;
use App\Http\Middleware\Snoop;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias(['inertia' => HandleInertiaRequests::class, 'redirectFromOwnProfile' => redirectFromOwnProfile::class, 'snoop' => Snoop::class]);
        $middleware->redirectUsersTo('/algoritmizator/app');
        $middleware->redirectGuestsTo('/algoritmizator/auth/login');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
