<?php

declare(strict_types=1);

namespace Jazz\Laravel;

use Illuminate\Foundation\Providers\ArtisanServiceProvider;
use Jazz\Laravel\Artisan\Console\{
    MakeChannel,
    MakeConsole,
    MakeEvent,
};

class ArtisanProvider extends ArtisanServiceProvider
{

    /**
     * Register the Service Provider
     */
    public function register(): void
    {
        parent::register();

        // add NEW Commands not currently registered
    }


    // REGISTER METHODS
    /**
     * Register the CHANNEL command
     */
    protected function registerChannelMakeCommand(): void
    {
        $this->app->singleton('command.channel.make', static function ($app) {
            return new MakeChannel($app['files']);
        });
    }

    /**
     * Register CONSOLE command
     */
    protected function registerConsoleMakeCommand(): void
    {
        $this->app->singleton('command.console.make', static function ($app) {
            return new MakeConsole($app['files']);
        });
    }

    /**
     * Register EVENT command
     */
    protected function registerEventMakeCommand(): void
    {
        $this->app->singleton('command.event.make', static function ($app) {
            return new MakeEvent($app['files']);
        });
    }
}
