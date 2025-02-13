<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiting;
use Illuminate\Http\Middleware\HandleCors;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // Настройка middleware для API
        $middleware->api([
            HandleCors::class, // Middleware для обработки CORS
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        // Добавляем новое middleware в группу web
        $middleware->web([
            \App\Http\Middleware\SelectUserTreeMiddleware::class,
            \App\Http\Middleware\MainTreeLinkMiddleware::class, // Ваш middleware
        ]);

        // Регистрация нового middleware с именем 'select.tree'
        $middleware->alias([
            //'select.tree' => \App\Http\Middleware\SelectUserTreeMiddleware::class,
            //'choose.tree' => \App\Http\Middleware\MainTreeLinkMiddleware::class,
        ]); 

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
