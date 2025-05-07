<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\DtoObject;

final readonly class Update implements DtoObject
{
    public function __construct(
        public int $update_id,
        public Message $message,
        public ?CallbackQuery $callback_query = null,
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['update_id'],
            Message::fromArray($data['message']),
            isset($data['callback_query']) ? CallbackQuery::fromArray($data['callback_query']) : null,
        );
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
