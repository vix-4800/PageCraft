<?php

declare(strict_types=1);

namespace App\Providers;

use App\Actions\GenerateEmailVerificationUrl;
use App\Actions\GeneratePasswordResetUrl;
use App\Facades\Server;
use App\Mixins\HttpMixin;
use App\Models\User;
use App\Services\ServerService;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Server::class, ServerService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->isProduction()) {
            URL::forceScheme('https');
        }

        VerifyEmail::createUrlUsing(fn (User $notifiable): string => (new GenerateEmailVerificationUrl)->handle($notifiable));
        ResetPassword::createUrlUsing(fn (User $notifiable, string $token): string => (new GeneratePasswordResetUrl)->handle($notifiable, $token));

        Http::mixin(new HttpMixin);
    }
}
