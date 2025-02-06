<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\TelegramType;

class Chat implements TelegramType
{
    public function __construct(
        public readonly int $id,
        public readonly string $type,
        public readonly string $title,
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
        ];
    }
}
