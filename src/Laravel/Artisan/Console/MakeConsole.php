<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\ConsoleMakeCommand;
use Jazz\Laravel\Artisan\{
    TModuleOptions,
    TModulePath,
    TModuleRootNamespace,
    TModuleStubFile,
};

class MakeConsole extends ConsoleMakeCommand
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
        return $this->getStubFile('console.stub');
    }
}
