<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\DtoObject;

class ReplyKeyboardMarkup implements DtoObject
{
    /**
     * @param  KeyboardButton[][]  $keyboard
     */
    public function __construct(
        public readonly array $keyboard,
        public readonly bool $is_persistent = false,
        public readonly bool $resize_keyboard = false
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'keyboard' => $this->keyboard,
            'is_persistent' => $this->is_persistent,
            'resize_keyboard' => $this->resize_keyboard,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['keyboard'],
            $data['is_persistent'] ?? false,
            $data['resize_keyboard'] ?? false
        );
    }
}
