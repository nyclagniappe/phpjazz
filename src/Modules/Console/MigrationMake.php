<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Database\Console\Migrations\MigrateMakeCommand;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class MigrationMake extends MigrateMakeCommand
{
    public function __construct(MigrationCreator $creator, Composer $composer)
    {
        $key = Config::get('modules.key');
        $name = Config::get('modules.name');
        $signature = '{--' . $key . '= : ' . sprintf('Install in %s', $name) . '}';
        $this->signature .= $signature;

        parent::__construct($creator, $composer);
    }

    protected function writeMigration($name, $table, $create)
    {
        $module = $this->option(Config::get('modules.key'));
        if ($module) {
            $name = Str::snake($module . '_' . $name);
        }
        parent::writeMigration($name, $table, $create);
    }

    protected function getMigrationPath(): string
    {
        $module = $this->option(Config::get('modules.key'));
        if ($module) {
            $path = Config::get('modules.path') . '/'
                . $module . '/resources/database/migrations';
            $this->input->setOption('path', $path);
            $this->input->setOption('realpath', false);
        }
        return parent::getMigrationPath();
    }
}
