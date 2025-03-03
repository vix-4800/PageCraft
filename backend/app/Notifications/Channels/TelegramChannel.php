<?php

declare(strict_types=1);

namespace App\Notifications\Channels;

use App\DTO\Telegram\TelegramMessage;
use App\Facades\Telegram;
use App\Models\User;
use Illuminate\Notifications\Notification;

final class TelegramChannel
{
    public function send(User $notifiable, Notification $notification): void
    {
        /**
         * @var TelegramMessage $message
         *
         * @phpstan-ignore-next-line
         */
        $message = $notification->toTelegram($notifiable);

        Telegram::sendMessage($message);
    }
}
