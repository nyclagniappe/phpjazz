<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Foundation\Console\ModelMakeCommand;
use Illuminate\Support\Facades\Config;

class ModelMake extends ModelMakeCommand
{
    use TGenerator;

    public function call($command, array $arguments = []): int
    {
        $key = Config::get('modules.key');
        $module = $this->option($key);
        if ($module) {
            $arguments['--' . $key] = $module;
        }
        return parent::call($command, $arguments);
    }

    protected function getStub(): string
    {
        $stub = 'model.stub';
        if ($this->option('pivot')) {
            $stub = 'model.pivot.stub';
        }
        return $this->getStubFile($stub);
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\\Models';
    }
}
