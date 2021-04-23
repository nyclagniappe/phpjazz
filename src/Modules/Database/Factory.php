<?php

declare(strict_types=1);

namespace Jazz\Modules\Database;

use Illuminate\Database\Eloquent\Factories\Factory as LaravelFactory;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

abstract class Factory extends LaravelFactory
{
    public static function resolveFactory(string $model): string
    {
        $ns = Config::get('modules.namespace');
        if (Str::startsWith($model, $ns)) {
            $model = Str::after($model, $ns);
            $component = Str::before($model, '\\');
            $model = str_replace('Models\\', '', Str::after($model, $component . '\\'));

            $path = Config::get('modules.path') . '/'
                . $component . '/'
                . 'resources/database/factories/'
                . str_replace('\\', '/', $model) . 'Factory.php';
            if (file_exists($path)) {
                require_once($path);
            }

            $ret = $ns . $component . '\\Database\\Factories\\' . $model;
        } else {
            $model = Str::startsWith($model, 'App\\Models\\')
                ? Str::after($model, 'App\\Models\\')
                : Str::after($model, 'App\\');
            $ret = static::$namespace . $model;
        }

        return $ret . 'Factory';
    }

    public static function resolveModel(LaravelFactory $factory): string
    {
        $name = Str::replaceLast('Factory', '', get_class($factory));
        $model = Str::after($name, 'Database\\Factories\\');

        $ns = 'App\\';
        if (Str::startsWith($name, Config::get('modules.namespace'))) {
            $ns = Str::before($name, 'Database\\Factories\\');
        }

        return $ns . 'Models\\' . $model;
    }
}
