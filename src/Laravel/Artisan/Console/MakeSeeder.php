<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Database\Console\Seeds\SeederMakeCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Jazz\Laravel\Artisan\{
    TModuleOptions,
    TModuleStubFile,
};

class MakeSeeder extends SeederMakeCommand
{
    use TModuleOptions;
    use TModuleStubFile;

    /**
     * Get the root namespace for the class
     * @return string
     */
    protected function rootNamespace(): string
    {
        $ret = 'Database\Seeders';

        $module = $this->option(Config::get('modules.key'));
        if ($module) {
            $ret = Config::get('modules.namespace') . $module . '\\' . $ret;
        }

        return $ret;
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
            $path .= Config::get('modules.path') . '/' . $module . '/resources/';
        }
        $name = Str::finish($name, 'Seeder');
        $path .= 'database/seeders/' . str_replace('\\', '/', $name) . '.php';

        return $path;
    }

    /**
     * Returns stub file for generator
     * @return string
     */
    protected function getStub(): string
    {
        return $this->getStubFile('seeder.stub');
    }
}
