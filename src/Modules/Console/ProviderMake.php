<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Foundation\Console\ProviderMakeCommand;

class ProviderMake extends ProviderMakeCommand
{
    use TGenerator;

    protected function getStub(): string
    {
        return $this->getStubFile('provider.stub');
    }
}
