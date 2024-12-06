<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Helpers\ApiResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService,
    ) {}

    /**
     * Logs in a user.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->login($request->validated());

        return ApiResponse::create([
            'token' => $token,
        ]);
    }

    /**
     * Registers a new user.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $token = $this->authService->register($request->validated());

        return ApiResponse::create([
            'token' => $token,
        ]);
    }

    /**
     * Logs out the current user.
     */
    public function logout(Request $request): Response
    {
        $this->authService->logout($request->user());

        return ApiResponse::empty();
    }

    /**
     * Sends an email verification link to the given user.
     *
     * @return JsonResponse True if the email address was verified, false if it was already verified.
     *
     * @throws ApiException
     */
    public function verify(Request $request, User $user): JsonResponse|RedirectResponse
    {
        if ($request->wantsJson()) {
            throw_unless($this->authService->verify($user), new ApiException('Email address already verified', 409));

            return ApiResponse::create([
                'message' => 'Email address verified',
            ]);
        } else {
            return redirect(env('FRONTEND_URL').'/dashboard');
        }
    }

    // public function resend(Request $request): JsonResponse {}
}
