<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\URL;

final class GenerateEmailVerificationUrl
{
    public function handle(User $user): string
    {
        $frontendUrl = env('FRONTEND_URL', 'http://localhost').'/verify-email';

        $verifyUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(config('auth.verification.expire', 60)),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        return $frontendUrl.'?verify_url='.base64_encode($verifyUrl);
    }
}
