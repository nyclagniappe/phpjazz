<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;

class MakeEventTest extends ATestCase
{
    protected $myCommand = 'make:event';
    protected $myComponent = 'Events';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyEvent', null, null],
            ['MyEvent', self::MODULE, null],
        ];
    }
}
