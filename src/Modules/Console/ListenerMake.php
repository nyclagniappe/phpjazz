<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Foundation\Console\ListenerMakeCommand;

class ListenerMake extends ListenerMakeCommand
{
    use TGenerator {
        buildClass as myBuildClass;
    }

    protected function buildClass($name): string
    {
        $stub = $this->myBuildClass($name);
        return $this->replaceEvent($stub, $this->option('event'));
    }

    protected function getStub(): string
    {
        $stubFile = 'listener';
        if ($this->option('queued')) {
            $stubFile .= '-queued';
        }
        if ($this->option('event')) {
            $stubFile .= '-duck';
        }
        $stubFile .= '.stub';
        return $this->getStubFile($stubFile);
    }
}
