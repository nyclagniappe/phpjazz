<?php

declare(strict_types=1);

namespace Jazz\Modules;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Jazz\Modules\Console\ConsoleMake;
use Jazz\Modules\Console\CastMake;
use Jazz\Modules\Console\ChannelMake;
use Jazz\Modules\Console\ComponentMake;
use Jazz\Modules\Console\ControllerMake;
use Jazz\Modules\Console\EventMake;
use Jazz\Modules\Console\ExceptionMake;
use Jazz\Modules\Console\JobMake;
use Jazz\Modules\Console\ListenerMake;
use Jazz\Modules\Console\MailMake;
use Jazz\Modules\Console\MiddlewareMake;
use Jazz\Modules\Console\ModelMake;
use Jazz\Modules\Console\NotificationMake;
use Jazz\Modules\Console\ObserverMake;
use Jazz\Modules\Console\PolicyMake;
use Jazz\Modules\Console\ProviderMake;
use Jazz\Modules\Console\RequestMake;
use Jazz\Modules\Console\ResourceMake;
use Jazz\Modules\Console\RuleMake;
use Jazz\Modules\Console\TestMake;
use Jazz\Modules\Database\Migration;
use Jazz\Modules\Console\MigrationMake;

class ConsoleProvider extends ServiceProvider implements DeferrableProvider
{
    protected array $commands = [
        'ConsoleMake' => 'command.console.make',
        'CastMake' => 'command.cast.make',
        'ChannelMake' => 'command.channel.make',
        'ComponentMake' => 'command.component.make',
        'ControllerMake' => 'command.controller.make',
        'EventMake' => 'command.event.make',
        'ExceptionMake' => 'command.exception.make',
        'JobMake' => 'command.job.make',
        'ListenerMake' => 'command.listener.make',
        'MailMake' => 'command.mail.make',
        'MiddlewareMake' => 'command.middleware.make',
        'ModelMake' => 'command.model.make',
        'NotificationMake' => 'command.notification.make',
        'ObserverMake' => 'command.observer.make',
        'PolicyMake' => 'command.policy.make',
        'ProviderMake' => 'command.provider.make',
        'RequestMake' => 'command.request.make',
        'ResourceMake' => 'command.resource.make',
        'RuleMake' => 'command.rule.make',
        'TestMake' => 'command.test.make',

        'MigrationMake' => 'command.migrate.make',
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

    protected function registerCastMake(): void
    {
        $this->app->singleton('command.cast.make', function ($app) {
            return new CastMake($app['files']);
        });
    }

    protected function registerChannelMake(): void
    {
        $this->app->singleton('command.channel.make', static function ($app) {
            return new ChannelMake($app['files']);
        });
    }

    protected function registerComponentMake(): void
    {
        $this->app->singleton('command.component.make', static function ($app) {
            return new ComponentMake($app['files']);
        });
    }

    protected function registerControllerMake(): void
    {
        $this->app->singleton('command.controller.make', static function ($app) {
            return new ControllerMake($app['files']);
        });
    }

    protected function registerEventMake(): void
    {
        $this->app->singleton('command.event.make', static function ($app) {
            return new EventMake($app['files']);
        });
    }

    protected function registerExceptionMake(): void
    {
        $this->app->singleton('command.exception.make', static function ($app) {
            return new ExceptionMake($app['files']);
        });
    }

    protected function registerJobMake(): void
    {
        $this->app->singleton('command.job.make', static function ($app) {
            return new JobMake($app['files']);
        });
    }

    protected function registerListenerMake(): void
    {
        $this->app->singleton('command.listener.make', static function ($app) {
            return new ListenerMake($app['files']);
        });
    }

    protected function registerMailMake(): void
    {
        $this->app->singleton('command.mail.make', static function ($app) {
            return new MailMake($app['files']);
        });
    }

    protected function registerMiddlewareMake(): void
    {
        $this->app->singleton('command.middleware.make', static function ($app) {
            return new MiddlewareMake($app['files']);
        });
    }

    protected function registerModelMake(): void
    {
        $this->app->singleton('command.model.make', static function ($app) {
            return new ModelMake($app['files']);
        });
    }

    protected function registerNotificationMake(): void
    {
        $this->app->singleton('command.notification.make', static function ($app) {
            return new NotificationMake($app['files']);
        });
    }

    protected function registerObserverMake(): void
    {
        $this->app->singleton('command.observer.make', static function ($app) {
            return new ObserverMake($app['files']);
        });
    }

    protected function registerPolicyMake(): void
    {
        $this->app->singleton('command.policy.make', static function ($app) {
            return new PolicyMake($app['files']);
        });
    }

    protected function registerProviderMake(): void
    {
        $this->app->singleton('command.provider.make', static function ($app) {
            return new ProviderMake($app['files']);
        });
    }

    protected function registerRequestMake(): void
    {
        $this->app->singleton('command.request.make', static function ($app) {
            return new RequestMake($app['files']);
        });
    }

    protected function registerResourceMake(): void
    {
        $this->app->singleton('command.resource.make', static function ($app) {
            return new ResourceMake($app['files']);
        });
    }

    protected function registerRuleMake(): void
    {
        $this->app->singleton('command.rule.make', static function ($app) {
            return new RuleMake($app['files']);
        });
    }

    protected function registerTestMake(): void
    {
        $this->app->singleton('command.test.make', static function ($app) {
            return new TestMake($app['files']);
        });
    }


    protected function registerMigrationMake(): void
    {
        $this->app->singleton('migration.creator', function ($app) {
            return new Migration($app['files'], $app->basePath('stubs'));
        });

        $this->app->singleton('command.migrate.make', function ($app) {
            $creator = $app['migration.creator'];
            $composer = $app['composer'];
            return new MigrationMake($creator, $composer);
        });
    }
}
