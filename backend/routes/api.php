<?php

declare(strict_types=1);

use App\Exceptions\ApiNotFoundException;
use App\Http\Controllers\AuthenticatedUserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageConfigurationController;
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
                Route::apiResource('/', UserController::class);

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

        Route::get('products/search', [ProductController::class, 'search'])->name('products.search');
        Route::get('products/best', [ProductController::class, 'best'])->name('products.best');
        Route::get('products/new', [ProductController::class, 'new'])->name('products.new');
        Route::get('products/popular', [ProductController::class, 'popular'])->name('products.popular');
        Route::apiResource('products', ProductController::class)->scoped(['product' => 'slug']);
        Route::apiResource('products.reviews', ProductReviewController::class)->shallow()->scoped(['product' => 'slug']);
        Route::apiResource('variations', ProductVariationController::class)->scoped(['variation' => 'sku'])->only('index');

        Route::apiResource('orders', OrderController::class)->except('destroy');
    });

    Route::get('user', [AuthenticatedUserController::class, 'show'])->middleware('auth:sanctum');
    Route::patch('user', [AuthenticatedUserController::class, 'update'])->middleware('auth:sanctum');
});

Route::fallback(function (): never {
    throw new ApiNotFoundException;
});
