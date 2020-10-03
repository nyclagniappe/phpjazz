<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\ListenerMakeCommand;
use Jazz\Laravel\Artisan\TModuleGenerator;

class MakeListener extends ListenerMakeCommand
{
    use TModuleGenerator {
        buildClass as myBuildClass;
    }

    /**
     * Build the class with the given name
     * @param string $name
     * @return string
     */
    protected function buildClass($name): string
    {
        $stub = $this->myBuildClass($name);
        return $this->replaceEvent($stub, $this->option('event'));
    }

    /**
     * Returns stub file for generator
     * @return string
     */
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
