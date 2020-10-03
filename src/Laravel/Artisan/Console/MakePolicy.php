<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\PolicyMakeCommand;
use Jazz\Laravel\Artisan\TModuleGenerator;

class MakePolicy extends PolicyMakeCommand
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
     * Returns stub file for generator
     * @return string
     */
    protected function getStub(): string
    {
        $stubFile = 'policy.plain.stub';
        if ($this->option('model')) {
            $stubFile = 'policy.stub';
        }
        return $this->getStubFile($stubFile);
    }
}
