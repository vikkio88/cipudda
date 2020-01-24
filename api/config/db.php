<?php

return [
    'db' => [
        'user' => getenv('DB_USER') ?? '',
        'password' => getenv('DB_PASSWORD') ?? '',
        'name' => getenv('DB_NAME') ?? '',
        'host' => getenv('DB_HOST') ?? '',
        'port' => getenv('DB_PORT') ?? '',
    ]
];
