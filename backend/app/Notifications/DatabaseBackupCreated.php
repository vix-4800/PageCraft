<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enums\DatabaseNotificationType;

final class DatabaseBackupCreated extends BaseDatabaseNotification
{
    protected function getType(): DatabaseNotificationType
    {
        return DatabaseNotificationType::DATABASE_BACKUP;
    }

    protected function getMessage(): string
    {
        return 'Database backup created';
    }

    /**
     * @return array<string, mixed>
     */
    protected function getDetails(): array
    {
        return [];
    }
}
