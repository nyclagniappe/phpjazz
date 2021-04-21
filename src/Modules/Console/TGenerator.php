<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

trait TGenerator
{
    protected function getStubFile(string $name): string
    {
        $path = 'stubs/' . $name;

        $localPath = $this->laravel->basePath($path);
        return file_exists($localPath)
            ? $localPath
            : __DIR__ . '/Console/' . $path;
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

    protected function qualifyClass(string $name): string
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

    protected function getPath(string $name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        $module = $this->option(Config::get('modules.key'));

        $path = $this->laravel['path'];
        if ($module) {
            $path = $this->laravel->basePath() . '/' . Config::get('modules.path') . '/' . $module;
        }

        return $path . '/' . str_replace('\\', '/', $name) . '.php';
    }

    protected function viewPath(string $path = ''): string
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
}
