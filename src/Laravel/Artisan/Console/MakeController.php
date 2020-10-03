<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Routing\Console\ControllerMakeCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Jazz\Laravel\Artisan\TModuleGenerator;

class MakeController extends ControllerMakeCommand
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

        if ($this->option('parent')) {
            $parent = $this->qualifyModel($this->option('parent'));
            $stub = $this->replaceParentModels($stub, $this->confirmModel($parent));
        }
        if ($this->option('model')) {
            $model = $this->qualifyModel($this->option('model'));
            $stub = $this->replaceModels($stub, $this->confirmModel($model));
        }

        $controllerNamespace = $this->getNamespace($name);
        $stub = str_replace('use ' . $controllerNamespace . "\Controller;\n", '', $stub);

        return $stub;
    }

    /**
     * Confirms Model Creation
     * @param string $model
     * @return string
     */
    protected function confirmModel(string $model): string
    {
        if (!class_exists($model)) {
            $question = class_basename($model) . ' Model does not exist. Do you want to generate it?';
            if ($this->confirm($question)) {
                $modelName = str_replace('\\', '/', Str::after($model, 'Models\\'));
                $moduleKey = Config::get('modules.key');

                $args = [
                    'name' => $modelName,
                    '--' . $moduleKey => $this->option($moduleKey),
                ];
                $this->call('make:model', $args);
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
