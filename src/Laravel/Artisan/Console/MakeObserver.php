<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\ObserverMakeCommand;
use Illuminate\Support\Str;
use Jazz\Laravel\Artisan\{
    TModuleOptions,
    TModulePath,
    TModuleRootNamespace,
    TModuleStubFile,
    TModuleStubModel
};

class MakeObserver extends ObserverMakeCommand
{
    use TModuleOptions;
    use TModulePath;
    use TModuleRootNamespace;
    use TModuleStubFile;
    use TModuleStubModel;

    /**
     * Replace the model for the given stub
     * @param string $stub
     * @param string $model
     * @return string
     */
    protected function replaceModel($stub, $model): string
    {
        $this->replaceStubModel($stub, $model);

        $stub = str_replace(['DocDummyModel', '{{docModel}}', '{{ docModel }}'], Str::snake($model, ' '), $stub);
        $stub = str_replace(['DummyModel', '{{model}}', '{{ model }}'], $model, $stub);
        $stub = str_replace(['dummyModel', '{{modelVariable}}', '{{ modelVariable }}'], Str::camel($model), $stub);

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
