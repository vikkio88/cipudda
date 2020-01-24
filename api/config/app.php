<?php

use Nicu\{
    Handlers\NotAllowedHandler,
    Handlers\NotFoundHandler,
    Handlers\FallbackResponder
};

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
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
            function (RequestInterface $request, ResponseInterface $response, callable $next) {
                // do something
                $response = $next($request, $response);
                return $response;
            }
        ]
    ],
    'stuff' => getenv('SOME_STUFF')
];
