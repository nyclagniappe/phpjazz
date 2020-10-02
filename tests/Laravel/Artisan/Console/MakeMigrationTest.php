<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use Illuminate\Support\Composer;
use JazzTest\Laravel\Artisan\ATestCase;
use Mockery;
use Mockery\MockInterface;

class MakeMigrationTest extends ATestCase
{
    protected $myCommand = 'make:migration';
    protected $myComponent = 'Database.Migrations';

    /**
     * Set Up
     */
    public function setUp(): void
    {
        parent::setUp();

        // Composer MOCK
        $this->instance('composer', Mockery::mock(Composer::class, function ($mock) {
            /* @var MockInterface $mock */
            $mock->expects('dumpAutoloads')->zeroOrMoreTimes();
        }));
    }


    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyMigration', null, []],
            ['MyMigration', self::MODULE, ['--path' => 'not/applicable']],
        ];
    }


    // ASSERTION METHODS
    /**
     * Assertions
     * @param string $name
     * @param ?string $module
     */
    protected function assertions(string $name, ?string $module): void
    {
        parent::assertions($name, $module);

        $class = $this->getMyClass($name, $module);
        $this->assertMethodInClass($class, 'up', true);
        $this->assertMethodInClass($class, 'down', true);
    }


    // HELPER METHODS
    /**
     * Returns PATH
     * @param string $className
     * @param string|null $module
     * @return string
     */
    protected function getMyPath(string $className, ?string $module): string
    {
        $className = null;
        $path = $this->app->basePath() . '/';
        if ($module) {
            $path .= $this->myModulePath . '/' . $module . '/resources/';
        }
        $path .= 'database/migrations/*_my_migration.php';

        $files = $this->app['files']->glob($path);
        return array_shift($files);
    }

    /**
     * Returns NAMESPACE
     * @param string $className
     * @param string|null $module
     * @return string
     */
    protected function getMyClass(string $className, ?string $module): string
    {
        $ret = $className;
        if ($module) {
            $ret = $module . $className;
        }
        return $ret;
    }
}
