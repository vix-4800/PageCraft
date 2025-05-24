<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\UserRole;
use App\Models\SystemReport;
use App\Models\User;
use App\Notifications\SystemStatusWarning;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Notification;

final class SystemReportObserver
{
    /**
     * Handle the SystemReport "creating" event.
     */
    public function creating(SystemReport $systemReport): void
    {
        $systemReport->collected_at = now();
    }

    /**
     * Handle the SystemReport "created" event.
     */
    public function created(SystemReport $systemReport): void
    {
        $warnings = collect();
        if (! $systemReport->is_database_up) {
            $warnings->push('Database connection is down');
        }

        if (! $systemReport->is_cache_up) {
            $warnings->push('Cache connection is down');
        }

        if ($warnings->isNotEmpty()) {
            $admins = User::whereHas('role', fn (Builder $builder): Builder => $builder->where('name', UserRole::ADMIN));

            Notification::send($admins, new SystemStatusWarning($warnings));
        }
    }
}
