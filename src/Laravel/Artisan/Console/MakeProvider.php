<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\ProviderMakeCommand;
use Jazz\Laravel\Artisan\TModuleGenerator;

class MakeProvider extends ProviderMakeCommand
{
    use TModuleGenerator;

    /**
     * Returns stub file for generator
     * @return string
     */
    protected function getStub(): string
    {
        return $this->getStubFile('provider.stub');
    }
}
