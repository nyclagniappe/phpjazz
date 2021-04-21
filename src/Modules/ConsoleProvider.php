<?php

declare(strict_types=1);

namespace Jazz\Modules;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Jazz\Modules\Console\ConsoleMake;

class ConsoleProvider extends ServiceProvider implements DeferrableProvider
{
    protected array $commands = [
        'ConsoleMake' => 'command.console.make',
    ];


    public function register(): void
    {
        foreach (array_keys($this->commands) as $command) {
            $method = 'register' . $command;
            call_user_func([$this, $method]);
        }
        $this->commands(array_values($this->commands));
    }

    public function provides(): array
    {
        return array_values($this->commands);
    }


    // Register Methods
    protected function registerConsoleMake()
    {
        $this->app->singleton('command.console.make', static function ($app) {
            return new ConsoleMake($app['files']);
        });
    }
}
