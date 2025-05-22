<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\TelegramKeyboardMarkup;

final readonly class InlineKeyboardButton implements TelegramKeyboardMarkup
{
    public function __construct(
        public string $text,
        public string $url = '',
        public string $callback_data = '',
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['text'],
            $data['url'] ?? '',
            $data['callback_data'] ?? '',
        );
    }

    public function toArray(): array
    {
        return [
            'text' => $this->text,
            'url' => $this->url,
            'callback_data' => $this->callback_data,
        ];
    }
}
