<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\DeliveryService;
use App\Services\Delivery\SdekService;
use Illuminate\Support\ServiceProvider;

class DeliveryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DeliveryService::class, function (): DeliveryService {
            $deliveryService = new SdekService(config('services.sdek.client_id'), config('services.sdek.client_secret'));

            return $deliveryService;
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
