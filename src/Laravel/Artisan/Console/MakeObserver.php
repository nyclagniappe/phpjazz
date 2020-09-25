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

        return str_replace(
            ['DocDummyModel', 'DummyModel', 'dummyModel'],
            [Str::snake($model, ' '), $model, Str::camel($model)],
            $stub
        );
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
