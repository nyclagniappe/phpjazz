<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;
use PHPUnit\Framework\TestCase;

class MakeTestTest extends ATestCase
{
    protected $myCommand = 'make:test';
    protected $myComponent = 'Tests';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyTest', false, null],
            ['MyTest', false, ['--unit' => null]],

            ['MyTest', true, null],
            ['MyTest', true, ['--unit' => null]],
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
            is_subclass_of($class, TestCase::class, true),
            'Does not extend ' . TestCase::class
        );
    }

    /**
     * Returns PATH
     * @param string $className
     * @param string|null $module
     * @return string
     */
    protected function getMyPath(string $className, ?string $module): string
    {
        $component = str_replace('.', '/', $this->myComponent);

        $ret = self::SANDBOX . '/tests';
        if ($module !== null) {
            $ret = self::APP_PATH . '/' . $this->myModulePath . '/' . $module . '/' . $component;
        }
        $ret .= (array_key_exists('--unit', $this->myArgs)) ? '/Unit' : '/Feature';
        $ret .= '/' . $className . '.php';

        return $ret;
    }

    /**
     * Returns CLASS NAME with NAMESPACE
     * @param string $className
     * @param string|null $module
     * @return string
     */
    protected function getMyClass(string $className, ?string $module): string
    {
        $component = str_replace('.', '\\', $this->myComponent);

        $ret = $this->myDefaultNamespace . '\\';
        if ($module !== null) {
            $ret = $this->myModuleNamespace . '\\' . $module . '\\';
        }
        $ret .= $component . '\\';
        $ret .= (array_key_exists('--unit', $this->myArgs)) ? 'Unit\\' : 'Feature\\';
        $ret .= $className;

        return $ret;
    }
}
