<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\TelegramType;

class CallbackQuery implements TelegramType
{
    public function __construct(
        public readonly string $id,
        public readonly User $from,
        public readonly string $data,
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'from' => $this->from->toArray(),
            'data' => $this->data,
        ];
    }
}
