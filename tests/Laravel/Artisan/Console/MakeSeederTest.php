<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MakeSeederTest extends ATestCase
{
    protected $myCommand = 'make:seeder';
    protected $myComponent = 'Database.Seeders';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MySeeder', null, null],
            ['MySeeder', self::MODULE, null],
        ];
    }

    /**
     * Assertions
     * @param string $name
     * @param ?string $module
     */
    protected function assertions(string $name, ?string $module): void
    {
        parent::assertions($name, $module);

        $class = $this->getMyClass($name, $module);
        $this->assertTrue(
            is_subclass_of($class, Seeder::class, true),
            'Does not extend ' . Seeder::class
        );
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
        $className = str_replace(['.', '\\'], '/', Str::finish($className, 'Seeder'));

        $path = $this->app->basePath() . '/';
        if ($module) {
            $path .= $this->myModulePath . '/' . self::MODULE . '/resources/';
        }
        $path .= 'database/seeders/' . $className . '.php';

        return $path;
    }

    /**
     * Returns CLASS NAME with NAMESPACE
     * @param string $className
     * @param string|null $module
     * @return string
     */
    protected function getMyClass(string $className, ?string $module): string
    {
        $className = str_replace(['.', '/'], '\\', $className);
        $className = parent::getMyClass($className, $module);
        $className = Str::replaceFirst('App\\Database', 'Database', $className);
        return Str::finish($className, 'Seeder');
    }
}
