<?php

use App\Middlewares\AuthGuard;
use Nicu\{
    Handlers\NotAllowedHandler,
    Handlers\NotFoundHandler,
    Handlers\FallbackResponder
};

use Tuupola\Middleware\Cors;

return [
    'app' => [
        // Slim Configurations
        'boot' => [
            'settings.displayErrorDetails' => true,
            'notFoundHandler' => function ($c) {
                return new NotFoundHandler($c);
            },
            'notAllowedHandler' => function ($c) {
                return new NotAllowedHandler($c);
            },
            'responder' => function ($c) {
                return new FallbackResponder($c);
            },
        ],
        // Slim compatible middlewares => config
        'middlewares' => [
            Cors::class => [
                "origin" => ["*"],
                "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
            ],
            AuthGuard::class => [
                'header' => 'authorization',
                'routes' => [
                    'POST' => ['/^\/admin\/.+/'],
                    'GET' => ['/^\/admin\/.+/'],
                    'PUT' => ['/^\/admin\/.+/'],
                ],
                'key' => getenv('KEY')
            ]
        ]
    ]
];
