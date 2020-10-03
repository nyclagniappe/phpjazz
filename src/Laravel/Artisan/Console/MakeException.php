<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\ExceptionMakeCommand;
use Jazz\Laravel\Artisan\TModuleGenerator;

class MakeException extends ExceptionMakeCommand
{
    use TModuleGenerator;

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
