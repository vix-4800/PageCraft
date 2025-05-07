<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Models\User;
use App\Services\OTPService;
use Illuminate\Http\Request;

final class OTPController extends Controller
{
    public function __construct(
        private readonly OTPService $otpService
    ) {
        //
    }

    public function request(Request $request): void
    {
        $user = User::firstWhere('email', $request->input('email'));
        throw_if(! $user, new ApiException('User not found', 422));

        $this->otpService->request($user);
    }

    public function verify(Request $request): void
    {
        $request->validate([
            'code' => 'required|string|min:6|max:6',
            'email' => 'required|string|email',
        ]);

        $user = User::firstWhere('email', $request->input('email'));
        throw_if(! $user, new ApiException('User not found', 422));

        $this->otpService->verify($user, $request->input('code'));
    }
}
