<?php
declare(strict_types=1);

use Dotenv\Dotenv;
use Whoops\Run as WhoopsRun;
use Whoops\Handler\PrettyPageHandler;
use App\Core\Error\ErrorBootstrapper;

// 1) Project root
$root = dirname(__DIR__);

// 2) In dev, register Whoops *before* loading .env
$whoops = null;
if (is_file($root . '/vendor/filp/whoops')) {
    $whoops = new WhoopsRun();
    $whoops->pushHandler(new PrettyPageHandler());
    $whoops->register();
}

// 3) Load & validate environment
$dotenv = Dotenv::createImmutable($root);
$dotenv->load();                            // throws if .env missing or unreadable
$dotenv->required(['APP_ENV', 'DB_DSN'])    // ensure keys exist
       ->notEmpty();                        // ensure they’re not empty

// 4) Determine current environment
$appEnv = $_ENV['APP_ENV'] ?? 'production';

// 5) In production, unregister Whoops and run your silent handler
if ($appEnv !== 'development') {
    if ($whoops instanceof WhoopsRun) {
        $whoops->unregister();
    }
    (new ErrorBootstrapper())->run();
}

// From here on, your environment is bootstrapped, secrets are locked down,
// and error handling is wired based on APP_ENV.
