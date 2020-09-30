<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;
use Illuminate\Support\Facades\Config;
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
            ['MyViewComponent', false, []],
            ['MyViewComponent', false, ['--inline' => null]],

            ['MyViewComponent', true, []],
            ['MyViewComponent', true, ['--inline' => null]],
        ];
    }

    /**
     * Additional Assertions
     * @param string $class
     * @param array $args
     */
    protected function assertions(string $class, array $args): void
    {
        parent::assertions($class, $args);
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
            if ($args['--module']) {
                $path = Config::get('modules.path') . '/' . $this->myModule . '/resources/views';
            }

            $file = $path . '/' . $name;
            $this->assertFileExists($file, 'View File Not Found: ' . $file);
        }
    }
}
