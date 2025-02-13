<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\TelegramType;

class ReceivedMessage implements TelegramType
{
    public function __construct(
        public readonly int $message_id,
        public readonly User $from,
        public readonly Chat $chat,
        public readonly int $date,
        public readonly string $text,
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'message_id' => $this->message_id,
            'from' => $this->from->toArray(),
            'chat' => $this->chat->toArray(),
            'date' => $this->date,
            'text' => $this->text,
        ];
    }

    public static function fromArray(array $data): ReceivedMessage
    {
        return new ReceivedMessage(
            $data['message_id'],
            User::fromArray($data['from']),
            Chat::fromArray($data['chat']),
            $data['date'],
            $data['text'],
        );
    }
}
