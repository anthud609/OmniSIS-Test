<?php
declare(strict_types=1);

use Dotenv\Dotenv;
use Whoops\Run as WhoopsRun;
use Whoops\Handler\PrettyPageHandler;
use App\Core\Error\ErrorBootstrapper;

// 1) Project root
$root = dirname(__DIR__);

// 2) Load & validate .env early
$dotenv = Dotenv::createImmutable($root);
$dotenv->load();                             // throws if unreadable
$dotenv->required(['APP_ENV', 'DB_DSN'])     // fail-fast if missing
       ->notEmpty();

// 3) Determine the environment
$appEnv = $_ENV['APP_ENV'] ?? 'production';

// 4) In development: register Whoops
if ($appEnv === 'development') {
    $whoops = new WhoopsRun();
    $whoops->pushHandler(new PrettyPageHandler());
    $whoops->register();

    // (Optional) ensure max visibility
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}
// 5) In production: wire up your silent handler
else {
    (new ErrorBootstrapper())->run();
}

// 6) Done—your env is bootstrapped and error handling is in place.
