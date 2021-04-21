<?php

declare(strict_types=1);

namespace Jazz\Modules;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class ConsoleProvider extends ServiceProvider implements DeferrableProvider
{
    // List of existing Artisan Commands to override
    protected array $commands = [
    ];

    // List of NEW Commands
    protected array $newCommands = [
    ];


    public function register(): void
    {
        $list = array_merge($this->commands, $this->newCommands);
        foreach (array_keys($list) as $command) {
            $method = 'register' . $command;
            call_user_func([$this, $method]);
        }

        $this->commands(array_values($list));
    }

    public function provides(): array
    {
        return array_values($this->newCommands);
    }


    // Register Methods

}
