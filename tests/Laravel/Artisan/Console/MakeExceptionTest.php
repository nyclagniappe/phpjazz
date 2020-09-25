<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;
use Exception;

class MakeExceptionTest extends ATestCase
{
    protected $myCommand = 'make:exception';
    protected $myComponent = 'Exceptions';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyException', false, ['--render' => false, '--report' => false]],
            ['MyRenderException', false, ['--render' => true, '--report' => false]],
            ['MyReportException', false, ['--render' => false, '--report' => true]],
            ['MyRenderReportException', false, ['--render' => true, '--report' => true]],

            ['MyException', true, ['--render' => false, '--report' => false]],
            ['MyRenderException', true, ['--render' => true, '--report' => false]],
            ['MyReportException', true, ['--render' => false, '--report' => true]],
            ['MyRenderReportException', true, ['--render' => true, '--report' => true]],
        ];
    }

    /**
     * Additional Assertions
     * @param string $class
     * @param array $args
     */
    protected function assertions(string $class, array $args): void
    {
        $this->assertTrue(is_subclass_of($class, Exception::class));
        $this->assertMethodInClass($class, 'render', $args['--render']);
        $this->assertMethodInClass($class, 'report', $args['--report']);

        $this->assertIsArray($args);
    }
}
