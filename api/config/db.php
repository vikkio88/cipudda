<?php

return [
    'db' => [
        'user' => $_ENV['DB_USER'] ?? '',
        'password' => $_ENV['DB_PASSWORD'] ?? '',
        'name' => $_ENV['DB_NAME'] ?? '',
        'host' => $_ENV['DB_HOST'] ?? '',
        'port' => $_ENV['DB_PORT'] ?? '',
    ]
];
