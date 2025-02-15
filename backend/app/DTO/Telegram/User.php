<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\DtoObject;

class User implements DtoObject
{
    public function __construct(
        public readonly int $id,
        public readonly bool $isBot,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $username,
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'is_bot' => $this->isBot,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'username' => $this->username,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['is_bot'],
            $data['first_name'],
            $data['last_name'],
            $data['username'],
        );
    }
}
