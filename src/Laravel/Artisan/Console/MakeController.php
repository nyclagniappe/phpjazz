<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Routing\Console\ControllerMakeCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Jazz\Laravel\Artisan\{
    TModuleOptions,
    TModulePath,
    TModuleRootNamespace,
    TModuleStubFile,
    TModuleQualifyModel,
};

class MakeController extends ControllerMakeCommand
{
    use TModuleOptions;
    use TModulePath;
    use TModuleRootNamespace;
    use TModuleStubFile;
    use TModuleQualifyModel;

    /**
     * Build the replacements for a parent controller
     * @return array
     */
    protected function buildParentReplacements(): array
    {
        $parentModelClass = $this->confirmModel($this->option('parent'));

        return [
            'ParentDummyFullModelClass' => $parentModelClass,
            '{{ namespacedParentModel }}' => $parentModelClass,
            '{{namespacedParentModel}}' => $parentModelClass,
            'ParentDummyModelClass' => class_basename($parentModelClass),
            '{{ parentModel }}' => class_basename($parentModelClass),
            '{{parentModel}}' => class_basename($parentModelClass),
            'ParentDummyModelVariable' => lcfirst(class_basename($parentModelClass)),
            '{{ parentModelVariable }}' => lcfirst(class_basename($parentModelClass)),
            '{{parentModelVariable}}' => lcfirst(class_basename($parentModelClass)),
        ];
    }

    /**
     * Build the model replacement values
     * @param array $replace
     * @return array
     */
    protected function buildModelReplacements(array $replace): array
    {
        $modelClass = $this->confirmModel($this->option('model'));

        return array_merge($replace, [
            'DummyFullModelClass' => $modelClass,
            '{{ namespacedModel }}' => $modelClass,
            '{{namespacedModel}}' => $modelClass,
            'DummyModelClass' => class_basename($modelClass),
            '{{ model }}' => class_basename($modelClass),
            '{{model}}' => class_basename($modelClass),
            'DummyModelVariable' => lcfirst(class_basename($modelClass)),
            '{{ modelVariable }}' => lcfirst(class_basename($modelClass)),
            '{{modelVariable}}' => lcfirst(class_basename($modelClass)),
        ]);
    }



    /**
     * Confirms Model Creation
     * @param string $model
     * @return string
     */
    protected function confirmModel(string $model): string
    {
        $modelClass = $this->parseModel($model);

        if (!class_exists($modelClass)) {
            $question = class_basename($model) . ' Model does not exist. Do you want to generate it?';
            if ($this->confirm($question)) {
                $modelName = str_replace('\\', '/', Str::after($modelClass, 'Models\\'));
                $moduleKey = Config::get('modules.key');

                $args = [
                    'name' => $modelName,
                    '--' . $moduleKey => $this->option($moduleKey),
                ];
                $this->call('make:model', $args);
            }
        }

        return $modelClass;
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
