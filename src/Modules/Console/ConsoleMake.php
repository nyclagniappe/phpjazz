<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Foundation\Console\ConsoleMakeCommand;

class ConsoleMake extends ConsoleMakeCommand
{
    use TGenerator {
        buildClass as myBuildClass;
    }

    protected function getStub(): string
    {
        return $this->getStubFile('console.stub');
    }

    protected function buildClass($name): string
    {
        $stub = $this->myBuildClass($name);
        return $this->replaceCommand($stub, $this->option('command'));
    }
}
