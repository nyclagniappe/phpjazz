<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan;

use Illuminate\Support\Str;

trait TModuleQualifyModel
{
    /**
     * Qualify the given model class base name
     * @param string $model
     * @return string
     */
    protected function qualifyModel(string $model): string
    {
        $model = str_replace(['/', '.'], '\\', ltrim($model, '\\/'));
        $rootNamespace = $this->rootNamespace();

        if (Str::startsWith($model, $rootNamespace)) {
            return $model;
        }

        return $rootNamespace . '\\Models\\' . $model;
    }
}
