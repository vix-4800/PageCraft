<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\DtoObject;

final readonly class User implements DtoObject
{
    public function __construct(
        public int $id,
        public bool $isBot,
        public string $firstName,
        public ?string $lastName = null,
        public ?string $username = null,
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['is_bot'],
            $data['first_name'],
            $data['last_name'] ?? null,
            $data['username'] ?? null,
        );
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
}
