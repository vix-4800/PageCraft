<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Facades\Telegram;
use PHPUnit\Framework\TestCase;

class TelegramTest extends TestCase
{
    public function test_bot_is_working(): void
    {
        Telegram::getMe();
    }
}
