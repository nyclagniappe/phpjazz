<?php

declare(strict_types=1);

namespace Jazz\Modules;

use Illuminate\Support\ServiceProvider;
use DirectoryIterator;

class Provider extends ServiceProvider
{
    protected const REGISTER_PATH = 'path';
    protected const REGISTER_ENVIRONMENT = 'environment';


    public function register(): void
    {
        switch (config('modules.register')) {
            case self::REGISTER_PATH:
                $this->registerViaPath();
                break;
            case self::REGISTER_ENVIRONMENT:
                $this->registerViaEnvironment();
                break;
        }
    }

    public function boot(): void
    {
        $config = dirname(__DIR__, 2) . '/configs/modules.php';
        $this->publishes([$config]);
    }


    protected function registerProvider(string $name): void
    {
        $class = config('modules.namespace') . $name . '\\Provider';
        if (class_exists($class)) {
            $this->app->register($class);
        }
    }

    protected function registerViaEnvironment(): void
    {
        $list = config('modules.list');
        if (count($list['always']) > 0) {
            foreach ($list['always'] as $module) {
                $this->registerProvider($module);
            }
        }

        $key = $this->app->environment();
        if (array_key_exists($key, $list) && count($list[$key]) > 0) {
            foreach ($list[$key] as $module) {
                $this->registerProvider($module);
            }
        }
    }

    protected function registerViaPath(): void
    {
        $path = $this->app->basePath(config('modules.path'));
        if (is_dir($path)) {
            $dir = new DirectoryIterator($path);
            foreach ($dir as $file) {
                if ($file->isDot() || !$file->isDir()) {
                    continue;
                }
                $this->registerProvider($file->getFilename());
            }
        }
    }
}
