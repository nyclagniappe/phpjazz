<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Foundation\Console\PolicyMakeCommand;

class PolicyMake extends PolicyMakeCommand
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
        $stubFile = 'policy.plain.stub';
        if ($this->option('model')) {
            $stubFile = 'policy.stub';
        }
        return $this->getStubFile($stubFile);
    }
}
