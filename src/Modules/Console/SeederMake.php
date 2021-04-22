<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Database\Console\Seeds\SeederMakeCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class SeederMake extends SeederMakeCommand
{
    use TGenerator;

    protected function rootNamespace(): string
    {
        $ret = 'Database\Seeders';

        $module = $this->option(Config::get('modules.key'));
        if ($module) {
            $ret = Config::get('modules.namespace') . $module . '\\' . $ret;
        }

        return $ret;
    }

    protected function getPath($name): string
    {
        $path = $this->laravel->basePath() . '/';

        $module = $this->option(Config::get('modules.key'));
        if ($module) {
            $path .= Config::get('modules.path') . '/' . $module . '/resources/';
        }
        $name = Str::finish($name, 'Seeder');
        $path .= 'database/seeders/' . str_replace('\\', '/', $name) . '.php';

        return $path;
    }

    protected function getStub(): string
    {
        return $this->getStubFile('seeder.stub');
    }

    protected function qualifyClass($name): string
    {
        return $name;
    }
}
