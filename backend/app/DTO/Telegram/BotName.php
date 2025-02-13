<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\TelegramType;

class BotName implements TelegramType
{
    public function __construct(
        public readonly string $name,
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self($data['name']);
    }
}
