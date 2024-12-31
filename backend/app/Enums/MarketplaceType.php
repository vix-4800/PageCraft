<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumWithValues;

enum MarketplaceType: string
{
    use EnumWithValues;

    case WILDBERRIES = 'wildberries';
    case YANDEX = 'yandex';
    case OZON = 'ozon';
}
