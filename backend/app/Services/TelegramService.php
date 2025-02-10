<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\Telegram\BotDescription;
use App\DTO\Telegram\BotName;
use App\DTO\Telegram\BotShortDescription;
use App\DTO\Telegram\PendingMessage;
use App\DTO\Telegram\ReceivedMessage;
use App\DTO\Telegram\Update;
use App\DTO\Telegram\User;
use App\Exceptions\TelegramException;
use App\Factories\TelegramDTOFactory;
use Illuminate\Support\Facades\Http;

class TelegramService
{
    protected string|int $chatId = '';

    public function __construct()
    {
        $this->chatId = config('services.telegram.chat_id');

        throw_if(empty($this->chatId), new TelegramException('Telegram credentials are missing'));
    }

    public function getChatId(): string|int
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
        return TelegramDTOFactory::createUser($this->makeRequest('getMe'));
    }

    public function setBotName(string $name): true
    {
        return $this->makeRequest('setMyName', ['name' => $name]);
    }

    public function getBotName(): BotName
    {
        return TelegramDTOFactory::createBotName($this->makeRequest('getMyName'));
    }

    public function setBotDescription(string $description): bool
    {
        return $this->makeRequest('setMyDescription', ['description' => $description]);
    }

    public function getBotDescription(): BotDescription
    {
        return TelegramDTOFactory::createBotDescription($this->makeRequest('getMyDescription'));
    }

    public function getBotShortDescription(): BotShortDescription
    {
        return TelegramDTOFactory::createBotShortDescription($this->makeRequest('getMyShortDescription'));
    }

    public function setBotShortDescription(string $shortDescription): bool
    {
        return $this->makeRequest('setMyShortDescription', ['short_description' => $shortDescription]);
    }

    public function sendMessage(string|PendingMessage $message): ReceivedMessage
    {
        $data = is_string($message)
            ? ['chat_id' => $this->chatId, 'text' => $message]
            : $message->toArray();

        return TelegramDTOFactory::createMessage($this->makeRequest('sendMessage', $data));
    }

    public function editMessage(int $messageId, string $text): ReceivedMessage
    {
        return TelegramDTOFactory::createMessage($this->makeRequest('editMessageText', [
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
        return TelegramDTOFactory::createUpdate($this->makeRequest('getUpdates'));
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
