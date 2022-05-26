<?php

namespace App\Commands;

use Framework\Contracts\CommandInterface;

class ExampleCommand implements CommandInterface
{
    public function handle($message = ''): void
    {
        echo "Example! {$message}\n";
    }
}
