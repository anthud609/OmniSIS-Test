<?php
declare(strict_types=1);

namespace App\Core\Logging;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;

class Logger
{
    private static ?LoggerInterface $instance = null;

    public static function getLogger(): LoggerInterface
    {
        if (self::$instance === null) {
            $name   = $_ENV['APP_ENV'] ?? 'app';
            $root   = dirname(__DIR__, 3);                    // project root
            $path   = $root . '/logs/app.log';
            // ensure log directory exists
            if (!is_dir(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }
            $monolog = new MonologLogger($name);
            $monolog->pushHandler(new StreamHandler($path, MonologLogger::DEBUG));
            self::$instance = $monolog;
        }
        return self::$instance;
    }

    /** Optional: override the global logger */
    public static function setLogger(LoggerInterface $logger): void
    {
        self::$instance = $logger;
    }
}
