<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\DtoObject;

final readonly class BotShortDescription implements DtoObject
{
    public function __construct(
        public string $short_description
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self($data['short_description']);
    }

    public function toArray(): array
    {
        return [
            'short_description' => $this->short_description,
        ];
    }
}
