<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Foundation\Console\CastMakeCommand;

class CastMake extends CastMakeCommand
{
    use TGenerator;

    /**
     * Returns stub file for generator
     * @return string
     */
    protected function getStub(): string
    {
        return $this->getStubFile('cast.stub');
    }
}
