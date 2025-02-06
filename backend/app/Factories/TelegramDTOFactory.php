<?php

declare(strict_types=1);

namespace App\Factories;

use App\DTO\Telegram\BotDescription;
use App\DTO\Telegram\BotName;
use App\DTO\Telegram\BotShortDescription;
use App\DTO\Telegram\Chat;
use App\DTO\Telegram\ChatFullInfo;
use App\DTO\Telegram\Message;
use App\DTO\Telegram\User;

class TelegramDTOFactory
{
    public static function createUser(array $data): User
    {
        return new User(
            $data['id'],
            $data['is_bot'],
            $data['first_name'],
            $data['last_name'],
            $data['username'],
        );
    }

    public static function createBotName(array $data): BotName
    {
        return new BotName($data['name']);
    }

    public static function createChat(array $data): Chat
    {
        return new Chat($data['id'], $data['type'], $data['title']);
    }

    public static function createMessage(array $data): Message
    {
        return new Message(
            $data['message_id'],
            self::createUser($data['from']),
            self::createChat($data['chat']),
            $data['date'],
            $data['text'],
        );
    }

    public static function createChatInfo(array $data): ChatFullInfo
    {
        return new ChatFullInfo(
            $data['id'],
            $data['type'],
            $data['title'],
            $data['username'],
            $data['bio'],
            $data['description'],
        );
    }

    public static function createBotDescription(array $data): BotDescription
    {
        return new BotDescription($data['description']);
    }

    public static function createBotShortDescription(array $data): BotShortDescription
    {
        return new BotShortDescription($data['short_description']);
    }
}
