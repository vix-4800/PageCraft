<?php

declare(strict_types=1);

namespace App\Jobs;

use App\DTO\Telegram\TelegramMessage;
use App\DTO\Telegram\Update;
use App\Facades\Telegram;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class TelegramUpdateHandler implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     *
     * @param  array<Update>  $updates
     */
    public function __construct(
        private readonly array $updates
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->updates as $update) {
            $this->handleUpdate($update);
        }
    }

    protected function handleUpdate(Update $update): void
    {
        $message = (new TelegramMessage)->to($update->message->chat->id)->text('Вы написали: '.$update->message->text);

        Telegram::sendMessage($message);
    }
}
