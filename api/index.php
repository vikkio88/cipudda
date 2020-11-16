<?php
include 'vendor/autoload.php';

use App\Actions\Admin\CreatePost;
use App\Actions\Posts\GetPosts;
use App\Provider\AppProvider;
use DI\Bridge\Slim\Bridge;
use Noodlehaus\Config;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

$config = new Config(__DIR__ . "/config");

$container = new DI\Container();
$container->set(Config::class, $config);
$app = Bridge::create($container);
(new AppProvider($app))->boot();

$app->add(function (\Slim\Psr7\Request $request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', $request->getHeaderLine('origin'))
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
        ->withHeader('Access-Control-Allow-Credentials', 'true');
});
$app->options('/{routes:.+}', function ($request, $response) {
    return $response;
});



$app->get('/posts', GetPosts::class);
$app->post('/admin/posts', CreatePost::class);

$app->run();





