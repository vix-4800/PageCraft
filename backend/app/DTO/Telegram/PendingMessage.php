<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Facades\Telegram;

class PendingMessage
{
    public readonly int|string $chatId;

    public readonly string $text;

    public readonly bool $disable_notification;

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

    public function toArray(): array
    {
        return [
            'chat_id' => $this->chatId,
            'text' => $this->text,
            'disable_notification' => $this->disable_notification,
        ];
    }
}
