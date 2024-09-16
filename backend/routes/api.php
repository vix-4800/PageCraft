<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function (): void {
    Route::prefix('v1')->name('v1.')->group(function (): void {
        // User
        Route::get('user', [UserController::class, 'index'])->middleware('auth:sanctum')->name('user.index');
    });

    // Auth
    Route::controller(AuthController::class)->prefix('auth')->group(function (): void {
        Route::post('register', 'register')->name('register');
        Route::post('login', 'login')->name('login');
        Route::post('logout', 'logout')->name('logout')->middleware('auth:sanctum');
    });
});

Route::get('email/verify/{id}', [AuthController::class, 'verify'])->name('verification.verify');
Route::post('email/resend', [AuthController::class, 'resend'])->name('verification.resend');

Route::fallback(function (): JsonResponse {
    return response()->json([
        'error' => true,
        'message' => 'Not Found',
        'code' => 404,
    ], 404);
});
