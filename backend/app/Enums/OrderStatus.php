<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumWithValues;

enum OrderStatus: string
{
    use EnumWithValues;

    case CREATED = 'created';
    case PACKED = 'packed';
    case PROCESSING = 'processing';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';
}
