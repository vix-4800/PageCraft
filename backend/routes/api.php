<?php

declare(strict_types=1);

use App\Exceptions\ApiException;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthenticatedUserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OTPController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function (): void {
    Route::prefix('user')->name('user.')->middleware('auth:sanctum')->group(function (): void {
        Route::get('/', [AuthenticatedUserController::class, 'show']);
        Route::delete('/', [AuthenticatedUserController::class, 'destroy'])->middleware('password.confirm');
        Route::get('orders', [OrderController::class, 'userOrders']);
        Route::apiResource('addresses', AddressController::class);

        Route::get('notifications', [NotificationController::class, 'notifications']);
        Route::patch('notifications/{id}', [NotificationController::class, 'readNotification']);
        Route::patch('notifications', [NotificationController::class, 'readAllNotifications']);
    });

    Route::prefix('oauth/{provider}')->name('oauth.')->group(function (): void {
        Route::get('redirect', [OAuthController::class, 'oauthRedirect']);
        Route::get('callback', [OAuthController::class, 'oauthCallback']);
    });

    Route::post('auth/otp/request', [OTPController::class, 'request']);
    Route::post('auth/otp/verify', [OTPController::class, 'verify']);
});

Route::fallback(function (): never {
    throw new ApiException;
});
