<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\TelegramType;

class BotShortDescription implements TelegramType
{
    public function __construct(
        public readonly string $short_description
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'short_description' => $this->short_description,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self($data['short_description']);
    }
}
