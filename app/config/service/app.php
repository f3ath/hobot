<?php
/**
 * Application config
 *
 * @var $app \Hobot\App
 */

use Hobot\Hobot;
use Hobot\UpdateProcessor\EchoMessage;

foreach (['debug', 'env'] as $key) {
    $app[$key] = $app['config'][$key];
}

$app->get('/', function () {
    return 'Hello';
});

$app->post('/webhook/{name}/{token}', function (string $name, string $token) use ($app) {
    $bot_conf = $app['config']['bots'][$name] ?? null;
    $web_token = $bot_conf['web_token'] ?? null;
    if ($token === $web_token) {
        $app->abort(404, 'Bot not found');
    }
    /** @var Hobot $bot */
    $bot = $app["bot.$name"];
    $bot->commandsHandler(true);

})
    ->assert('name', $app['config']['bot_name_regex'])
    ->assert('token', '.+')
    ->bind('webhook');


$app->get('/register/{name}/{password}', function (string $name, string $password) use ($app) {
    $bot_conf = $app['config']['bots'][$name] ?? null;
    if (empty($bot_conf) || $password !== $app['config']['admin_password']) {
        $app->abort(404, 'Bot not found');
    }
    /** @var Hobot $bot */
    $bot = $app["bot.$name"];
    $bot->setWebhook([
        'url' => $app->url('webhook', [
            'name' => $name,
            'token' => $bot_conf['web_token'],
        ])
    ]);
    return 'OK';
})
    ->assert('name', $app['config']['bot_name_regex']);


$app['bot.test'] = function ($app) {
    $bot = new Hobot($app['config']['bots']['test']['api_token']);
    $bot->setPostProcessor($app['processor.echo']);
    return $bot;
};

$app['processor.echo'] = function() {
    return new EchoMessage();
};
