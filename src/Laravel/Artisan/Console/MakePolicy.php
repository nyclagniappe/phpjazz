<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\PolicyMakeCommand;
use Illuminate\Support\Str;
use Jazz\Laravel\Artisan\{
    TModuleOptions,
    TModulePath,
    TModuleRootNamespace,
    TModuleStubFile,
    TModuleStubModel,
};

class MakePolicy extends PolicyMakeCommand
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

        $dummyUser = class_basename($this->userProviderModel());
        $dummyModel = Str::camel($model) === 'user' ? 'model' : $model;

        return str_replace(
            ['DocDummyModel', 'DummyModel', 'dummyModel', 'DummyUser', 'DocDummyPluralModel'],
            [
                Str::snake($dummyModel, ' '),
                $model,
                Str::camel($dummyModel),
                $dummyUser,
                Str::snake(Str::pluralStudly($dummyModel), ' ')
            ],
            $stub
        );
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
