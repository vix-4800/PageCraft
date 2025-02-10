<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\TelegramType;

class KeyboardButton implements TelegramType
{
    public function __construct(
        public readonly string $text,
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'text' => $this->text,
        ];
    }
}
