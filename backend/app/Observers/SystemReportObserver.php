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

        if ($systemReport->cpu_usage > 80) {
            $warnings->push("CPU usage is high, {$systemReport->cpu_usage} %");
        }

        if ($systemReport->ram_usage / $systemReport->ram_total > 0.8) {
            $warnings->push("RAM usage is high, {$systemReport->ram_usage} MB used of {$systemReport->ram_total} MB total");
        }

        if ($warnings->isNotEmpty()) {
            $admins = User::whereHas('role', fn (Builder $query): Builder => $query->where('name', UserRole::ADMIN));

            Notification::send($admins, new SystemStatusWarning($warnings));
        }
    }
}
