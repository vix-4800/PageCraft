<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\OAuthDriver;

final class CheckOAuthDriver
{
    public function handle(string $driver): bool
    {
        return in_array($driver, OAuthDriver::values());
    }
}
