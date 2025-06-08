<?php
declare(strict_types=1);

namespace App\Core\Error;

use App\Core\Error\Handler\PhpErrorHandler;
use App\Core\Error\Handler\ExceptionHandler;
use App\Core\Error\Handler\ShutdownHandler;

class ErrorBootstrapper
{
    public function run(): void
    {
        // Turn PHP warnings/notices into exceptions
        set_error_handler([PhpErrorHandler::class,       'handleError'], E_ALL);
        // Catch any uncaught exception
        set_exception_handler([ExceptionHandler::class, 'handleException']);
        // Handle fatal errors on script shutdown
        register_shutdown_function([ShutdownHandler::class, 'handleShutdown']);
    }
}
