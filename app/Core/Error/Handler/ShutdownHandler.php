<?php
declare(strict_types=1);

namespace App\Core\Error\Handler;

use App\Core\Logging\Logger;

class ShutdownHandler
{
    public static function handleShutdown(): void
    {
        $error = error_get_last();
        if ($error !== null && in_array($error['type'], [
            E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR
        ], true)) {
            Logger::getLogger()->critical(
                $error['message'],
                $error
            );
            http_response_code(500);
            echo 'A fatal error occurred. Please try again later.';
        }
    }
}
