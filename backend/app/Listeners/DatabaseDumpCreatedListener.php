<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Enums\UserRole;
use App\Events\DatabaseDumpCreated;
use App\Models\User;
use App\Notifications\DatabaseBackupCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;

final class DatabaseDumpCreatedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DatabaseDumpCreated $databaseDumpCreated): void
    {
        User::whereHas('role', fn (Builder $builder): Builder => $builder->where('name', UserRole::ADMIN))
            ->first()
            ->notify(new DatabaseBackupCreated);
    }
}
