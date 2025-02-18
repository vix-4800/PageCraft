<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\DtoObject;

class Chat implements DtoObject
{
    public function __construct(
        public readonly int $id,
        public readonly string $type,
        public readonly ?string $title = null,
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self($data['id'], $data['type'], $data['title'] ?? null);
    }
}
