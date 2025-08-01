<?php

use App\Http\Middleware\OptionalAuthenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then:function () {
            Route::prefix('api/v1')
                ->middleware([
                    'api'
                ])
                ->group(function () {
                    require app_path('Component/Auth/Resource/routes.php');
                    require app_path('Component/Ad/Resource/routes.php');
                });
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
         $middleware->alias([
             'optional.auth' => OptionalAuthenticate::class,
         ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (\Illuminate\Validation\ValidationException $e, $request) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
                'data' => []
            ], \Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY);
        });
    })->create();
