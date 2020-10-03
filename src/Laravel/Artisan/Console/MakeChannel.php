<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\ChannelMakeCommand;
use Jazz\Laravel\Artisan\TModuleGenerator;

class MakeChannel extends ChannelMakeCommand
{
    use TModuleGenerator;

    /**
     * Returns stub file for generator
     * @return string
     */
    protected function getStub(): string
    {
        return $this->getStubFile('channel.stub');
    }
}
