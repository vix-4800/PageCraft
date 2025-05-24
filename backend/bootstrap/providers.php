<?php

declare(strict_types=1);

use App\Providers\AppServiceProvider;
use App\Providers\DatabaseProvider;
use App\Providers\DeliveryServiceProvider;
use App\Providers\FortifyServiceProvider;

return [
    AppServiceProvider::class,
    DatabaseProvider::class,
    DeliveryServiceProvider::class,
    FortifyServiceProvider::class,
];
