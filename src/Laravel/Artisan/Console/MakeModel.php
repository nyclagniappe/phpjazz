<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\ModelMakeCommand;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Command\Command;
use Jazz\Laravel\Artisan\TModuleGenerator;

class MakeModel extends ModelMakeCommand
{
    use TModuleGenerator;

    /**
     * Call another console command
     * @param Command|string $command
     * @param array $arguments
     * @return int
     */
    public function call($command, array $arguments = []): int
    {
        $key = Config::get('modules.key');
        $module = $this->option($key);
        if ($module) {
            $arguments['--' . $key] = $module;
        }
        return parent::call($command, $arguments);
    }

    /**
     * Returns the stub file for generator
     * @return string
     */
    protected function getStub(): string
    {
        $stub = 'model.stub';
        if ($this->option('pivot')) {
            $stub = 'model.pivot.stub';
        }
        return $this->getStubFile($stub);
    }

    /**
     * Get the default namespace for the class
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\\Models';
    }
}
