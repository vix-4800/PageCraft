<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\Telegram\BotDescription;
use App\DTO\Telegram\BotName;
use App\DTO\Telegram\BotShortDescription;
use App\DTO\Telegram\Message;
use App\DTO\Telegram\TelegramMessage;
use App\DTO\Telegram\Update;
use App\DTO\Telegram\User;
use Illuminate\Support\Facades\Http;

class TelegramService
{
    protected string|int|null $chatId = null;

    public function __construct()
    {
        //
    }

    public function getChatId(): string|int|null
    {
        return $this->chatId;
    }

    /**
     * Sets the chat ID for the next requests.
     *
     * @param  string|int  $chatId  The chat ID to send the requests to
     */
    public function to(string|int $chatId): self
    {
        $this->chatId = $chatId;

        return $this;
    }

    protected function makeRequest(string $method, array $data = []): array|bool
    {
        return Http::telegram()->post($method, $data)->throw()->json();
    }

    public function getMe(): User
    {
        return User::fromArray($this->makeRequest('getMe'));
    }

    public function setBotName(string $name): true
    {
        return $this->makeRequest('setMyName', ['name' => $name]);
    }

    public function getBotName(): BotName
    {
        return BotName::fromArray($this->makeRequest('getMyName'));
    }

    public function setBotDescription(string $description): bool
    {
        return $this->makeRequest('setMyDescription', ['description' => $description]);
    }

    public function getBotDescription(): BotDescription
    {
        return BotDescription::fromArray($this->makeRequest('getMyDescription'));
    }

    public function getBotShortDescription(): BotShortDescription
    {
        return BotShortDescription::fromArray($this->makeRequest('getMyShortDescription'));
    }

    public function setBotShortDescription(string $shortDescription): bool
    {
        return $this->makeRequest('setMyShortDescription', ['short_description' => $shortDescription]);
    }

    /**
     * Sends a message using the Telegram API.
     *
     * @param  TelegramMessage  $message  The message to be sent.
     * @return Message The message received after being sent.
     */
    public function sendMessage(TelegramMessage $message): Message
    {
        return Message::fromArray($this->makeRequest('sendMessage', $message->toArray())['result']);
    }

    public function editMessage(int $messageId, string $text): Message
    {
        return Message::fromArray($this->makeRequest('editMessageText', [
            'chat_id' => $this->chatId,
            'message_id' => $messageId,
            'text' => $text,
        ]));
    }

    public function deleteMessage(int $messageId): bool
    {
        return $this->makeRequest('deleteMessage', [
            'chat_id' => $this->chatId,
            'message_id' => $messageId,
        ]);
    }

    /**
     * @param  array<int>  $messageIds
     */
    public function deleteMessages(array $messageIds): bool
    {
        return $this->makeRequest('deleteMessages', [
            'chat_id' => $this->chatId,
            'message_ids' => $messageIds,
        ]);
    }

    public function getUpdates(): Update
    {
        return Update::fromArray($this->makeRequest('getUpdates'));
    }

    public function setWebhook(string $url): bool
    {
        return $this->makeRequest('setWebhook', ['url' => $url]);
    }

    public function deleteWebhook(): bool
    {
        return $this->makeRequest('deleteWebhook');
    }
}
