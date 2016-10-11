<?php
return array_replace_recursive(
    require __DIR__ . '/common.php',
    [
        'secure_json' => '/etc/hobot.json',
    ]
);
