<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan;

use Illuminate\Support\Facades\Config;

trait TModuleRootNamespace
{
    /**
     * Get the root namespace for the class
     * @return string
     */
    protected function rootNamespace(): string
    {
        $ret = $this->laravel->getNamespace();

        $module = $this->option(Config::get('modules.key'));
        if ($module) {
            $ret = Config::get('modules.namespace') . $module;
        }

        return $ret;
    }
}
