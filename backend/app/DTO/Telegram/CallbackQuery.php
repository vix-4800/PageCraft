<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\DtoObject;

final class CallbackQuery implements DtoObject
{
    public function __construct(
        public readonly string $id,
        public readonly User $from,
        public readonly string $data,
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            User::fromArray($data['from']),
            $data['data'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'from' => $this->from->toArray(),
            'data' => $this->data,
        ];
    }
}
