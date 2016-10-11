<?php
return [
    'secure_json' => false,
    'service' => [
        'app.php', // must be processed first
    ],
    'debug' => false,
    'bot_name_regex' => '[a-z0-9]+',
    'admin_password' => 'changeme',
    'bots' => [
        'test' => [
            'api_token' => 'xxx',
            'web_token' => 'xxx',
            'commands' => [],
        ]
    ]
];
