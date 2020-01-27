<?php

use Nicu\Actions\Misc\Ping;
use App\Actions\Posts\{CreatePost, GetPosts, GetPost, GetTaggedPosts};

return [
    'routes' => [
        [
            'route' => '/ping',
            'method' => 'get',
            'action' => Ping::class
        ],
        [
            'route' => '/posts',
            'method' => 'get',
            'action' => GetPosts::class
        ],
        [
            'route' => '/posts/tags',
            'method' => 'get',
            'action' => GetTaggedPosts::class
        ],
        [
            'route' => '/post/{slug}',
            'method' => 'get',
            'action' => GetPost::class
        ],
        [
            'route' => '/posts',
            'method' => 'post',
            'action' => CreatePost::class
        ]
    ]
];
