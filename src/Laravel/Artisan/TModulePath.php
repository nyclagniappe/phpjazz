<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

trait TModulePath
{
    /**
     * Get the destination class path
     * @param string $name
     * @return string
     */
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
}
