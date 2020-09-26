<?php

declare(strict_types=1);

namespace Jazz\Laravel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\Providers\ArtisanServiceProvider;
use Illuminate\Database\MigrationServiceProvider;
use Jazz\Laravel\Artisan\Console\{
    MakeCast,
    MakeChannel,
    MakeConsole,
    MakeController,
    MakeEvent,
    MakeException,
    MakeFactory,
    MakeJob,
    MakeListener,
    MakeMail,
    MakeMiddleware,
    MakeMigration,
    MakeNotification,
    MakeObserver,
    MakePolicy,
    MakeRequest,
    MakeResource,
    MakeRule,
};
use Jazz\Laravel\Artisan\MigrationCreator;

class ArtisanProvider extends ServiceProvider implements DeferrableProvider
{
    protected $commands = [
        'MakeCast' => MakeCast::class,
        'MakeChannel' => MakeChannel::class,
        'MakeConsole' => MakeConsole::class,
        'MakeController' => MakeController::class,
        'MakeEvent' => MakeEvent::class,
        'MakeException' => MakeException::class,
        'MakeFactory' => MakeFactory::class,
        'MakeJob' => MakeJob::class,
        'MakeListener' => MakeListener::class,
        'MakeMail' => MakeMail::class,
        'MakeMiddleware' => MakeMiddleware::class,
        'MakeMigration' => MakeMigration::class,
        'MakeNotification' => MakeNotification::class,
        'MakeObserver' => MakeObserver::class,
        'MakePolicy' => MakePolicy::class,
        'MakeRequest' => MakeRequest::class,
        'MakeResource' => MakeResource::class,
        'MakeRule' => MakeRule::class,
    ];


    /**
     * Returns services of the Provider
     * @return array
     */
    public function provides(): array
    {
        $this->app->resolveProvider(ArtisanServiceProvider::class);
        $this->app->resolveProvider(MigrationServiceProvider::class);

        return array_keys($this->commands);
    }


    // REGISTER METHODS
    /**
     * Register the Service Provider
     */
    public function register(): void
    {
        foreach ($this->commands as $method => $class) {
            $call = 'register' . $method . 'Command';
            $this->{$call}();
        }
    }

    /**
     * Register the CAST command
     */
    protected function registerMakeCastCommand(): void
    {
        $this->app->singleton('command.cast.make', function ($app) {
            return new MakeCast($app['files']);
        });
    }

    /**
     * Register the CHANNEL command
     */
    protected function registerMakeChannelCommand(): void
    {
        $this->app->singleton('command.channel.make', static function ($app) {
            return new MakeChannel($app['files']);
        });
    }

    /**
     * Register CONSOLE command
     */
    protected function registerMakeConsoleCommand(): void
    {
        $this->app->singleton('command.console.make', static function ($app) {
            return new MakeConsole($app['files']);
        });
    }

    /**
     * Register the CONTROLLER command
     */
    protected function registerMakeControllerCommand(): void
    {
        $this->app->singleton('command.controller.make', static function ($app) {
            return new MakeController($app['files']);
        });
    }

    /**
     * Register EVENT command
     */
    protected function registerMakeEventCommand(): void
    {
        $this->app->singleton('command.event.make', static function ($app) {
            return new MakeEvent($app['files']);
        });
    }

    /**
     * Register the EXCEPTION command
     */
    protected function registerMakeExceptionCommand(): void
    {
        $this->app->singleton('command.exception.make', static function ($app) {
            return new MakeException($app['files']);
        });
    }

    /**
     * Register the FACTORY command
     */
    protected function registerMakeFactoryCommand(): void
    {
        $this->app->singleton('command.factory.make', static function ($app) {
            return new MakeFactory($app['files']);
        });
    }

    /**
     * Register the JOB command
     */
    protected function registerMakeJobCommand(): void
    {
        $this->app->singleton('command.job.make', static function ($app) {
            return new MakeJob($app['files']);
        });
    }

    /**
     * Register the LISTENER command
     */
    protected function registerMakeListenerCommand(): void
    {
        $this->app->singleton('command.listener.make', static function ($app) {
            return new MakeListener($app['files']);
        });
    }

    /**
     * Register the MAIL command
     */
    protected function registerMakeMailCommand(): void
    {
        $this->app->singleton('command.mail.make', static function ($app) {
            return new MakeMail($app['files']);
        });
    }

    /**
     * Register the MIDDLEWARE command
     */
    protected function registerMakeMiddlewareCommand(): void
    {
        $this->app->singleton('command.middleware.make', static function ($app) {
            return new MakeMiddleware($app['files']);
        });
    }

    /**
     * Register the MIGRATION command
     */
    protected function registerMakeMigrationCommand(): void
    {
        $this->app->singleton('migration.creator', function ($app) {
            return new MigrationCreator($app['files'], $app->basePath('stubs'));
        });

        $this->app->singleton('command.migrate.make', function ($app) {
            $creator = $app['migration.creator'];
            $composer = $app['composer'];
            return new MakeMigration($creator, $composer);
        });
    }

    /**
     * Register the NOTIFICATIONS command
     */
    protected function registerMakeNotificationCommand(): void
    {
        $this->app->singleton('command.notification.make', static function ($app) {
            return new MakeNotification($app['files']);
        });
    }

    /**
     * Register the OBSERVER command
     */
    protected function registerMakeObserverCommand(): void
    {
        $this->app->singleton('command.observer.make', static function ($app) {
            return new MakeObserver($app['files']);
        });
    }

    /**
     * Register the POLICY command
     */
    protected function registerMakePolicyCommand(): void
    {
        $this->app->singleton('command.policy.make', static function ($app) {
            return new MakePolicy($app['files']);
        });
    }

    /**
     * Register the command
     */
    protected function registerMakeRequestCommand(): void
    {
        $this->app->singleton('command.request.make', static function ($app) {
            return new MakeRequest($app['files']);
        });
    }

    /**
     * Register the RESOURCE command
     */
    protected function registerMakeResourceCommand(): void
    {
        $this->app->singleton('command.resource.make', static function ($app) {
            return new MakeResource($app['files']);
        });
    }

    /**
     * Register the RULE command
     */
    protected function registerMakeRuleCommand(): void
    {
        $this->app->singleton('command.rule.make', static function ($app) {
            return new MakeRule($app['files']);
        });
    }
}
