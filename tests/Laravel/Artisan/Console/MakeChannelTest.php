<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;

class MakeChannelTest extends ATestCase
{
    protected $myCommand = 'make:channel';
    protected $myComponent = 'Broadcasting';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyChannel', null, null],
            ['MyChannel', self::MODULE, null],
        ];
    }
}
