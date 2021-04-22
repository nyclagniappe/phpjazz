<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Foundation\Console\ExceptionMakeCommand;

class ExceptionMake extends ExceptionMakeCommand
{
    use TGenerator;

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
