<?php

declare(strict_types=1);

namespace JazzTest\Modules\Console;

use Illuminate\Support\Composer;
use Illuminate\Support\Str;
use Mockery;
use Mockery\MockInterface;

class MigrationMakeTest extends ATestCase
{
    protected string $myCommand = 'make:migration';
    protected string $myComponent = 'Database.Migrations';

    public function setUp(): void
    {
        parent::setUp();

        // Composer MOCK
        $this->instance('composer', Mockery::mock(Composer::class, function ($mock) {
            /* @var MockInterface $mock */
            $mock->expects('dumpAutoloads')->zeroOrMoreTimes();
        }));
    }


    public function provider(): array
    {
        return [
            ['MyMigration', null, []],
            ['MyTable', null, ['--table' => 'my_table']],
            ['MyCreate', null, ['--create' => 'my_create']],

            ['MyMigration', self::MODULE, ['--path' => 'not/applicable']],
            ['MyTable', self::MODULE, ['--table' => 'my_table']],
            ['MyCreate', self::MODULE, ['--create' => 'my_create']],
        ];
    }


    // ASSERTION METHODS
    protected function assertions(string $name, ?string $module): void
    {
        parent::assertions($name, $module);

        $class = $this->getMyClass($name, $module);
        $this->assertMethodInClass($class, 'up', true);
        $this->assertMethodInClass($class, 'down', true);
    }


    // HELPER METHODS
    protected function getMyPath(string $className, ?string $module): string
    {
        $name = Str::snake($className);
        $path = $this->app->basePath() . '/';
        if ($module) {
            $path .= $this->myModulePath . '/' . $module . '/resources/';
        }
        $path .= 'database/migrations/*_' . $name . '.php';

        $files = $this->app['files']->glob($path);
        return array_shift($files);
    }

    protected function getMyClass(string $className, ?string $module): string
    {
        $ret = $className;
        if ($module) {
            $ret = $module . $className;
        }
        return $ret;
    }
}
