<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\CastMakeCommand;
use Jazz\Laravel\Artisan\TModuleGenerator;

class MakeCast extends CastMakeCommand
{
    use TModuleGenerator;

    /**
     * Returns stub file for generator
     * @return string
     */
    protected function getStub(): string
    {
        return $this->getStubFile('cast.stub');
    }
}
