<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\TelegramKeyboardMarkup;

final class InlineKeyboardMarkup implements TelegramKeyboardMarkup
{
    /**
     * @param  InlineKeyboardButton[][]  $inline_keyboard
     */
    public function __construct(
        public readonly array $inline_keyboard
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['inline_keyboard']
        );
    }

    public function toArray(): array
    {
        return [
            'inline_keyboard' => $this->inline_keyboard,
        ];
    }
}
