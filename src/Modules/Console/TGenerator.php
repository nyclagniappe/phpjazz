<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Foundation\Inspiring;

trait TGenerator
{
    use TOptions;

    protected function getStubFile(string $name): string
    {
        $path = 'stubs/' . $name;

        $localPath = $this->laravel->basePath($path);
        return file_exists($localPath)
            ? $localPath
            : __DIR__ . '/' . $path;
    }

    protected function rootNamespace(): string
    {
        $ret = $this->laravel->getNamespace();

        $module = $this->option(Config::get('modules.key'));
        if ($module) {
            $ret = Config::get('modules.namespace') . $module;
        }

        return $ret;
    }

    protected function userProviderModel(): ?string
    {
        $ret = parent::userProviderModel();
        if ($ret === null) {
            $ret = 'App\\Models\\User';
        }
        return $ret;
    }

    protected function qualifyClass($name): string
    {
        return GeneratorCommand::qualifyClass(str_replace('.', '\\', $name));
    }

    protected function qualifyModel(string $model): string
    {
        $model = str_replace(['/', '.'], '\\', ltrim($model, '\\/'));
        $rootNamespace = $this->rootNamespace();

        if (Str::startsWith($model, $rootNamespace)) {
            return $model;
        }

        return $rootNamespace . '\\Models\\' . $model;
    }

    protected function getPath($name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        $module = $this->option(Config::get('modules.key'));

        $path = $this->laravel['path'];
        if ($module) {
            $path = $this->laravel->basePath() . '/' . Config::get('modules.path') . '/' . $module;
        }

        return $path . '/' . str_replace('\\', '/', $name) . '.php';
    }

    protected function viewPath($path = ''): string
    {
        $views = (Config::get('view.paths')[0] ?? resource_path('views'));
        $ret = $views . ($path ? DIRECTORY_SEPARATOR . $path : $path);

        $module = $this->option(Config::get('modules.key'));
        if ($module) {
            $ret = $this->laravel->basePath() . '/' .
                Config::get('modules.path') . '/' .
                $module . '/resources/views/' . $path;
        }

        return $ret;
    }

    protected function buildClass($name): string
    {
        $stub = $this->files->get($this->getStub());

        $this->replaceNamespace($stub, $name);
        $stub = $this->replaceClass($stub, $name);
        $stub = $this->replaceUser($stub, $this->userProviderModel());

        return $stub;
    }

    protected function replaceNamespace(&$stub, $name): GeneratorCommand
    {
        return GeneratorCommand::replaceNamespace($stub, $name);
    }

    protected function replaceClass($stub, $name): string
    {
        return GeneratorCommand::replaceClass($stub, $name);
    }

    protected function replaceUser(string $stub, string $user): string
    {
        $search = ['DummyUser', '{{user}}', '{{ user }}'];
        return str_replace($search, class_basename($user), $stub);
    }

    protected function replaceView(string $stub, string $view, ?bool $inline = false): string
    {
        if ($inline) {
            $view = "<<<'blade'\n<div>\n    <!-- " . Inspiring::quote() . " -->\n</div>\nblade";
        }

        $search = ['DummyView', '{{view}}', '{{ view }}'];
        return str_replace($search, $view, $stub);
    }

    protected function replaceCommand(string $stub, string $command): string
    {
        $search = ['dummy:command', 'DummyCommand', '{{command}}', '{{ command }}'];
        return str_replace($search, $command, $stub);
    }

    protected function replaceParentModels(string $stub, string $parentModelClass): string
    {
        $searches = [
            ['ParentDummyFullModelClass', 'ParentDummyModelClass', 'ParentDummyModelVariable'],
            ['{{namespacedParentModel}}', '{{parentModel}}', '{{parentModelVariable}}'],
            ['{{ namespacedParentModel }}', '{{ parentModel }}', '{{ parentModelVariable }}'],
        ];
        $replace = [$parentModelClass, class_basename($parentModelClass), lcfirst(class_basename($parentModelClass))];

        foreach ($searches as $search) {
            $stub = str_replace($search, $replace, $stub);
        }
        return $stub;
    }

    protected function replaceModels(string $stub, string $modelClass): string
    {
        $searches = [
            ['DummyFullModelClass', 'DummyModelClass', 'DummyModelVariable', 'DocDummyModel', 'DocDummyPluralModel'],
            ['{{namespacedModel}}', '{{model}}', '{{modelVariable}}', '{{docModel}}', '{{docPluralModel}}'],
            ['{{ namespacedModel }}', '{{ model }}', '{{ modelVariable }}', '{{ docModel }}', '{{ docPluralModel }}'],
        ];
        $model = class_basename($modelClass);
        $replace = [
            $modelClass,
            $model,
            lcfirst($model),
            Str::snake($model, ' '),
            Str::snake(Str::pluralStudly($model), ' ')
        ];

        foreach ($searches as $search) {
            $stub = str_replace($search, $replace, $stub);
        }
        return $stub;
    }

    protected function replaceFactoryNamespace(string $stub, string $model): string
    {
        $namespace = 'Database\\Factories\\';
        $module = $this->option(Config::get('modules.key'));
        if ($module) {
            $namespace = $this->rootNamespace() . '\\Database\\Factories\\';
        }

        $namespace .= Str::beforeLast(Str::after($model, '\\Models\\'), class_basename($model));
        $namespace = trim($namespace, '\\');

        $search = ['DummyFactoryNamespace', '{{factoryNamespace}}', '{{ factoryNamespace }}'];
        return str_replace($search, $namespace, $stub);
    }

    protected function replaceEvent(string $stub, ?string $event): string
    {
        if (!Str::startsWith($event, [$this->rootNamespace(), 'Illuminate', '\\',])) {
            $event = $this->rootNamespace() . '\\Events\\' . $event;
        }

        $stub = str_replace(['DummyEvent', '{{event}}', '{{ event }}'], class_basename($event), $stub);
        return str_replace(['DummyFullEvent', '{{fullEvent}}', '{{ fullEvent }}'], trim($event, '\\'), $stub);
    }
}
