<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\DtoObject;

class BotDescription implements DtoObject
{
    public function __construct(
        public readonly string $description
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'description' => $this->description,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self($data['description']);
    }
}
