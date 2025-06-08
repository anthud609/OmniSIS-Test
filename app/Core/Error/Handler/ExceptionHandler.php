<?php
declare(strict_types=1);

namespace App\Core\Error\Handler;

use Throwable;

class ExceptionHandler
{
    /**
     * Handle uncaught exceptions.
     *
     * @param Throwable $e
     */
    public static function handleException(Throwable $e): void
    {
        // In development, Whoops will have rendered it already.
        // In production, render a generic 500 page or log silently:
        http_response_code(500);

        // For prod: you could log $e->getMessage() here via Monolog or file_put_contents

        echo 'An internal error occurred. Please try again later.';
        // Always end the script:
        exit;
    }
}
