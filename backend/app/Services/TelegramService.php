<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\Telegram\BotDescription;
use App\DTO\Telegram\BotName;
use App\DTO\Telegram\BotShortDescription;
use App\DTO\Telegram\Message;
use App\DTO\Telegram\Update;
use App\DTO\Telegram\User;
use App\Exceptions\TelegramException;
use App\Factories\TelegramDTOFactory;
use Illuminate\Support\Facades\Http;

class TelegramService
{
    protected string $token = '';

    protected string|int $chatId = '';

    protected string $baseUrl = 'https://api.telegram.org/bot';

    public function __construct()
    {
        $this->token = config('services.telegram.bot_token');
        $this->chatId = config('services.telegram.chat_id');

        throw_if(empty($this->token) || empty($this->chatId), new TelegramException('Telegram credentials are missing'));

        $this->baseUrl .= $this->token;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getChatId(): string
    {
        return $this->chatId;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Sets the chat ID for the next requests.
     *
     * @param  string|int  $chatId  The chat ID to send the requests to
     */
    public function forChat(string|int $chatId): self
    {
        $this->chatId = $chatId;

        return $this;
    }

    protected function makeRequest(string $method, array $data = []): array|bool
    {
        return Http::post("{$this->baseUrl}/{$method}", $data)->throw()->json();
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

    public function sendMessage(string $message): Message
    {
        return TelegramDTOFactory::createMessage($this->makeRequest('sendMessage', [
            'chat_id' => $this->chatId,
            'text' => $message,
        ]));
    }

    public function editMessage(int $messageId, string $text): Message
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
