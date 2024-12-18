<?php

declare(strict_types=1);

use App\Exceptions\ApiNotFoundException;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageConfigurationController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ProductVariationController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function (): void {
    Route::prefix('v1')->name('v1.')->group(function (): void {
        Route::middleware('auth:sanctum')->group(function (): void {
            Route::prefix('users')->group(function (): void {
                Route::get('me', [UserController::class, 'view'])->name('user.view');
                Route::apiResource('/', UserController::class)->except('view');

                Route::get('me/notifications', [NotificationController::class, 'notifications'])->name('user.notifications');
                Route::patch('me/notifications/{id}', [NotificationController::class, 'readNotification'])->name('user.notifications.read');
            });

            Route::controller(StatisticsController::class)
                ->prefix('statistics')
                ->name('statistics.')
                ->group(function (): void {
                    Route::get('overview', 'overview')->name('overview');
                    Route::get('sales/last-week', 'salesForLastSevenDays')->name('sales.lastSevenDays');
                });
        });

        Route::apiSingleton('page-configuration', PageConfigurationController::class);

        Route::apiResource('products', ProductController::class)->scoped(['product' => 'slug']);
        Route::apiResource('products.reviews', ProductReviewController::class)->shallow()->scoped(['product' => 'slug']);
        Route::apiResource('variations', ProductVariationController::class)->scoped(['variation' => 'sku']);
        Route::apiResource('productAttributes', ProductAttributeController::class);

        Route::apiResource('orders', OrderController::class);
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
