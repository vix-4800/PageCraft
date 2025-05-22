<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\DtoObject;

final readonly class ChatFullInfo implements DtoObject
{
    public function __construct(
        public int $id,
        public string $type,
        public string $title,
        public string $username,
        public string $bio,
        public bool $description,
    ) {
        //
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
}
