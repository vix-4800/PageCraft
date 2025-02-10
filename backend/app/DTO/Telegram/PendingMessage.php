<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\TelegramType;
use App\Facades\Telegram;

class PendingMessage implements TelegramType
{
    public int|string $chatId;

    public string $text;

    public bool $disable_notification;

    public InlineKeyboardMarkup|ReplyKeyboardMarkup|null $keyboard = null;

    public function __construct()
    {
        $this->chatId = Telegram::getChatId();
        $this->disable_notification = false;
    }

    public function to(int $chatId): self
    {
        $this->chatId = $chatId;

        return $this;
    }

    public function text(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function disableNotification(): self
    {
        $this->disable_notification = true;

        return $this;
    }

    public function withKeyboard(InlineKeyboardMarkup|ReplyKeyboardMarkup $keyboard): self
    {
        $this->keyboard = $keyboard;

        return $this;
    }

    public function toArray(): array
    {
        $message = [
            'chat_id' => $this->chatId,
            'text' => $this->text,
        ];

        if ($this->disable_notification) {
            $message['disable_notification'] = $this->disable_notification;
        }

        if ($this->keyboard) {
            $message['reply_markup'] = $this->keyboard;
        }

        return $message;
    }
}
