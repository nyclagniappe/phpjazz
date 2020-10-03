<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Database\Console\Factories\FactoryMakeCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Jazz\Laravel\Artisan\TModuleGenerator;

class MakeFactory extends FactoryMakeCommand
{
    use TModuleGenerator {
        buildClass as myBuildClass;
    }

    /**
     * Build the Class with given name
     * @param string $name
     * @return string
     * @throws
     */
    protected function buildClass($name): string
    {
        $stub = $this->myBuildClass($name);

        $namespaceModel = $this->option('model')
            ? $this->qualifyModel($this->option('model'))
            : $this->qualifyModel($this->guessModelName($name));

        $stub = $this->replaceModels($stub, $namespaceModel);
        return $this->replaceFactoryNamespace($stub, $namespaceModel);
    }

    /**
     * Guess the model name from Factory name or return default model
     * @param string $name
     * @return string
     */
    protected function guessModelName($name): string
    {
        if (Str::endsWith($name, 'Factory')) {
            $name = substr($name, 0, -7);
        }

        $modelName = $this->qualifyModel($name);
        if (class_exists($modelName)) {
            return $modelName;
        }

        $name = trim(Str::replaceFirst($this->rootNamespace(), '', $name), '\\');
        return $this->rootNamespace() . '\\Models\\' . $name;
    }

    /**
     * Get the destination class path
     * @param string $name
     * @return string
     */
    protected function getPath($name): string
    {
        $path = $this->laravel->basePath() . '/';

        $module = $this->option(Config::get('modules.key'));
        if ($module) {
            $moduleNamespace = Config::get('modules.namespace') . $module . '\\';
            $name = Str::replaceFirst($moduleNamespace, '', $name);
            $path .= Config::get('modules.path') . '/' . $module . '/resources/';
        } else {
            $name = Str::replaceFirst('App\\', '', $name);
        }
        $name = Str::finish($name, 'Factory');
        $path .= 'database/factories/' . str_replace('\\', '/', $name) . '.php';

        return $path;
    }

    /**
     * Returns stub file for generator
     * @return string
     */
    protected function getStub(): string
    {
        return $this->getStubFile('factory.stub');
    }
}
