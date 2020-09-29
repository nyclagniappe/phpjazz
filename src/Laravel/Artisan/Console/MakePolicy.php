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

        $stub = str_replace(['DocDummyModel', '{{docModel}}', '{{ docModel }}'], Str::snake($dummyModel, ' '), $stub);
        $stub = str_replace(['DummyModel', '{{model}}', '{{ model }}'], $model, $stub);
        $stub = str_replace(['dummyModel', '{{modelVariable}}', '{{ modelVariable }}'], Str::camel($dummyModel), $stub);
        $stub = str_replace(['DummyUser', '{{user}}', '{{ user }}'], $dummyUser, $stub);
        $stub = str_replace(
            ['DocDummyPluralModel', '{{docPluralModel}}', '{{ docPluralModel }}'],
            Str::snake(Str::pluralStudly($dummyModel), ' '),
            $stub
        );

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
