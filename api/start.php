<?php

include 'vendor/autoload.php';

$config = \Noodlehaus\Config::load(__DIR__ . '/config');

$port = $argv[1] ?? $config->get('app.port');

echo "started server on port $port" . PHP_EOL;
system("php -S localhost:$port router.php");



