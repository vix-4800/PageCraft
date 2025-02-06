<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\TelegramException;
use Illuminate\Support\Facades\Http;

class TelegramService
{
    protected string $token = '';

    protected string $chatId = '';

    protected string $baseUrl = 'https://api.telegram.org/bot';

    public function __construct()
    {
        $this->token = config('services.telegram.bot_token');
        $this->chatId = config('services.telegram.chat_id');

        throw_if(empty($this->token) || empty($this->chatId), new TelegramException('Telegram credentials are missing'));

        $this->baseUrl .= "{$this->token}/";
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

    protected function makeRequest(string $method, array $data = []): void
    {
        Http::post($this->baseUrl.$method, $data)->throw()->json();
    }

    public function getMe(): void
    {
        $this->makeRequest('getMe');
    }

    public function setBotName(string $name): void
    {
        $this->makeRequest('setMyName', ['name' => $name]);
    }

    public function getBotName(): void
    {
        $this->makeRequest('getMyName');
    }

    public function setBotDescription(string $description): void
    {
        $this->makeRequest('setMyDescription', ['description' => $description]);
    }

    public function getBotDescription(): void
    {
        $this->makeRequest('getMyDescription');
    }

    public function getBotShortDescription(): void
    {
        $this->makeRequest('getMyShortDescription');
    }

    public function setBotShortDescription(string $shortDescription): void
    {
        $this->makeRequest('setMyShortDescription', ['short_description' => $shortDescription]);
    }

    public function sendMessage(string $message): void
    {
        $this->makeRequest('sendMessage', [
            'chat_id' => $this->chatId,
            'text' => $message,
        ]);
    }

    public function editMessage(int $messageId, string $text): void
    {
        $this->makeRequest('editMessageText', [
            'chat_id' => $this->chatId,
            'message_id' => $messageId,
            'text' => $text,
        ]);
    }

    public function deleteMessage(int $messageId): void
    {
        $this->makeRequest('deleteMessage', [
            'chat_id' => $this->chatId,
            'message_id' => $messageId,
        ]);
    }

    /**
     * @param  array<int>  $messageIds
     */
    public function deleteMessages(array $messageIds): void
    {
        $this->makeRequest('deleteMessages', [
            'chat_id' => $this->chatId,
            'message_ids' => $messageIds,
        ]);
    }
}
