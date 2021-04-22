<?php

declare(strict_types=1);

namespace JazzTest\Modules\Console;

use Exception;

class ExceptionMakeTest extends ATestCase
{
    protected string $myCommand = 'make:exception';
    protected string $myComponent = 'Exceptions';

    public function provider(): array
    {
        return [
            ['MyException', null, []],
            ['MyRenderException', null, ['--render' => true]],
            ['MyReportException', null, ['--report' => true]],
            ['MyRenderReportException', null, ['--render' => true, '--report' => true]],

            ['MyException', self::MODULE, []],
            ['MyRenderException', self::MODULE, ['--render' => true]],
            ['MyReportException', self::MODULE, ['--report' => true]],
            ['MyRenderReportException', self::MODULE, ['--render' => true, '--report' => true]],
        ];
    }

    protected function assertions(string $name, ?string $module): void
    {
        parent::assertions($name, $module);

        $args = $this->myArgs;
        $class = $this->getMyClass($name, $module);
        $this->assertTrue(is_subclass_of($class, Exception::class));
        $this->assertMethodInClass($class, 'render', isset($args['--render']));
        $this->assertMethodInClass($class, 'report', isset($args['--report']));
    }
}
