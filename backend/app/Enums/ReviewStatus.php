<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumWithValues;

enum ReviewStatus: string
{
    use EnumWithValues;

    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
