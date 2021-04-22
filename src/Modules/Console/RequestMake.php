<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Foundation\Console\RequestMakeCommand;

class RequestMake extends RequestMakeCommand
{
    use TGenerator;

    protected function getStub(): string
    {
        return $this->getStubFile('request.stub');
    }
}
