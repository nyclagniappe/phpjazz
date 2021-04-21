<?php

declare(strict_types=1);

namespace JazzTest\Modules\Console;

use JazzTest\Modules\ATestCase as BaseTestCase;
use Illuminate\Support\Facades\Config;

abstract class ATestCase extends BaseTestCase
{
    protected const MODULE = 'Sandbox';

    protected $myCommand;
    protected $myComponent;

    protected $myModuleKey = '--module';
    protected $myModuleNamespace = 'App\\Modules\\';
    protected $myModulePath = 'app/Modules';
    protected $myModuleName = 'Module';
    protected $myModules = ['Sandbox'];

    protected $myArgs = [];


    /**
     * Set Up
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->myModuleKey = '--' . Config::get('modules.key');
        $this->myModuleNamespace = Config::get('modules.namespace');
        $this->myModulePath = Config::get('modules.path');
        $this->myModuleName = Config::get('modules.name');
        $this->myModules = Config::get('modules.list');
    }


    /**
     * Test RUN
     * @param string $name
     * @param ?string $module
     * @param ?array $args
     * @dataProvider provider
     */
    public function testRun(string $name, ?string $module, ?array $args): void
    {
        if ($name === null || $this->myCommand === null || $this->myComponent === null) {
            $this->markTestIncomplete();
        }

        $args = ($args ?? []);
        $args['name'] = $name;
        $args['--no-interaction'] = true;
        if ($module) {
            $args[$this->myModuleKey] = $module;
        }

        $this->myArgs = $args;
        $this->createArtisan($this->myCommand, $args);
        $this->assertions($name, $module);
    }

    /**
     * Data Provider
     * @return array
     */
    abstract public function provider(): array;


    // ASSERTIONS
    /**
     * Assertions
     * @param string $name
     * @param ?string $module
     */
    protected function assertions(string $name, ?string $module): void
    {
        $this->assertMyFileExists($name, $module);
        $this->assertMyClassExists($name, $module);
    }

    /**
     * Assert File Exists
     * @param string $name
     * @param ?string $module
     */
    protected function assertMyFileExists(string $name, ?string $module): void
    {
        $file = $this->getMyPath($name, $module);
        $this->assertFileExists($file, $file . ' not found');
        require_once($file);
    }

    /**
     * Assert Class Exists
     * @param string $name
     * @param ?string $module
     */
    protected function assertMyClassExists(string $name, ?string $module): void
    {
        $class = $this->getMyClass($name, $module);
        $this->assertTrue(class_exists($class, false), $class . ' not found');
    }

    /**
     * Verify if METHOD is defined by CLASS
     * @param string $class
     * @param string $method
     * @param bool $expected
     */
    protected function assertMethodInClass(string $class, string $method, bool $expected): void
    {
        $exists = method_exists($class, $method);
        $this->assertTrue(($expected ? $exists : !$exists), $class . '::' . $method);
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
        $component = str_replace('.', '/', $this->myComponent);

        $ret = self::APP_PATH . '/';
        if ($module !== null) {
            $ret = self::SANDBOX . '/' . $this->myModulePath . '/' . $module . '/';
        }
        $ret .= $component . '/' . $className . '.php';

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

        $ret = self::APP_NAMESPACE;
        if ($module !== null) {
            $ret = $this->myModuleNamespace . $module . '\\';
        }
        $ret .= $component . '\\' . $className;

        return $ret;
    }
}
