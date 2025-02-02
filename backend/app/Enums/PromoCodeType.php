<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumWithValues;

enum PromoCodeType: string
{
    use EnumWithValues;

    case FIXED = 'fixed';
    case PERCENTAGE = 'percentage';
}
