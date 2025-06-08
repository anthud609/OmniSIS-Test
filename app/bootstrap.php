<?php
declare(strict_types=1);

use Dotenv\Dotenv;
use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use Monolog\ErrorHandler as MonologErrorHandler;
use Whoops\Run as WhoopsRun;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Handler\Handler as WhoopsHandler;
use App\Core\Logging\Logger as AppLogger;

// 1) Project root & load .env
$root = dirname(__DIR__);
$dotenv = Dotenv::createImmutable($root);
$dotenv->load(); 
$dotenv->required(['APP_ENV','DB_DSN'])->notEmpty();

$appEnv = $_ENV['APP_ENV'] ?? 'production';

// 2) Bootstrap a global Monolog logger via your helper
//    (this also creates logs/app.log if needed)
$logger = AppLogger::getLogger();

// 3) **Always** hook Monolog’s error/exception/fatal handlers
MonologErrorHandler::register($logger);

if ($appEnv === 'development') {
    // … MonologErrorHandler registered already …

    $whoops = new WhoopsRun();

    // Log via Monolog, then *fall through* to PrettyPageHandler
    $whoops->pushHandler(function (\Throwable $e, $inspector, $run) use ($logger) {
        $logger->error($e->getMessage(), ['exception' => $e]);
        // no return ⇒ Whoops will continue to the next handler
    });

    // then the normal pretty page…
    $whoops->pushHandler(new PrettyPageHandler());
    $whoops->register();
}

// 5) From here on, errors/exceptions always both:
//      • get formatted by Whoops in DEV  
//      • and get written to logs/app.log in every env  
