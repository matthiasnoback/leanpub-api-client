<?php
declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = new Dotenv();

$dotenv->load(dirname(__DIR__) . '/.env.dist');
$dotenv->load(dirname(__DIR__) . '/.env.test');
