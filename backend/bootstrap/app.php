<?php

declare(strict_types=1);

use App\Exceptions\ApiException;
use App\Exceptions\ApiNotFoundException;
use App\Exceptions\ApiUnauthorizedException;
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
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ModelNotFoundException $exception, Request $request): void {
            throw_if($request->wantsJson(), new ApiNotFoundException);
        });

        $exceptions->render(function (NotFoundHttpException $exception, Request $request): void {
            throw_if($request->wantsJson(), new ApiNotFoundException);
        });

        $exceptions->render(function (AuthenticationException $exception, Request $request): void {
            throw_if($request->wantsJson(), new ApiUnauthorizedException);
        });

        $exceptions->render(function (Exception $exception, Request $request): void {
            // throw_if($request->wantsJson(), new ApiException);
        });
    })
    ->create();
