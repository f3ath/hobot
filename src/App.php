<?php
namespace Hobot;

use Silex\Application;

class App extends Application
{
    use Application\UrlGeneratorTrait;

    public function __construct(array $config = [])
    {
        $config = array_merge(
            [
                'secure_json' => false,
                'service'     => [],
            ],
            $config
        );

        // load secure config
        $secureConfig = $config['secure_json'];
        if ($secureConfig && file_exists($secureConfig)) {
            $config = array_replace_recursive(
                $config,
                json_decode(file_get_contents($secureConfig), true)
            );
        }

        parent::__construct(['config' => $config]);

        //load service
        $app = $this; // used in includes
        foreach ($config['service'] as $serviceLoader) {
            include __DIR__ . '/../app/config/service/' . $serviceLoader;
        }
    }

    public static function createByEnvironment(string $env = null): self
    {
        if (empty($env)) {
            $env = getenv('APP_ENV') ?: 'prod';
        }
        $config = include sprintf(__DIR__ . '/../app/config/%s.php', $env);
        $config['env'] = $env;
        return new self($config);
    }
}
