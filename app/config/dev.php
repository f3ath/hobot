<?php
return array_replace_recursive(
    require __DIR__ . '/common.php',
    [
        'secure_json' => __DIR__ . '/local.json',
        'debug' => true, //used by error handler
    ]
);
