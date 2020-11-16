<?php


namespace App\Provider;

use App\Middlewares\AuthGuard;
use Noodlehaus\Config;
use Pixie\Connection;
use Pixie\QueryBuilder\QueryBuilderHandler;
use Psr\Container\ContainerInterface;
use Slim\App;

class AppProvider
{
    /**
     * @var App
     */
    private $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    private function bind($abstract, $concrete)
    {
        $this->app->getContainer()->set($abstract, $concrete);
    }

    public function boot()
    {
        $this->bind(QueryBuilderHandler::class, function (ContainerInterface $container) {
            $config = $container->get(Config::class);

            $username = $config->get('db.user');
            $password = $config->get('db.password');
            $dbName = $config->get('db.name');
            $dbHost = $config->get('db.host');
            $dbPort = $config->get('db.port');

            $connection = new Connection('mysql', [
                'driver' => 'mysql',
                'host' => $dbHost,
                'database' => $dbName,
                'port' => $dbPort,
                'username' => $username,
                'password' => $password
            ]);
            return new QueryBuilderHandler($connection);
        });

        $this->bind(AuthGuard::class, function (ContainerInterface $container) {
            $config = $container->get(Config::class);
            return new AuthGuard([
                'header' => 'x-api-key',
                'key' => $config->get('app.apiKey')
            ]);
        });
    }
}
