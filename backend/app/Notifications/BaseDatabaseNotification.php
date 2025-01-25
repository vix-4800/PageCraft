<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enums\DatabaseNotificationType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;

abstract class BaseDatabaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Model $model
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the message for the notification.
     */
    abstract protected function getMessage(): string;

    /**
     * Get the type for the notification.
     */
    abstract protected function getType(): DatabaseNotificationType;

    /**
     * Get the details for the notification.
     */
    abstract protected function getDetails(): mixed;

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->getMessage(),
            'type' => $this->getType()->value,
            'details' => $this->getDetails(),
        ];
    }
}
