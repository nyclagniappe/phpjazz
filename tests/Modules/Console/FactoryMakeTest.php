<?php

declare(strict_types=1);

namespace JazzTest\Modules\Console;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class FactoryMakeTest extends ATestCase
{
    protected string $myCommand = 'make:factory';
    protected string $myComponent = 'Database.Factories';

    public function provider(): array
    {
        return [
            ['MyUser', null, []],
            ['My.User', null, []],

            ['MyUser', self::MODULE, []],
            ['My.User', self::MODULE, []],
        ];
    }

    protected function assertions(string $name, ?string $module): void
    {
        parent::assertions($name, $module);

        $class = $this->getMyClass($name, $module);
        $this->assertTrue(
            is_subclass_of($class, Factory::class, true),
            'Does not extend ' . Factory::class
        );
    }


    // HELPER METHODS
    protected function getMyPath(string $className, ?string $module): string
    {
        $className = str_replace(['.', '\\'], '/', Str::finish($className, 'Factory'));

        $path = $this->app->basePath() . '/';
        if ($module) {
            $path .= $this->myModulePath . '/' . self::MODULE . '/resources/';
        }
        $path .= 'database/factories/' . $className . '.php';

        return $path;
    }

    protected function getMyClass(string $className, ?string $module): string
    {
        $className = str_replace(['.', '/'], '\\', $className);
        $className = parent::getMyClass($className, $module);
        $className = Str::replaceFirst('App\\Database', 'Database', $className);
        return Str::finish($className, 'Factory');
    }
}
