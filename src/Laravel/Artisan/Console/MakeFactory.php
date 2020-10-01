<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Database\Console\Factories\FactoryMakeCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Jazz\Laravel\Artisan\{
    TModuleOptions,
    TModuleRootNamespace,
    TModuleStubFile,
    TModuleQualifyModel,
};

class MakeFactory extends FactoryMakeCommand
{
    use TModuleOptions;
    use TModuleRootNamespace;
    use TModuleStubFile;
    use TModuleQualifyModel;

    /**
     * Build the Class with given name
     * @param string $name
     * @return string
     * @throws
     */
    protected function buildClass($name): string
    {
        $module = $this->option(Config::get('modules.key'));

        $namespaceModel = $this->option('model')
            ? $this->qualifyModel($this->option('model'))
            : $this->qualifyModel($this->guessModelName($name));

        $model = class_basename($namespaceModel);

        $rootNamespace = $this->rootNamespace() . '\\Models\\';

        $namespace = 'Database\\Factories\\';
        if ($module) {
            $namespace = $this->rootNamespace() . '\\Database\\Factories\\';
        }
        $namespace .= Str::beforeLast(Str::after($namespaceModel, $rootNamespace), $model);
        $namespace = trim($namespace, '\\');

        $replace = [
            '{{ factoryNamespace }}' => $namespace,
            'NamespacedDummyModel' => $namespaceModel,
            '{{ namespacedModel }}' => $namespaceModel,
            '{{namespacedModel}}' => $namespaceModel,
            'DummyModel' => $model,
            '{{ model }}' => $model,
            '{{model}}' => $model,
        ];

        $stub = $this->files->get($this->getStub());

        $ret = $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
        $ret = str_replace(array_keys($replace), array_values($replace), $ret);

        return $ret;
    }

    /**
     * Parse the class name
     * @param string $name
     * @return string
     */
    protected function qualifyClass($name): string
    {
        return parent::qualifyClass(str_replace(['.', '/'], '\\', $name));
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
