<?php
declare(strict_types=1);

namespace App\Core\Error\Handler;

use ErrorException;

class PhpErrorHandler
{
    /**
     * Convert PHP errors into ErrorException.
     *
     * @param int    $severity
     * @param string $message
     * @param string $file
     * @param int    $line
     *
     * @throws ErrorException
     */
    public static function handleError(int $severity, string $message, string $file, int $line): void
    {
        // Respect error_reporting level
        if (!(error_reporting() & $severity)) {
            return;
        }
        throw new ErrorException($message, 0, $severity, $file, $line);
    }
}
