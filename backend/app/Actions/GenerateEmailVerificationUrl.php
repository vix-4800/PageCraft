<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\URL;

class GenerateEmailVerificationUrl
{
    public function handle(User $notifiable): string
    {
        $frontendUrl = env('FRONTEND_URL', 'http://localhost').'/verify-email';

        $verifyUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(config('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        return $frontendUrl.'?verify_url='.urlencode($verifyUrl);
    }
}
