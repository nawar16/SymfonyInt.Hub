<?php

use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;

if (!file_exists(dirname(__DIR__).'/vendor/autoload.php')) {
    throw new RuntimeException('Dependencies not installed. Run composer install');
}

require_once dirname(__DIR__).'/vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/.env')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
    Debug::enable();
}

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$application = new Application($kernel);
$application->run();
