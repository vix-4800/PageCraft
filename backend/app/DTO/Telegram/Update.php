<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\TelegramType;

class Update implements TelegramType
{
    public function __construct(
        public readonly int $update_id,
        public readonly ReceivedMessage $message,
        public readonly CallbackQuery $callback_query,
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'update_id' => $this->update_id,
            'message' => $this->message->toArray(),
            'callback_query' => $this->callback_query->toArray(),
        ];
    }
}
