<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\UserRole;
use App\Models\FeedbackMessage;
use App\Models\User;
use App\Notifications\FeedbackMessageCreated;
use Illuminate\Database\Eloquent\Builder;

final class FeedbackMessageObserver
{
    /**
     * Handle the FeedbackMessage "created" event.
     */
    public function created(FeedbackMessage $feedbackMessage): void
    {
        User::whereHas('role', fn (Builder $builder): Builder => $builder->where('name', UserRole::ADMIN))
            ->first()
            ->notify(new FeedbackMessageCreated($feedbackMessage));
    }
}
