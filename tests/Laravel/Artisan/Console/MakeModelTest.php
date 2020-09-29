<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class MakeModelTest extends ATestCase
{
    protected $myCommand = 'make:model';
    protected $myComponent = 'Models';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyModel', false, []],
            ['MyPivotModel', false, ['--pivot' => null]],
            ['MyModel', false, ['--factory' => null]],
            ['MyModel', false, ['--migration' => null]],
            ['MyModel', false, ['--seed' => null]],
            ['MyModel', false, ['--controller' => null]],
            ['MyModel', false, ['--resource' => null]],
            ['MyModel', false, ['--api' => null]],
            ['MyModel', false, ['--all' => null]],

            ['MyModel', true, []],
            ['MyPivotModel', true, ['--pivot' => null]],
            ['MyModel', true, ['--factory' => null]],
            ['MyModel', true, ['--migration' => null]],
            ['MyModel', true, ['--seed' => null]],
            ['MyModel', true, ['--controller' => null]],
            ['MyModel', true, ['--resource' => null]],
            ['MyModel', true, ['--api' => null]],
            ['MyModel', true, ['--all' => null]],
        ];
    }

    /**
     * Additional Assertions
     * @param string $class
     * @param array $args
     */
    protected function assertions(string $class, array $args): void
    {
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

    /**
     * Assertion for FACTORY
     * @param string $class
     * @param array $args
     */
    protected function assertionsFactory(string $class, array $args): void
    {
        if (isset($args['--factory'])) {
            $path = self::SANDBOX;
            if ($args['--module']) {
                $path = Config::get('modules.path');
            }
            $path .= '/database/factories/' . Str::after($class, 'Models\\') . 'Factory.php';
            $this->assertFileExists($path, 'FACTORY not found');
        }
    }

    /**
     * Assertion for MIGRATION
     * @param array $args
     */
    protected function assertionsMigration(array $args): void
    {
        if (isset($args['--migration'])) {
            $path = $this->app->basePath();
            if ($args['--module']) {
                $path = Config::get('modules.path') . '/' . $args['--module'];
            }
            $path .= '/database/migrations/*_table.php';
            $files = $this->app['files']->glob($path);
            $this->assertCount(1, $files, 'MIGRATION not found');
        }
    }

    /**
     * Assertion for SEEDERS
     * @param string $class
     * @param array $args
     */
    protected function assertionsSeeders(string $class, array $args): void
    {
        if (isset($args['--seed'])) {
            $path = self::SANDBOX;
            if ($args['--module']) {
                $path = Config::get('modules.path');
            }
            $path .= '/database/seeders/' . Str::after($class, 'Models\\') . 'Seeder.php';
            $this->assertFileExists($path, 'SEEDER not found');
        }
    }

    /**
     * Assertion for CONTROLLERS
     * @param string $class
     * @param array $args
     */
    protected function assertionsController(string $class, array $args): void
    {
        if (isset($args['--controller']) || isset($args['--resource']) || isset($args['--api'])) {
            $path = self::APP_PATH;
            if ($args['--module']) {
                $path = Config::get('modules.path');
            }
            $path .= '/Http/Controllers/' . Str::after($class, 'Models\\') . 'Controller.php';
            $this->assertFileExists($path, 'CONTROLLER not found');
        }
    }
}
