<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class MakeComponentTest extends ATestCase
{
    protected $myCommand = 'make:component';
    protected $myComponent = 'View.Components';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyViewComponent', null, []],
            ['MyViewInlineComponent', null, ['--inline' => null]],

            ['MyViewComponent', self::MODULE, []],
            ['MyViewInlineComponent', self::MODULE, ['--inline' => null]],
        ];
    }

    /**
     * Assertions
     * @param string $name
     * @param ?string $module
     */
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
