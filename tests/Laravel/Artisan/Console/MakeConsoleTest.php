<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;
use Illuminate\Console\Command;

class MakeConsoleTest extends ATestCase
{
    protected $myCommand = 'make:command';
    protected $myComponent = 'Console.Commands';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyCommand', null, null],
            ['MyCommand', self::MODULE, null],
        ];
    }

    /**
     * Assertions
     * @param string $name
     * @param ?string $module
     */
    protected function assertions(string $name, ?string $module): void
    {
        parent::assertions($name, $module);

        $class = $this->getMyClass($name, $module);
        $this->assertTrue(is_subclass_of($class, Command::class));
    }
}
