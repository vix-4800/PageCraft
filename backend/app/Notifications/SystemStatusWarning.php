<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

final class SystemStatusWarning extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private readonly Collection $warnings
    ) {
        //
    }

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
        $warnings = $this->warnings->map(fn (string $warning): string => "- {$warning}")->join("\n");

        return (new MailMessage)
            ->subject('System Status Warning')
            ->line('The system has detected some issues that require your attention.')
            ->line('Please review the warnings listed below and take appropriate action to ensure the smooth operation of your application.')
            ->line($warnings);
    }
}
