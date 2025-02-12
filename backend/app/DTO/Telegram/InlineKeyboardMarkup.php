<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\TelegramType;

class InlineKeyboardMarkup implements TelegramType
{
    /**
     * @param  InlineKeyboardButton[][]  $inline_keyboard
     */
    public function __construct(
        public readonly array $inline_keyboard
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'inline_keyboard' => $this->inline_keyboard,
        ];
    }
}
