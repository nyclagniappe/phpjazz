<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\ObserverMakeCommand;
use Jazz\Laravel\Artisan\TModuleGenerator;

class MakeObserver extends ObserverMakeCommand
{
    use TModuleGenerator {
        buildClass as myBuildClass;
    }

    /**
     * Build the class with given name
     * @param string $name
     * @return string
     */
    protected function buildClass($name): string
    {
        $stub = $this->myBuildClass($name);
        $model = $this->option('model');
        if ($model) {
            $stub = $this->replaceModels($stub, $this->qualifyModel($model));
        }
        return $stub;
    }

    /**
     * Get the stub file for the generator
     * @return string
     */
    protected function getStub(): string
    {
        $stubFile = 'observer.plain.stub';
        if ($this->option('model')) {
            $stubFile = 'observer.stub';
        }
        return $this->getStubFile($stubFile);
    }
}
