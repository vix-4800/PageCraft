<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\DtoObject;

final readonly class Message implements DtoObject
{
    public function __construct(
        public int $message_id,
        public User $user,
        public Chat $chat,
        public int $date,
        public ?string $text = null,
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['message_id'],
            User::fromArray($data['from']),
            Chat::fromArray($data['chat']),
            $data['date'],
            $data['text'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'message_id' => $this->message_id,
            'from' => $this->user->toArray(),
            'chat' => $this->chat->toArray(),
            'date' => $this->date,
            'text' => $this->text,
        ];
    }
}
