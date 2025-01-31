<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\SystemReport;

class SystemReportObserver
{
    /**
     * Handle the SystemReport "creating" event.
     */
    public function creating(SystemReport $systemReport): void
    {
        $systemReport->collected_at = now();
    }
}
