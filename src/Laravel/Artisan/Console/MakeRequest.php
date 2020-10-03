<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\RequestMakeCommand;
use Jazz\Laravel\Artisan\TModuleGenerator;

class MakeRequest extends RequestMakeCommand
{
    use TModuleGenerator;

    /**
     * Returns stub file for generator
     * @return string
     */
    protected function getStub(): string
    {
        return $this->getStubFile('request.stub');
    }
}
