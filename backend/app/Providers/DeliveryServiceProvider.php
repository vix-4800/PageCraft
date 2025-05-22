<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\DeliveryService;
use App\Services\Delivery\SdekService;
use Illuminate\Support\ServiceProvider;

final class DeliveryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DeliveryService::class, function (): DeliveryService {
            $sdekService = new SdekService(config('services.sdek.client_id'), config('services.sdek.client_secret'));

            return $sdekService;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
