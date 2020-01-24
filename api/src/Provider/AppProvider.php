<?php


namespace App\Provider;


use Nicu\Providers\Provider;
use Noodlehaus\Config;
use Pixie\Connection;
use Pixie\QueryBuilder\QueryBuilderHandler;
use Psr\Container\ContainerInterface;

class AppProvider extends Provider
{

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
    }
}
