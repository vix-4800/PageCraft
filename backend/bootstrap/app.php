<?php

declare(strict_types=1);

use App\Exceptions\ApiException;
use App\Exceptions\ApiNotFoundException;
use App\Exceptions\ApiUnauthorizedException;
use App\Http\Middleware\IsUserAdmin;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function (): void {
            Route::middleware('api')->prefix('api')->name('api.')->group(function (): void {
                Route::prefix('v1')->name('v1.')->group(base_path('routes/api_v1.php'));

                // Route::prefix('v2')->name('v2.')->group(base_path('routes/api_v2.php')); // For the future
            });
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->statefulApi();

        $middleware->alias([
            'admin' => IsUserAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        if (app()->isProduction()) {
            $exceptions->render(function (ModelNotFoundException $modelNotFoundException, Request $request): void {
                throw_if($request->wantsJson(), new ApiNotFoundException);
            });

            $exceptions->render(function (NotFoundHttpException $notFoundHttpException, Request $request): void {
                throw_if($request->wantsJson(), new ApiNotFoundException);
            });

            $exceptions->render(function (AuthenticationException $authenticationException, Request $request): void {
                throw_if($request->wantsJson(), new ApiUnauthorizedException);
            });

            $exceptions->render(function (Exception $exception, Request $request): void {
                throw_if($request->wantsJson(), new ApiException($exception->getMessage(), $exception->getCode()));
            });
        }
    })
    ->create();
