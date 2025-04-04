<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\DtoObject;

final class BotDescription implements DtoObject
{
    public function __construct(
        public readonly string $description
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self($data['description']);
    }

    public function toArray(): array
    {
        return [
            'description' => $this->description,
        ];
    }
}
