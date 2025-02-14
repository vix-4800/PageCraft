<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\DtoObject;

class InlineKeyboardButton implements DtoObject
{
    public function __construct(
        public readonly string $text,
        public readonly string $url = '',
        public readonly string $callback_data = '',
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'text' => $this->text,
            'url' => $this->url,
            'callback_data' => $this->callback_data,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['text'],
            $data['url'] ?? '',
            $data['callback_data'] ?? '',
        );
    }
}
