<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Foundation\Console\EventMakeCommand;

class EventMake extends EventMakeCommand
{
    use TGenerator;

    protected function getStub(): string
    {
        return $this->getStubFile('event.stub');
    }
}
