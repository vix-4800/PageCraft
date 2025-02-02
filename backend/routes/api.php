<?php

declare(strict_types=1);

use App\Exceptions\ApiException;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthenticatedUserController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\FeedbackMessageController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MarketplaceAccountController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ProductVariationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\SystemReportController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function (): void {
    Route::prefix('v1')->name('v1.')->group(function (): void {
        Route::middleware(['auth:sanctum', 'admin'])->group(function (): void {
            Route::apiResource('users', UserController::class);
            Route::post('users/{user}/verify', [UserController::class, 'verify'])->name('users.verify');

            Route::controller(StatisticsController::class)->prefix('statistics')->name('statistics.')->group(function (): void {
                Route::get('overview', 'overview')->name('overview');
                Route::get('sales/last-week', 'salesForLastSevenDays')->name('sales.lastSevenDays');
            });

            Route::prefix('backups')->name('backup.')->group(function (): void {
                Route::get('/', [BackupController::class, 'list'])->name('list');
                Route::post('create', [BackupController::class, 'create'])->name('create');
                Route::post('restore', [BackupController::class, 'restore'])->middleware('password.confirm')->name('restore');
                Route::delete('/', [BackupController::class, 'delete'])->middleware('password.confirm')->name('delete');
            });

            Route::prefix('logs')->name('log.')->group(function (): void {
                Route::get('app', [LogController::class, 'getAppLogs']);
                Route::delete('app', [LogController::class, 'deleteAppLogs']);

                Route::get('queue', [LogController::class, 'getQueueLogs']);
                Route::delete('queue', [LogController::class, 'deleteQueueLogs']);
            });

            Route::apiResource('marketplaces/accounts', MarketplaceAccountController::class);

            Route::prefix('reports')->name('reports.')->group(function (): void {
                Route::get('/', [SystemReportController::class, 'index'])->name('index');
                Route::post('refresh', [SystemReportController::class, 'refresh'])->name('reports.refresh');
            });
        });

        Route::apiSingleton('settings', SettingController::class);
        Route::apiSingleton('templates', TemplateController::class);

        Route::get('products/best', [ProductController::class, 'best'])->name('products.best');
        Route::get('products/new', [ProductController::class, 'new'])->name('products.new');
        Route::get('products/popular', [ProductController::class, 'popular'])->name('products.popular');
        Route::post('products/update-search-indexes', [ProductController::class, 'updateSearchIndexes'])->name('products.updateSearchIndexes');
        Route::apiResource('products', ProductController::class)->scoped(['product' => 'slug']);
        Route::apiResource('products.reviews', ProductReviewController::class)->shallow()->scoped(['product' => 'slug']);
        Route::apiResource('variations', ProductVariationController::class)->scoped(['variation' => 'sku'])->only('index');

        Route::get('orders/latest', [OrderController::class, 'latest'])->name('orders.latest');
        Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
        Route::apiResource('orders', OrderController::class)->except('destroy');

        Route::apiResource('reviews', ReviewController::class)->middleware('auth:sanctum');

        Route::apiResource('feedback/messages', FeedbackMessageController::class);

        Route::post('articles/update-search-indexes', [ArticleController::class, 'updateSearchIndexes'])->name('articles.updateSearchIndexes');
        Route::apiResource('articles', ArticleController::class)->scoped(['article' => 'slug']);

        Route::get('search', SearchController::class)->name('search');

        Route::apiSingleton('banners', BannerController::class)->only(['show', 'update']);
    });

    Route::prefix('user')->name('user.')->middleware('auth:sanctum')->group(function (): void {
        Route::get('/', [AuthenticatedUserController::class, 'show']);
        Route::delete('/', [AuthenticatedUserController::class, 'destroy'])->middleware('password.confirm');
        Route::get('orders', [OrderController::class, 'userOrders']);
        Route::apiResource('addresses', AddressController::class);

        Route::get('notifications', [NotificationController::class, 'notifications'])->name('notifications');
        Route::patch('notifications/{id}', [NotificationController::class, 'readNotification'])->name('notifications.read');
        Route::patch('notifications', [NotificationController::class, 'readAllNotifications'])->name('notifications.read-all');
    });

    Route::prefix('oauth/{provider}')->name('oauth.')->group(function (): void {
        Route::get('redirect', [OAuthController::class, 'oauthRedirect'])->name('redirect');
        Route::get('callback', [OAuthController::class, 'oauthCallback'])->name('callback');
    });

    Route::post('auth/otp/request', [OTPController::class, 'request']);
    Route::post('auth/otp/verify', [OTPController::class, 'verify']);
});

Route::fallback(function (): never {
    throw new ApiException;
});
