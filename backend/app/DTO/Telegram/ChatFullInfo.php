<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\DtoObject;

class ChatFullInfo implements DtoObject
{
    public function __construct(
        public readonly int $id,
        public readonly string $type,
        public readonly string $title,
        public readonly string $username,
        public readonly string $bio,
        public readonly bool $description,
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'username' => $this->username,
            'bio' => $this->bio,
            'description' => $this->description,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['type'],
            $data['title'],
            $data['username'],
            $data['bio'],
            $data['description'],
        );
    }
}
