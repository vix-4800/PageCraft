<?php

declare(strict_types=1);

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\FeedbackMessageController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MarketplaceAccountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ProductVariationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SearchIndexController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\SystemReportController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VersionController;

Route::middleware('auth:sanctum')->group(function (): void {
    Route::middleware('admin')->group(function (): void {
        Route::apiResource('users', UserController::class);
        Route::post('users/{user}/verify', [UserController::class, 'verify']);

        Route::controller(StatisticsController::class)->prefix('statistics')->name('statistics.')->group(function (): void {
            Route::get('overview', 'overview');
            Route::get('sales/last-week', 'salesForLastSevenDays');
        });

        Route::prefix('backups')->name('backup.')->group(function (): void {
            Route::get('/', [BackupController::class, 'list']);

            Route::middleware('password.confirm')->group(function (): void {
                Route::post('create', [BackupController::class, 'create']);
                Route::post('restore', [BackupController::class, 'restore']);
                Route::delete('delete', [BackupController::class, 'delete']);
                Route::delete('/', [BackupController::class, 'deleteAll']);
            });
        });

        Route::prefix('logs')->name('log.')->group(function (): void {
            Route::get('app', [LogController::class, 'getAppLogs']);
            Route::delete('app', [LogController::class, 'deleteAppLogs']);

            Route::get('queue', [LogController::class, 'getQueueLogs']);
            Route::delete('queue', [LogController::class, 'deleteQueueLogs']);
        });

        Route::apiResource('marketplaces/accounts', MarketplaceAccountController::class);

        Route::prefix('reports')->name('reports.')->group(function (): void {
            Route::get('/', [SystemReportController::class, 'index']);
            Route::post('refresh', [SystemReportController::class, 'refresh']);
        });

        Route::post('articles/update-search-indexes', [SearchIndexController::class, 'articles']);
        Route::post('products/update-search-indexes', [SearchIndexController::class, 'products']);

        Route::get('orders/latest', [OrderController::class, 'latest']);
        Route::get('orders/{order}/invoice', [OrderController::class, 'invoice']);
    });

    Route::apiResource('reviews', ReviewController::class);

    Route::prefix('versions')->name('versions.')->group(function (): void {
        Route::get('/', [VersionController::class, 'index']);
    });
});

Route::apiSingleton('settings', SettingController::class)
    ->middlewareFor('update', ['auth:sanctum', 'admin', 'password.confirm']);
Route::apiSingleton('templates', TemplateController::class)
    ->middlewareFor('update', ['auth:sanctum', 'admin', 'password.confirm']);

Route::prefix('products')->group(function (): void {
    Route::get('best', [ProductController::class, 'best']);
    Route::get('new', [ProductController::class, 'new']);
    Route::get('popular', [ProductController::class, 'popular']);
    Route::apiResource('/', ProductController::class)
        ->scoped(['product' => 'slug'])
        ->middlewareFor(['store', 'update', 'destroy'], ['auth:sanctum', 'admin']);
});

Route::apiResource('products.reviews', ProductReviewController::class)
    ->shallow()->scoped(['product' => 'slug'])
    ->middlewareFor(['store', 'update', 'destroy'], ['auth:sanctum', 'admin']);
Route::apiResource('variations', ProductVariationController::class)
    ->scoped(['variation' => 'sku'])
    ->only('index');

Route::get('product-categories/{category:slug}', [ProductCategoryController::class, 'products']);

Route::apiResource('orders', OrderController::class)
    ->except('destroy')
    ->middlewareFor(['index', 'update', 'destroy'], ['auth:sanctum', 'admin'])
    ->middlewareFor('show', ['auth:sanctum']);

Route::apiResource('feedback/messages', FeedbackMessageController::class)
    ->middlewareFor(['index', 'show'], ['auth:sanctum', 'admin']);

Route::apiResource('articles', ArticleController::class)
    ->middlewareFor(['store', 'update', 'destroy'], ['auth:sanctum', 'admin'])
    ->scoped(['article' => 'slug']);

Route::get('search', SearchController::class);

Route::apiSingleton('banners', BannerController::class)
    ->middlewareFor('update', 'admin')
    ->only(['show', 'update']);
