<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Foundation\Console\ObserverMakeCommand;

class ObserverMake extends ObserverMakeCommand
{
    use TGenerator {
        buildClass as myBuildClass;
    }

    protected function buildClass($name): string
    {
        $stub = $this->myBuildClass($name);
        $model = $this->option('model');
        if ($model) {
            $stub = $this->replaceModels($stub, $this->qualifyModel($model));
        }
        return $stub;
    }

    protected function getStub(): string
    {
        $stubFile = 'observer.plain.stub';
        if ($this->option('model')) {
            $stubFile = 'observer.stub';
        }
        return $this->getStubFile($stubFile);
    }
}
