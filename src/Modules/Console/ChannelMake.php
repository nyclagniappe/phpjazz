<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Foundation\Console\ChannelMakeCommand;

class ChannelMake extends ChannelMakeCommand
{
    use TGenerator;

    protected function getStub(): string
    {
        return $this->getStubFile('channel.stub');
    }
}
