<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Routing\Console\MiddlewareMakeCommand;
use Jazz\Laravel\Artisan\TModuleGenerator;

class MakeMiddleware extends MiddlewareMakeCommand
{
    use TModuleGenerator;

    /**
     * Returns stub file for generator
     * @return string
     */
    protected function getStub(): string
    {
        return $this->getStubFile('middleware.stub');
    }
}
