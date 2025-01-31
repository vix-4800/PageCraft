<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\User;
use App\Notifications\OtpCode;
use Illuminate\Support\Facades\Auth;
use Str;

class OTPService
{
    protected array $configData = [];

    public function __construct()
    {
        $this->configData = config('auth.otp');
    }

    public function request(User $user): void
    {
        $user->oneTimePasswords()->delete();

        $otp = Str::random($this->configData['length']);
        $otp = $this->configData['uppercase'] ? strtoupper($otp) : $otp;

        $user->oneTimePasswords()->create([
            'code' => $otp,
            'expires_at' => now()->addMinutes($this->configData['expire']),
        ]);

        $user->notify(new OtpCode($otp));
    }

    public function verify(User $user, string $code): void
    {
        /** @var \App\Models\OneTimePassword $password */
        $password = $user->oneTimePasswords()->active()->firstWhere('code', $code);

        throw_if(! $password, new ApiException('Invalid OTP', 422));
        $user->oneTimePasswords()->delete();

        Auth::login($user);
    }
}
