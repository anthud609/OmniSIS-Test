<?php
declare(strict_types=1);

namespace App\Core\Error\Handler;

use Throwable;
use App\Core\Logging\Logger;

class ExceptionHandler
{
    public static function handleException(Throwable $e): void
    {
        // Log the exception
        Logger::getLogger()->error(
            $e->getMessage(),
            ['exception' => $e]
        );

        http_response_code(500);
        echo 'An internal error occurred. Please try again later.';
        exit;
    }
}
