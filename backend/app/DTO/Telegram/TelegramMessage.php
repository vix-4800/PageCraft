<?php

declare(strict_types=1);

namespace App\DTO\Telegram;

use App\Contracts\DtoObject;
use App\Contracts\TelegramKeyboardMarkup;

class TelegramMessage implements DtoObject
{
    public int|string|null $chatId = null;

    public string $text;

    public bool $disable_notification = false;

    public ?TelegramKeyboardMarkup $keyboard = null;

    /**
     * Set the chat ID to send the message to.
     *
     * @param  int|string  $chatId  The chat ID to send the message to.
     */
    public function to(int|string $chatId): self
    {
        $this->chatId = $chatId;

        return $this;
    }

    /**
     * Set the text of the message.
     *
     * @param  string  $text  The text of the message.
     */
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

    public function withKeyboard(TelegramKeyboardMarkup $keyboard): self
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

    public static function fromArray(array $data): self
    {
        return (new self)
            ->to($data['chat_id'])
            ->text($data['text']);
    }
}
