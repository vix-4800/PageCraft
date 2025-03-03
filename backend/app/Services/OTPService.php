<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\User;
use App\Notifications\OtpCodeGenerated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Str;

final class OTPService
{
    public function request(User $user): void
    {
        $user->oneTimePasswords()->delete();

        $otp = Str::random(config('auth.otp.length'));
        $otp = config('auth.otp.uppercase') ? Str::upper($otp) : $otp;

        $user->oneTimePasswords()->create([
            'code' => $otp,
            'expires_at' => now()->addMinutes(config('auth.otp.expire')),
        ]);
        $user->notify(new OtpCodeGenerated($otp));
    }

    public function verify(User $user, string $code): void
    {
        /** @var \App\Models\OneTimePassword|null $password */
        $password = $user->oneTimePasswords()->active()->latest()->first();

        throw_if(! $password || ! Hash::check($code, $password->code), new ApiException('Invalid OTP', 422));

        Auth::login($user);
        $user->oneTimePasswords()->delete();
    }
}
