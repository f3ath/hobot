<?php
namespace Hobot\UpdateProcessor;

use Hobot\UpdateProcessorInterface;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

class EchoMessage implements UpdateProcessorInterface
{
    public function process(Update $update, Api $api)
    {
        $message = $update->getMessage();
        $chat = $message->getChat();
        if ($chat->getType() !== 'private' || empty($message->getText())) {
            return;
        }
        $api->sendMessage([
            'chat_id' => $chat->getId(),
            'text' => $message->getText(),
        ]);
    }
}
