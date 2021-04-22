<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Database\Console\Seeds\SeedCommand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class Seed extends SeedCommand
{
    use TOptions;

    protected function getSeeder(): Seeder
    {
        $class = $this->option('class');
        $module = $this->option(Config::get('modules.key'));

        $path = $this->laravel->basePath() . '/';
        if ($module) {
            $path .= Config::get('modules.path') . '/' . $module . '/resources/';
        }
        $path .= 'database/seeders/' . str_replace('\\', '/', $class) . '.php';
        $this->laravel['files']->requireOnce($path);

        if ($module) {
            $class = Config::get('modules.namespace') . $module . '\\Database\\Seeders\\' . $class;
        }

        if (strpos($class, '\\') === false) {
            $class = 'Database\\Seeders\\' . $class;
        }
        if ($class === 'Database\\Seeders\\DatabaseSeeder' && !class_exists($class)) {
            $class = 'DatabaseSeeder';
        }

        return $this->laravel->make($class)
                        ->setContainer($this->laravel)
                        ->setCommand($this);
    }
}
