<?php
namespace Hobot;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

class Hobot extends Api
{
    /**
     * @var UpdateProcessorInterface
     */
    private $postProcessor;

    /**
     * @param UpdateProcessorInterface $postProcessor
     */
    public function setPostProcessor(UpdateProcessorInterface $postProcessor)
    {
        $this->postProcessor = $postProcessor;
    }

    /**
     * @inheritdoc
     */
    protected function processCommand(Update $update)
    {
        parent::processCommand($update);
        if ($this->postProcessor instanceof UpdateProcessorInterface) {
            $this->postProcessor->process($update, $this);
        }
    }
}
