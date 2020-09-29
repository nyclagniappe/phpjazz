<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Foundation\Console\ListenerMakeCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;
use Jazz\Laravel\Artisan\{
    TModuleOptions,
    TModulePath,
    TModuleRootNamespace,
    TModuleStubFile,
};

class MakeListener extends ListenerMakeCommand
{
    use TModuleOptions;
    use TModulePath;
    use TModuleRootNamespace;
    use TModuleStubFile;

    /**
     * Build the class with the given name
     * @param string $name
     * @return string
     * @throws FileNotFoundException
     */
    protected function buildClass($name): string
    {
        $event = $this->option('event');

        if (!Str::startsWith($event, [$this->rootNamespace(), 'Illuminate', '\\',])) {
            $event = $this->rootNamespace() . 'Events\\' . $event;
        }

        $name = str_replace(
            ['DummyEvent', '{{event}}', '{{ event }}'],
            class_basename($name),
            GeneratorCommand::buildClass($name)
        );
        return str_replace(
            ['DummyFullEvent', '{{fullEvent}}', '{{ fullEvent }}'],
            trim($event, '\\'),
            $name
        );
    }

    /**
     * Returns stub file for generator
     * @return string
     */
    protected function getStub(): string
    {
        $stubFile = 'listener';
        if ($this->option('queued')) {
            $stubFile .= '-queued';
        }
        if ($this->option('event')) {
            $stubFile .= '-duck';
        }
        $stubFile .= '.stub';
        return $this->getStubFile($stubFile);
    }
}
