<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\DtoObject;

final readonly class Chat implements DtoObject
{
    public function __construct(
        public int $id,
        public string $type,
        public ?string $title = null,
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self($data['id'], $data['type'], $data['title'] ?? null);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
        ];
    }
}
