<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Routing\Console\ControllerMakeCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Jazz\Laravel\Artisan\{
    TModuleOptions,
    TModulePath,
    TModuleRootNamespace,
    TModuleStubFile,
};

class MakeController extends ControllerMakeCommand
{
    use TModuleOptions;
    use TModulePath;
    use TModuleRootNamespace;
    use TModuleStubFile;

    /**
     * Build the replacements for a parent controller
     * @return array
     */
    protected function buildParentReplacements(): array
    {
        $parentModelClass = $this->parseModel($this->option('parent'));

        /* @todo implement when Model Command is completed
        if (! class_exists($parentModelClass)) {
            $msg = 'A ' . $parentModelClass . ' model does not exist. Do you want to generate it?';
            if ($this->confirm($msg, false)) {
                $packageKey = PackageConfig::key();
                $this->call('make:model', [
                    'name' => class_basename($parentModelClass),
                    '--' . $packageKey => $this->option($packageKey),
                ]);
            }
        }*/

        return [
            'ParentDummyFullModelClass' => $parentModelClass,
            'ParentDummyModelClass' => class_basename($parentModelClass),
            'ParentDummyModelVariable' => lcfirst(class_basename($parentModelClass)),
        ];
    }

    /**
     * Build the model replacement values
     * @param array $replace
     * @return array
     */
    protected function buildModelReplacements(array $replace): array
    {
        $modelClass = $this->parseModel($this->option('model'));

        /* @todo implement when Model Command completed
        if (! class_exists($modelClass)) {
            $msg = 'A ' . $modelClass . ' model does not exist. Do you want to generate it?';
            if ($this->confirm($msg, false)) {
                $packageKey = PackageConfig::key();
                $this->call('make:model', [
                    'name' => class_basename($modelClass),
                    '--' . $packageKey => $this->option($packageKey),
                ]);
            }
        }*/

        return array_merge($replace, [
            'DummyFullModelClass' => $modelClass,
            'DummyModelClass' => class_basename($modelClass),
            'DummyModelVariable' => lcfirst(class_basename($modelClass)),
        ]);
    }

    /**
     * Get the fully-qualified model class name
     * @param string $model
     * @return string
     * @throws InvalidArgumentException
     */
    protected function parseModel($model): string
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        $model = trim(str_replace('/', '\\', $model), '\\');

        $rootNamespace = $this->rootNamespace();
        if (! Str::startsWith($model, $rootNamespace)) {
            $model = $rootNamespace . $model;
            if ($this->option(Config::get('modules.key'))) {
                $model = $rootNamespace . '\Models\\' . class_basename($model);
            }
        }

        return $model;
    }



    /**
     * Get the stub file for the generator
     * @return string
     */
    protected function getStub(): string
    {
        $stub = $this->getStubNonApi();
        if ($this->option('api')) {
            if ($stub !== null && !$this->option('invokable')) {
                $stub = str_replace('.stub', '.api.stub', $stub);
            }
            if ($stub === null) {
                $stub = '/stubs/controller.api.stub';
            }
        }
        $stub = ($stub ?? '/stubs/controller.plain.stub');

        return __DIR__ . $stub;
    }

    /**
     * Returns the STUB file for Non-API
     * @return string
     */
    private function getStubNonApi(): ?string
    {
        $stub = null;

        if ($this->option('parent')) {
            $stub = '/stubs/controller.nested.stub';
        } elseif ($this->option('model')) {
            $stub = '/stubs/controller.model.stub';
        } elseif ($this->option('invokable')) {
            $stub = '/stubs/controller.invokable.stub';
        } elseif ($this->option('resource')) {
            $stub = '/stubs/controller.stub';
        }

        return $stub;
    }
}
