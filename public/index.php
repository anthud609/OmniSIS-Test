<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';  // go up from public/ to root

use Dotenv\Dotenv;

// __DIR__ is public/, so dirname(__DIR__) is your project root
$root = dirname(__DIR__);

// Load and return all vars
$dotenv = Dotenv::createImmutable($root);
$loaded = $dotenv->load();

echo "Loaded from .env:\n";
foreach ($loaded as $k => $v) {
    printf("%-20s = %s\n", $k, $v);
}

echo "\n\$_ENV now contains:\n";
print_r($_ENV);
