<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumWithValues;

enum UserRole: string
{
    use EnumWithValues;

    case ADMIN = 'admin';
    case CUSTOMER = 'customer';
}
