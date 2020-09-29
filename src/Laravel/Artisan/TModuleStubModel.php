<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

trait TModuleStubModel
{

    /**
     * Replace Model for the given Stub
     * @param string $stub
     * @param string $model
     */
    protected function replaceStubModel(string &$stub, string &$model): void
    {
        $model = str_replace('/', '\\', $model);
        $namespaceModel = $this->laravel->getNamespace() . $model;

        $package = $this->option(Config::get('modules.key'));
        if ($package) {
            $packageNs = Config::get('modules.namespace');
            $namespaceModel = $packageNs . $package . '\\Models\\' . trim($model, '\\');
        }

        if (Str::startsWith($model, '\\')) {
            $stub = str_replace(
                ['NamespacedDummyModel', '{{namespacedModel}}', '{{ namespacedModel }}'],
                trim($model, '\\'),
                $stub
            );
        } else {
            $stub = str_replace(
                ['NamespacedDummyModel', '{{namespacedModel}}', '{{ namespacedModel }}'],
                $namespaceModel,
                $stub
            );
        }

        $stub = str_replace(
            'use ' . $namespaceModel . ";\nuse " . $namespaceModel . ';',
            'use ' . $namespaceModel . ';',
            $stub
        );

        $model = class_basename(trim($model, '\\'));
    }

}
