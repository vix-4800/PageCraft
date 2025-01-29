<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;

class GeneratePasswordResetUrl
{
    public function handle(User $notifiable, string $token): string
    {
        $frontendUrl = env('FRONTEND_URL', 'http://localhost').'/reset-password';

        return "$frontendUrl?token=$token&email={$notifiable->getEmailForPasswordReset()}";
    }
}
