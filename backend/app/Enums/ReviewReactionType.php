<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumWithValues;

enum ReviewReactionType: string
{
    use EnumWithValues;

    case LIKE = 'like';
    case DISLIKE = 'dislike';
}
