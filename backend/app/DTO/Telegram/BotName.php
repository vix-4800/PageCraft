<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\DtoObject;

final readonly class BotName implements DtoObject
{
    public function __construct(
        public string $name,
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self($data['name']);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
