<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Routing\Console\MiddlewareMakeCommand;

class MiddlewareMake extends MiddlewareMakeCommand
{
    use TGenerator;

    protected function getStub(): string
    {
        return $this->getStubFile('middleware.stub');
    }
}
