<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Foundation\Console\ProviderMakeCommand;
use Symfony\Component\Console\Input\InputOption;

class ProviderMake extends ProviderMakeCommand
{
    use TGenerator {
        getOptions as myGetOptions;
    }

    protected function getStub(): string
    {
        $ret = 'provider.stub';
        if ($this->option('event')) {
            $ret = 'provider.event.stub';
        }
        return $this->getStubFile($ret);
    }

    protected function getOptions(): array
    {
        $ret = $this->myGetOptions();
        $ret[] = ['event', null, InputOption::VALUE_OPTIONAL, 'Use Event Provider', false];
        return $ret;
    }
}
