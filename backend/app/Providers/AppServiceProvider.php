<?php

declare(strict_types=1);

namespace App\Providers;

use App\Actions\GenerateEmailVerificationUrl;
use App\Actions\GeneratePasswordResetUrl;
use App\Mixins\HttpMixin;
use App\Mixins\StrMixin;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Str;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (app()->isLocal() && class_exists(TelescopeServiceProvider::class)) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->isProduction()) {
            URL::forceScheme('https');
        }

        VerifyEmail::createUrlUsing(fn (User $user): string => (new GenerateEmailVerificationUrl)->handle($user));
        ResetPassword::createUrlUsing(fn (User $user, string $token): string => (new GeneratePasswordResetUrl)->handle($user, $token));

        Http::mixin(new HttpMixin);
        Str::mixin(new StrMixin);

        Gate::define('manage-system', fn (User $user): bool => $user->isAdmin());

        DB::prohibitDestructiveCommands(app()->isProduction());
        Model::shouldBeStrict(! app()->isProduction());
    }
}
