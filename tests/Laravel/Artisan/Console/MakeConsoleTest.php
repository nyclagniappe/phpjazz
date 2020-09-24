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
            ['MyCommand', false, null],
            ['MyCommand', true, null],
        ];
    }

    /**
     * Additional Assertions
     * @param string $class
     * @param array $args
     */
    protected function assertions(string $class, array $args): void
    {
        $this->assertTrue(is_subclass_of($class, Command::class));
        $this->assertIsArray($args);
    }
}
