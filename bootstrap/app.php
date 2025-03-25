<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        using: function () {
            Route::middleware("api")
                ->prefix("api")
                ->group(base_path("routes/api.php"));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group("api", [
            \App\Http\Middleware\Api::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
