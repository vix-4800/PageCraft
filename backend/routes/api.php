<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageConfigurationController;
use App\Http\Controllers\UserController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function (): void {
    Route::prefix('v1')->name('v1.')->group(function (): void {
        // User
        Route::middleware('auth:sanctum')->group(function (): void {
            Route::name('user.')->group(function (): void {
                Route::get('user', [UserController::class, 'view'])->name('view');
                Route::get('users', [UserController::class, 'index'])->name('index');
            });
        });

        // Page Configuration
        Route::prefix('page-configuration')->name('page-configuration.')->group(function (): void {
            Route::get('/', [PageConfigurationController::class, 'show'])->name('show');
            Route::put('/', [PageConfigurationController::class, 'update'])->name('update');
        });
    });

    // Auth
    Route::controller(AuthController::class)->prefix('auth')->group(function (): void {
        Route::post('register', 'register')->name('register');
        Route::post('login', 'login')->name('login');
        Route::post('logout', 'logout')->middleware('auth:sanctum')->name('logout');
    });
});

// Verification
Route::prefix('email')->name('verification.')->group(function (): void {
    Route::get('verify/{user}', [AuthController::class, 'verify'])->name('verify');
    Route::post('resend', [AuthController::class, 'resend'])->name('resend');
});

Route::fallback(function (): JsonResponse {
    return new JsonResponse([
        'error' => true,
        'message' => 'Not Found',
        'code' => 404,
    ], 404);
});
