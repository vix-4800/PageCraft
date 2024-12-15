<?php

declare(strict_types=1);

use App\Exceptions\ApiNotFoundException;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageConfigurationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function (): void {
    Route::prefix('v1')->name('v1.')->group(function (): void {
        Route::middleware('auth:sanctum')->group(function (): void {
            Route::get('users', [UserController::class, 'view'])->name('user.view');
            Route::apiResource('users', UserController::class)->except('view');
        });

        Route::apiSingleton('page-configuration', PageConfigurationController::class);

        Route::get('statistics', StatisticsController::class)->name('statistics.index')->middleware('auth:sanctum');

        Route::apiResource('products', ProductController::class)->scoped(['product' => 'slug']);
        Route::apiResource('orders', OrderController::class);
        Route::apiResource('products.reviews', ProductReviewController::class)->shallow()->scoped(['product' => 'slug']);
    });

    // Auth
    Route::controller(AuthController::class)->prefix('auth')->group(function (): void {
        Route::post('register', 'register')->name('register');
        Route::post('login', 'login')->name('login');
        Route::post('logout', 'logout')->middleware('auth:sanctum')->name('logout');
    });
});

// Verification
Route::controller(AuthController::class)->prefix('email')->name('verification.')->group(function (): void {
    Route::get('verify/{user}', 'verify')->name('verify');
    Route::post('resend', 'resend')->name('resend');
});

Route::fallback(function (): never {
    throw new ApiNotFoundException;
});
