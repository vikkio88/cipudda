<?php
include 'vendor/autoload.php';

use App\Actions\Admin\CreatePost;
use App\Actions\Admin\GetPosts as AdmGetPosts;
use App\Actions\Posts\GetPosts;
use App\Middlewares\AuthGuard;
use App\Middlewares\Cors;
use App\Provider\AppProvider;
use DI\Bridge\Slim\Bridge;
use Noodlehaus\Config;
use Slim\Routing\RouteCollectorProxy;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

$config = new Config(__DIR__ . "/config");

$container = new DI\Container();
$container->set(Config::class, $config);
$app = Bridge::create($container);
(new AppProvider($app))->boot();

// Setting up Cors
$app->add(Cors::class);
$app->options('/{routes:.+}', function ($_, $response) {
    return $response;
});


$app->get('/posts', GetPosts::class);
$app->group('/admin', function (RouteCollectorProxy $group) {
    $group->get('/posts', AdmGetPosts::class);
    $group->post('/posts', CreatePost::class);

})->add(AuthGuard::class);

$app->run();





