<?php

declare(strict_types=1);

namespace Jazz\Laravel;

use Illuminate\Foundation\Providers\ArtisanServiceProvider;
use Jazz\Laravel\Artisan\Console\{
    MakeCast,
    MakeChannel,
    MakeConsole,
    MakeEvent,
    MakeException,
    MakeJob,
    MakeListener,
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
     * Register the CAST command
     */
    protected function registerCastMakeCommand(): void
    {
        $this->app->singleton('command.cast.make', function ($app) {
            return new MakeCast($app['files']);
        });
    }

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

    /**
     * Register the EXCEPTION command
     */
    protected function registerExceptionMakeCommand(): void
    {
        $this->app->singleton('command.exception.make', static function ($app) {
            return new MakeException($app['files']);
        });
    }

    /**
     * Register the JOB command
     */
    protected function registerJobMakeCommand(): void
    {
        $this->app->singleton('command.job.make', static function ($app) {
            return new MakeJob($app['files']);
        });
    }

    /**
     * Register the LISTENER command
     */
    protected function registerListenerMakeCommand(): void
    {
        $this->app->singleton('command.listener.make', static function ($app) {
            return new MakeListener($app['files']);
        });
    }
}
