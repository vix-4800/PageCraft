<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumWithValues;

enum OAuthDriver: string
{
    use EnumWithValues;

    case GOOGLE = 'google';
    case GITHUB = 'github';
}
