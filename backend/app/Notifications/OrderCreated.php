<?php

declare(strict_types=1);

namespace App\Notifications;

use App\DTO\Telegram\TelegramMessage;
use App\Enums\DatabaseNotificationType;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Models\User;
use App\Notifications\Channels\TelegramChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

final class OrderCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private readonly Order $order
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(User $user): array
    {
        return ['database', TelegramChannel::class];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(User $user): array
    {
        return [
            'message' => 'Order created',
            'type' => DatabaseNotificationType::ORDER->value,
            'details' => new OrderResource($this->order),
        ];
    }

    public function toTelegram(User $user): TelegramMessage
    {
        return (new TelegramMessage)
            ->to($user->telegramAccount->chat_id)
            ->text('Order created');
    }
}
