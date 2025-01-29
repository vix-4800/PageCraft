<?php

declare(strict_types=1);

namespace App\Enums;

enum DatabaseNotificationType: string
{
    case ORDER = 'order';
    case FEEDBACK_MESSAGE = 'feedback_message';
    case DATABASE_BACKUP = 'database_backup';
}
