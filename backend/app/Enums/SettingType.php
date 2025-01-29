<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumWithValues;

enum SettingType: string
{
    use EnumWithValues;

    case TEXT = 'text';
    case BOOLEAN = 'boolean';
}
