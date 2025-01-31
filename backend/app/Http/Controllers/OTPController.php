<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ApiNotFoundException;
use App\Models\User;
use App\Services\OTPService;
use Illuminate\Http\Request;

class OTPController extends Controller
{
    public function __construct(
        private readonly OTPService $service
    ) {
        //
    }

    public function request(Request $request): void
    {
        $user = User::firstWhere('email', $request->input('email'));
        throw_if(! $user, new ApiNotFoundException('User not found'));

        $this->service->request($user);
    }

    public function verify(Request $request): void
    {
        $request->validate([
            'otp' => 'required|string|min:6|max:6',
            'email' => 'required|string|email',
        ]);

        $user = User::firstWhere('email', $request->input('email'));
        throw_if(! $user, new ApiNotFoundException('User not found'));

        $this->service->verify($user, $request->input('otp'));
    }
}
