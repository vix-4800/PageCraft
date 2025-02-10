<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\TelegramType;

class ReplyKeyboardMarkup implements TelegramType
{
    /**
     * @param  KeyboardButton[][]  $keyboard
     */
    public function __construct(
        public readonly array $keyboard,
        public readonly bool $is_persistent = false,
        public readonly bool $resize_keyboard = false
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'keyboard' => $this->keyboard,
        ];
    }
}
