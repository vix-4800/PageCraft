<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\OAuthDriver;

class CheckOAuthDriver
{
    public function handle(string $driver): bool
    {
        return in_array($driver, OAuthDriver::values());
    }
}
