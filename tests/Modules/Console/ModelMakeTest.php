<?php

declare(strict_types=1);

namespace JazzTest\Modules\Console;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;
use Illuminate\Testing\PendingCommand;

class ModelMakeTest extends ATestCase
{
    protected string $myCommand = 'make:model';
    protected string $myComponent = 'Models';

    public function provider(): array
    {
        return [
            ['MyModel', null, []],
            ['MyPivotModel', null, ['--pivot' => null]],
            //['MyFactoryModel', null, ['--factory' => null]],
            //['MyMigrationModel', null, ['--migration' => null]],
            //['MySeedModel', null, ['--seed' => null]],
            ['MyControllerModel', null, ['--controller' => null]],
            ['MyResourceModel', null, ['--resource' => null]],
            ['MyApiModel', null, ['--api' => null]],
            //['MyAllModel', null, ['--all' => null]],

            ['MyModel', self::MODULE, []],
            ['MyPivotModel', self::MODULE, ['--pivot' => null]],
            //['MyFactoryModel', self::MODULE, ['--factory' => null]],
            //['MyMigrationModel', self::MODULE, ['--migration' => null]],
            //['MySeedModel', self::MODULE, ['--seed' => null]],
            ['MyControllerModel', self::MODULE, ['--controller' => null]],
            ['MyResourceModel', self::MODULE, ['--resource' => null]],
            ['MyApiModel', self::MODULE, ['--api' => null]],
            //['MyAllModel', self::MODULE, ['--all' => null]],
        ];
    }

    protected function createArtisan(string $command, array $args = []): PendingCommand
    {
        $question = 'Model does not exist. Do you want to generate it?';

        $artisan = parent::createArtisan($command, $args);
        if (
            array_key_exists('--resource', $args) ||
            array_key_exists('--api', $args) ||
            array_key_exists('--all', $args)
        ) {
            $artisan->expectsConfirmation($question, 'no');
        }
        return $artisan;
    }


    protected function assertions(string $name, ?string $module): void
    {
        $args = $this->myArgs;
        parent::assertions($name, $module);

        $class = $this->getMyClass($name, $module);
        $subclass = Model::class;
        if (isset($args['--pivot'])) {
            $subclass = Pivot::class;
        }
        $this->assertTrue(is_subclass_of($class, $subclass, true), 'Does not extend ' . $subclass);

        if (isset($args['--all'])) {
            $args['--factory'] = true;
            $args['--seed'] = true;
            $args['--migration'] = true;
            $args['--controller'] = true;
            $args['--resource'] = true;
        }

        $this->assertionsFactory($class, $args);
        $this->assertionsMigration($args);
        $this->assertionsSeeders($class, $args);
        $this->assertionsController($class, $args);
    }

    protected function assertionsFactory(string $class, array $args): void
    {
        if (isset($args['--factory'])) {
            $path = self::SANDBOX;
            if ($args[$this->myModuleKey]) {
                $path = $this->myModulePath;
            }
            $path .= '/database/factories/' . Str::after($class, 'Models\\') . 'Factory.php';
            $this->assertFileExists($path, 'FACTORY not found');
        }
    }

    protected function assertionsMigration(array $args): void
    {
        if (isset($args['--migration'])) {
            $path = $this->app->basePath();
            if ($args[$this->myModuleKey]) {
                $path = $this->myModulePath . '/' . $args[$this->myModuleKey];
            }
            $path .= '/database/migrations/*_table.php';
            $files = $this->app['files']->glob($path);
            $this->assertCount(1, $files, 'MIGRATION not found');
        }
    }

    protected function assertionsSeeders(string $class, array $args): void
    {
        if (isset($args['--seed'])) {
            $path = self::SANDBOX;
            if ($args[$this->myModuleKey]) {
                $path = $this->myModulePath;
            }
            $path .= '/database/seeders/' . Str::after($class, 'Models\\') . 'Seeder.php';
            $this->assertFileExists($path, 'SEEDER not found');
        }
    }

    protected function assertionsController(string $class, array $args): void
    {
        if (isset($args['--controller']) || isset($args['--resource']) || isset($args['--api'])) {
            $path = self::APP_PATH;
            if ($args[$this->myModuleKey]) {
                $path = $this->myModulePath;
            }
            $path .= '/Http/Controllers/' . Str::after($class, 'Models\\') . 'Controller.php';
            $this->assertFileExists($path, 'CONTROLLER not found');
        }
    }
}
