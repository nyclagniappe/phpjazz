<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\EventMakeCommand;
use Jazz\Laravel\Artisan\TModuleGenerator;

class MakeEvent extends EventMakeCommand
{
    use TModuleGenerator;

    /**
     * Returns stub file for generator
     * @return string
     */
    protected function getStub(): string
    {
        return $this->getStubFile('event.stub');
    }
}
