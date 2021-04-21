<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\InputOption;

trait TOptions
{
    protected function getOptions(): array
    {
        $key = Config::get('modules.key');
        $name = Config::get('modules.name');

        $ret = parent::getOptions();
        $ret[] = [$key, null, InputOption::VALUE_OPTIONAL, sprintf('Install in %s', $name)];
        return $ret;
    }
}
