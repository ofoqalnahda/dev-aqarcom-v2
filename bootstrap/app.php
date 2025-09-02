<?php

use App\Http\Middleware\ChangeLangForApi;
use App\Http\Middleware\OptionalAuthenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then:function () {
            Route::prefix('api/v1')
                ->middleware([
                    'api',
                    'change.lang.api'
                ])
                ->group(function () {
                    require app_path('Component/Auth/Resource/routes.php');
                    require app_path('Component/Settings/Resource/routes.php');
                    require app_path('Component/Ad/Resource/routes.php');
                    require app_path('Component/Payments/Resource/routes.php');
                    require app_path('Component/Properties/Resource/routes.php');
                    require app_path('Component/Notification/Resource/routes.php');
                });
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
         $middleware->alias([
             'optional.auth' => OptionalAuthenticate::class,
             'change.lang.api' => ChangeLangForApi::class,
         ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // unauthenticated

        $exceptions->renderable(function (\Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException $e, $request) {
            if (request()->is('api/*'))
            {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized. Please log in.',
                    'data' => []
                ], \Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED);

            }
        });
        $exceptions->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => []
            ], \Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED);
        });
        $exceptions->renderable(function (\Illuminate\Validation\ValidationException $e, $request) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
                'data' => []
            ], \Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY);
        });
    })->create();
