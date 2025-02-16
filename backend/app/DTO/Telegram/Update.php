<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\DtoObject;

class Update implements DtoObject
{
    public function __construct(
        public readonly int $update_id,
        public readonly Message $message,
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

    public static function fromArray(array $data): self
    {
        return new self(
            $data['update_id'],
            Message::fromArray($data['message']),
            CallbackQuery::fromArray($data['callback_query']),
        );
    }
}
