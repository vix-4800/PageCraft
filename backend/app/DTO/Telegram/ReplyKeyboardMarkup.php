<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\DtoObject;

final readonly class ReplyKeyboardMarkup implements DtoObject
{
    /**
     * @param  KeyboardButton[][]  $keyboard
     */
    public function __construct(
        public array $keyboard,
        public bool $is_persistent = false,
        public bool $resize_keyboard = false
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['keyboard'],
            $data['is_persistent'] ?? false,
            $data['resize_keyboard'] ?? false
        );
    }

    public function toArray(): array
    {
        return [
            'keyboard' => $this->keyboard,
            'is_persistent' => $this->is_persistent,
            'resize_keyboard' => $this->resize_keyboard,
        ];
    }
}
