<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\DtoObject;

class KeyboardButton implements DtoObject
{
    public function __construct(
        public readonly string $text,
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'text' => $this->text,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['text'],
        );
    }
}
