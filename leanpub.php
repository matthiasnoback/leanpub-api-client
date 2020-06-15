#!/usr/bin/env php
<?php
declare(strict_types=1);

$projectRootDir = null;

foreach (array(__DIR__ . '/../../autoload.php', __DIR__ . '/../vendor/autoload.php', __DIR__ . '/vendor/autoload.php') as $autoloadFile) {
    if (file_exists($autoloadFile)) {
        $autoloadFile = realpath($autoloadFile);
        $projectRootDir = dirname(dirname($autoloadFile));
        require $autoloadFile;

        break;
    }
}

if ($projectRootDir === null) {
    throw new RuntimeException('Could not find autoload.php');
}

use LeanpubApi\Console\LeanpubApplication;
use Symfony\Component\Dotenv\Dotenv;

$envFile = $projectRootDir . '/.env';
if (is_file($envFile)) {
    $dotenv = new Dotenv();
    $dotenv->load($envFile);
}

$application = new LeanpubApplication();

$application->run();
