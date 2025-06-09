<?php
declare(strict_types=1);

namespace App\Core\Logging;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FilterHandler;           // ← add this
use Monolog\Processor\UidProcessor;
use Psr\Log\LoggerInterface;

class Logger
{
    private static ?LoggerInterface $instance = null;

    public static function getLogger(): LoggerInterface
    {
        if (self::$instance === null) {
            $env     = $_ENV['APP_ENV'] ?? 'production';
            $root    = dirname(__DIR__, 3);
            $logsDir = $root . '/storage/logs';

            if (!is_dir($logsDir)) {
                mkdir($logsDir, 0755, true);
            }

            $monolog = new MonologLogger($env);
            $monolog->pushProcessor(new UidProcessor());

            // always‐on error channel
            $monolog->pushHandler(
                new StreamHandler("$logsDir/error.log", MonologLogger::ERROR)
            );

            // application channel; DEBUG in dev, INFO in prod
            $appLevel = $env === 'development'
                ? MonologLogger::DEBUG
                : MonologLogger::INFO;

            $monolog->pushHandler(
                new StreamHandler("$logsDir/app.log", $appLevel)
            );

            // **DEBUG channel**: only DEBUG entries, in dev
            if ($env === 'development') {
                $stream = new StreamHandler("$logsDir/debug.log", MonologLogger::DEBUG);
                $monolog->pushHandler(
                    new FilterHandler(
                        $stream,
                        [MonologLogger::DEBUG],     // only DEBUG
                        MonologLogger::DEBUG        // max-level DEBUG
                    )
                );
            }

            self::$instance = $monolog;
        }

        return self::$instance;
    }

    public static function setLogger(LoggerInterface $logger): void
    {
        self::$instance = $logger;
    }
}
