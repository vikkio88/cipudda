<?php
include 'vendor/autoload.php';

use Dotenv\Dotenv;
use Nicu\Nicu;


(new Dotenv(__DIR__))->load();

(Nicu::getInstance(
    __DIR__ . '/config'
))->run();





