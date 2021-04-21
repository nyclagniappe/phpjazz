<?php

declare(strict_types=1);

namespace JazzTest\Modules\Console;

use Illuminate\Console\Command;

class ConsoleMakeTest extends ATestCase
{
    protected $myCommand = 'make:command';
    protected $myComponent = 'Console.Commands';


    public function provider(): array
    {
        return [
            ['MyCommand', null, null],
            ['MyCommand', self::MODULE, null],
        ];
    }

    protected function assertions(string $name, ?string $module): void
    {
        parent::assertions($name, $module);

        $class = $this->getMyClass($name, $module);
        $this->assertTrue(is_subclass_of($class, Command::class));
    }
}
