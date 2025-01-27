<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumWithValues;

enum ArticleStatus: string
{
    use EnumWithValues;

    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';
}
