<?php
namespace Hobot;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

interface UpdateProcessorInterface
{
    /**
     * @param Update $update
     * @param Api    $api
     * @return void
     */
    public function process(Update $update, Api $api);
}
