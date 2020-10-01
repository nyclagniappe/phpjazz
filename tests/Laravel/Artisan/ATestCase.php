<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan;

use JazzTest\Laravel\ATestCase as BaseTestCase;

abstract class ATestCase extends BaseTestCase
{
    protected $myCommand;
    protected $myComponent;

    protected $myDefaultNamespace = 'App';
    protected $myDefaultPath = '';

    protected $myModuleNamespace = 'App\Modules';
    protected $myModulePath = 'Modules';
    protected $myModule = 'Test';

    protected $myArgs = [];


    /**
     * Test RUN
     * @param string|null $name
     * @param bool|null $useModule
     * @param array|null $args
     * @dataProvider provider
     */
    public function testRun(?string $name, ?bool $useModule, ?array $args): void
    {
        if ($name === null || $this->myCommand === null || $this->myComponent === null) {
            $this->markTestIncomplete();
        }

        $module = $useModule ? $this->myModule : null;

        if ($args === null) {
            $args = [];
        }
        $args['name'] = $name;
        $args['--module'] = $module;
        $args['--no-interaction'] = true;

        $this->myArgs = $args;
        $this->callArtisan($this->myCommand, $args);

        $file = $this->getMyPath($name, $module);
        $this->assertFileExists($file, $file);
        require_once($file);

        $class = $this->getMyClass($name, $module);
        $this->assertTrue(class_exists($class), $class);

        $this->assertions($class, $args);
    }

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            [null, null, null],
        ];
    }

    /**
     * Additional Assertions
     * @param string $class
     * @param array $args
     */
    protected function assertions(string $class, array $args): void
    {
        $this->assertIsString($class);
        $this->assertIsArray($args);
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
     * Calls Artisan
     * @param string $command
     * @param array $args
     */
    protected function callArtisan(string $command, array $args = []): void
    {
        $this->artisan($command, $args)
            ->assertExitCode(0);
    }

    /**
     * Returns PATH
     * @param string $className
     * @param string|null $module
     * @param array $args
     * @return string
     */
    protected function getMyPath(string $className, ?string $module): string
    {
        $component = str_replace('.', '/', $this->myComponent);

        $ret = self::APP_PATH . '/';
        if ($module !== null) {
            $ret .= $this->myModulePath . '/' . $module . '/';
        }
        $ret .= $component . '/' . $className . '.php';

        return $ret;
    }

    /**
     * Returns CLASS NAME with NAMESPACE
     * @param string $className
     * @param string|null $module
     * @param array $args
     * @return string
     */
    protected function getMyClass(string $className, ?string $module): string
    {
        $component = str_replace('.', '\\', $this->myComponent);

        $ret = $this->myDefaultNamespace . '\\';
        if ($module !== null) {
            $ret = $this->myModuleNamespace . '\\' . $module . '\\';
        }
        $ret .= $component . '\\' . $className;

        return $ret;
    }
}
