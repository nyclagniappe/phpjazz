<?php

declare(strict_types=1);

namespace JazzTest\Modules\Console;

class EventMakeTest extends ATestCase
{
    protected string $myCommand = 'make:event';
    protected string $myComponent = 'Events';

    public function provider(): array
    {
        return [
            ['MyEvent', null, null],
            ['MyEvent', self::MODULE, null],
        ];
    }
}
