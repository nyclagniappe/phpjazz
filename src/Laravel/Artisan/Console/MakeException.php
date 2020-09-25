<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\ExceptionMakeCommand;
use Jazz\Laravel\Artisan\{
    TModuleOptions,
    TModulePath,
    TModuleRootNamespace,
    TModuleStubFile,
};

class MakeException extends ExceptionMakeCommand
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
        $stubFile = 'exception';
        if ($this->option('render')) {
            $stubFile .= '-render';
        }
        if ($this->option('report')) {
            $stubFile .= '-report';
        }
        $stubFile .= '.stub';

        return $this->getStubFile($stubFile);
    }
}
