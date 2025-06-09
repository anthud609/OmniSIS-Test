<?php
declare(strict_types=1);
use App\Core\Logging\Logger;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/bootstrap.php';

// DEV-only: dump env, but don’t stop execution
if (($_ENV['APP_ENV'] ?? '') === 'development') {
    header('Content-Type: text/plain');
    echo "— ENV DUMP —\n";
    foreach ($_ENV as $k => $v) {
        printf("%-20s = %s\n", $k, $v);
    }
    // <– removed exit();
}
// grab your singleton
$logger = Logger::getLogger();

// PSR-3 / Monolog levels
$logger->debug    ('[DEBUG]    This is a DEBUG message');
$logger->info     ('[INFO]     This is an INFO message');
$logger->notice   ('[NOTICE]   This is a NOTICE message');
$logger->warning  ('[WARNING]  This is a WARNING message');
$logger->error    ('[ERROR]    This is an ERROR message');
$logger->critical ('[CRITICAL] This is a CRITICAL message');
$logger->alert    ('[ALERT]    This is an ALERT message');
$logger->emergency('[EMERGENCY]This is an EMERGENCY message');
// PRODUCTION: hand off to your MVC kernel
$app = new App\Kernel();
$app->handleRequest();

// Trigger an error to test Whoops in DEV:
sdafs();   // undefined function → throws \Error
