<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enums\DatabaseNotificationType;

class DatabaseBackupCreated extends BaseDatabaseNotification
{
    protected function getType(): DatabaseNotificationType
    {
        return DatabaseNotificationType::DATABASE_BACKUP;
    }

    protected function getMessage(): string
    {
        return 'Database backup created';
    }

    protected function getDetails(): array
    {
        return [];
    }
}
