<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\RuleMakeCommand;
use Jazz\Laravel\Artisan\TModuleGenerator;

class MakeRule extends RuleMakeCommand
{
    use TModuleGenerator;

    /**
     * Returns stub file for generator
     * @return string
     */
    protected function getStub(): string
    {
        return $this->getStubFile('rule.stub');
    }
}
