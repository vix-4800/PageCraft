<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Notifications\OtpCode;
use Str;

class OTPService
{
    public function request(User $user): void
    {
        $user->oneTimePasswords()->delete();

        $otp = Str::random(6);

        $user->oneTimePasswords()->create([
            'code' => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        $user->notify(new OtpCode($otp));
    }

    public function verify(User $user, string $otp): void
    {
        $password = $user->oneTimePasswords()->firstWhere('code', $otp);
    }
}
