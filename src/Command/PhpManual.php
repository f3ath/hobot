<?php
namespace Hobot\Command;

use PHPCurl\CurlWrapper\Curl;
use Telegram\Bot\Commands\Command;

class PhpManual extends Command
{
    protected $name = "php";

    protected $description = "Performs search on php.net, shows the most relevant url";

    /**
     * @var Curl
     */
    private $curl;

    /**
     * PhpManual constructor.
     * @param Curl $curl
     */
    public function __construct(Curl $curl)
    {
        $this->curl = $curl;
    }

    /**
     * {@inheritdoc}
     */
    public function handle($arguments)
    {
        $this->curl->init('http://php.net/' . urlencode($arguments));
        $this->curl->setOptArray([
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $this->curl->exec();
        $this->telegram->sendMessage([
            'text' => $this->curl->getInfo(CURLINFO_EFFECTIVE_URL),
        ]);
    }
}
