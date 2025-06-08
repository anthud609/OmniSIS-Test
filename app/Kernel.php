<?php
declare(strict_types=1);

namespace App;

class Kernel
{
    /**
     * Simple front‐controller stub.
     * Replace with your router/controller dispatch logic.
     */
    public function handleRequest(): void
    {
        // Example placeholder:
        header('Content-Type: text/plain');
        echo '🟢 Kernel up – implement your routing & controllers here.';
    }
}
