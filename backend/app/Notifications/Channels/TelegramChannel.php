<?php

declare(strict_types=1);

namespace App\Notifications\Channels;

use App\DTO\Telegram\PendingMessage;
use App\Facades\Telegram;
use App\Models\User;
use Illuminate\Notifications\Notification;

class TelegramChannel
{
    public function send(User $notifiable, Notification $notification): void
    {
        /**
         * @var PendingMessage $message
         *
         * @phpstan-ignore-next-line
         */
        $message = $notification->toTelegram($notifiable);

        Telegram::sendMessage($message);
    }
}
