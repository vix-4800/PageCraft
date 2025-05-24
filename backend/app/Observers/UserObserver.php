<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\User;
use App\Notifications\AccountDeleted;
use App\Notifications\AccountRegistered;

final class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $user->notify(new AccountRegistered);
        $user->sendEmailVerificationNotification();

        $user->preferences()->create();
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $user->tokens()->delete();

        $user->notify(new AccountDeleted);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
