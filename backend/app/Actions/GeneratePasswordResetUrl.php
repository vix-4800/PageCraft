<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;

final class GeneratePasswordResetUrl
{
    public function handle(User $user, string $token): string
    {
        $frontendUrl = env('FRONTEND_URL', 'http://localhost').'/reset-password';

        return sprintf('%s?token=%s&email=%s', $frontendUrl, $token, $user->getEmailForPasswordReset());
    }
}
