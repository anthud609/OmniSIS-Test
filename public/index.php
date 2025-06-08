<?php
declare(strict_types=1);

//
// 1) Composer autoload + bootstrap all core services
//
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/bootstrap.php';

//
// 2) (Optional) ENV dump in DEV only
//
if (($_ENV['APP_ENV'] ?? '') === 'development') {
    header('Content-Type: text/plain');
    echo "— Loaded .env variables —\n";
    foreach ($_ENV as $key => $val) {
        printf("%-20s = %s\n", $key, $val);
    }
    exit;
}

//
// 3) Dispatch to your MVC kernel (controllers, routers, etc.)
//
$app = new App\Kernel();
$app->handleRequest();
