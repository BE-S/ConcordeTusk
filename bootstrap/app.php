<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EntranceApi;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            Route::middleware("throttle:api")
                ->prefix("api")
                ->group(base_path("routes/api.php"));
        },
        commands: __DIR__.'/../routes/console.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->throttleWithRedis();
        $middleware->append(EntranceApi::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
