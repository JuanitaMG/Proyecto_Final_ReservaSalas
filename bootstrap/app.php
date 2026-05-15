<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(
    basePath: dirname(__DIR__)
)

    /*
    |--------------------------------------------------------------------------
    | ROUTES
    |--------------------------------------------------------------------------
    */
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    /*
    |--------------------------------------------------------------------------
    | MIDDLEWARE
    |--------------------------------------------------------------------------
    */
    ->withMiddleware(function (Middleware $middleware): void {

        /*
        |--------------------------------------------------------------------------
        | WEB MIDDLEWARE
        |--------------------------------------------------------------------------
        */

        $middleware->web(append: [

            \App\Http\Middleware\HandleInertiaRequests::class,

            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,

        ]);

        /*
        |--------------------------------------------------------------------------
        | CUSTOM MIDDLEWARE
        |--------------------------------------------------------------------------
        */

        $middleware->alias([

            // 👑 ADMIN ONLY
            'admin' => \App\Http\Middleware\AdminMiddleware::class,

        ]);
    })

    /*
    |--------------------------------------------------------------------------
    | EXCEPTIONS
    |--------------------------------------------------------------------------
    */
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })

    ->create();