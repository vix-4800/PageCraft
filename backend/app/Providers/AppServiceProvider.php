<?php

declare(strict_types=1);

namespace App\Providers;

use App\Actions\GenerateEmailVerificationUrl;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->isProduction()) {
            URL::forceScheme('https');
        }

        VerifyEmail::createUrlUsing(function ($notifiable): string {
            return (new GenerateEmailVerificationUrl)->handle($notifiable);
        });
    }
}
