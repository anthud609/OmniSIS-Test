<?php
declare(strict_types=1);

namespace App\Core\Error\Handler;

class ShutdownHandler
{
    /**
     * Handle fatal errors on shutdown.
     */
    public static function handleShutdown(): void
    {
        $error = error_get_last();
        if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
            http_response_code(500);
            // You can log $error here. For prod, show generic message:
            echo 'A fatal error occurred. Please try again later.';
        }
    }
}
