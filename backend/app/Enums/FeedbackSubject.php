<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumWithValues;

enum FeedbackSubject: string
{
    use EnumWithValues;

    case General = 'general';
    case Support = 'support';
    case Other = 'other';
}
