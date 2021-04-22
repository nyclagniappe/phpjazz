<?php

declare(strict_types=1);

namespace JazzTest\Modules\Console;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class ComponentMakeTest extends ATestCase
{
    protected string $myCommand = 'make:component';
    protected string $myComponent = 'View.Components';

    public function provider(): array
    {
        return [
            ['MyViewComponent', null, []],
            ['MyViewInlineComponent', null, ['--inline' => null]],

            ['MyViewComponent', self::MODULE, []],
            ['MyViewInlineComponent', self::MODULE, ['--inline' => null]],
        ];
    }

    protected function assertions(string $name, ?string $module): void
    {
        $args = $this->myArgs;

        parent::assertions($name, $module);

        $class = $this->getMyClass($name, $module);
        $this->assertTrue(
            is_subclass_of($class, Component::class, true),
            'Does not extend ' . Component::class
        );

        // verify View Component File
        if (!array_key_exists('--inline', $args)) {
            $name = str_replace('\\', '/', $args['name']);
            $name = collect(explode('/', $name))
                ->map(function ($part) {
                    return Str::kebab($part);
                })
                ->implode('.');
            $name = str_replace('.', '/', 'components.' . $name) . '.blade.php';

            $path = self::SANDBOX . '/resources/views';
            if (isset($args[$this->myModuleKey])) {
                $path = self::SANDBOX . '/' . $this->myModulePath . '/' . self::MODULE . '/resources/views';
            }

            $file = $path . '/' . $name;
            $this->assertFileExists($file, 'View File Not Found: ' . $file);
        }
    }
}
