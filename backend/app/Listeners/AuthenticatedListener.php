<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;

final class AuthenticatedListener implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(Login $login): void
    {
        /** @var User $user */
        $user = $login->user;

        $user->updateLastSignInTimestamp();
    }
}
