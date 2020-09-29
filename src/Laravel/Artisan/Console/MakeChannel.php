<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\ChannelMakeCommand;
use Illuminate\Console\GeneratorCommand;
use Jazz\Laravel\Artisan\{
    TModuleOptions,
    TModulePath,
    TModuleRootNamespace,
    TModuleStubFile,
};

class MakeChannel extends ChannelMakeCommand
{
    use TModuleOptions;
    use TModulePath;
    use TModuleRootNamespace;
    use TModuleStubFile;

    /**
     * Returns stub file for generator
     * @return string
     */
    protected function getStub(): string
    {
        return $this->getStubFile('channel.stub');
    }

    /**
     * Build the class with given name
     * @param string $name
     * @return string
     */
    protected function buildClass($name): string
    {
        return str_replace(
            ['DummyUser', '{{user}}', '{{ user }}'],
            class_basename($this->userProviderModel()),
            GeneratorCommand::buildClass($name)
        );
    }
}
