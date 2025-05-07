<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class AccountRegistered extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(User $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Account Registered')
            ->greeting(sprintf('Hello, %s!', $notifiable->name))
            ->line('Welcome to our platform! We are thrilled to have you join our community.')
            ->line('Explore and enjoy the features we offer. If you have any questions, feel free to reach out.')
            ->salutation('We are excited to have you on board');
    }
}
