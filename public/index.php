<?php
declare(strict_types=1);

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

// PRODUCTION: hand off to your MVC kernel
$app = new App\Kernel();
$app->handleRequest();

// Trigger an error to test Whoops in DEV:
sdafs();   // undefined function → throws \Error
