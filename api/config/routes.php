<?php

use App\Actions\Admin\{CreatePost, GetPosts as AdminGetPosts, DeletePost, UpdatePost};
use Nicu\Actions\Misc\Ping;
use App\Actions\Posts\{GetPosts, GetPost, GetTaggedPosts};

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

        // admin
        [
            'route' => '/admin/posts',
            'method' => 'post',
            'action' => CreatePost::class
        ],
        [
            'route' => '/admin/posts',
            'method' => 'get',
            'action' => AdminGetPosts::class
        ],
        [
            'route' => '/admin/post/{slug}',
            'method' => 'delete',
            'action' => DeletePost::class
        ],
        [
            'route' => '/admin/post/{slug}',
            'method' => 'put',
            'action' => UpdatePost::class
        ]
    ]
];
