<?php

declare(strict_types=1);

namespace JazzTest\Modules\Console;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SeederMakeTest extends ATestCase
{
    protected string $myCommand = 'make:seeder';
    protected string $myComponent = 'Database.Seeders';

    public function provider(): array
    {
        return [
            ['MySeeder', null, null],
            ['MySeeder', self::MODULE, null],
        ];
    }

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

    protected function getMyClass(string $className, ?string $module): string
    {
        $className = str_replace(['.', '/'], '\\', $className);
        $className = parent::getMyClass($className, $module);
        $className = Str::replaceFirst('App\\Database', 'Database', $className);
        return Str::finish($className, 'Seeder');
    }
}
