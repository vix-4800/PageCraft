<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Http\Resources\FeedbackMessageResource;
use App\Models\FeedbackMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class FeedbackMessageCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private readonly FeedbackMessage $message
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'New feedback message received.',
            'type' => 'feedback_message',
            'details' => new FeedbackMessageResource($this->message),
        ];
    }
}
