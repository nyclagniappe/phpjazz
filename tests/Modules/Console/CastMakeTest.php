<?php

declare(strict_types=1);

namespace JazzTest\Modules\Console;

class CastMakeTest extends ATestCase
{
    protected string $myCommand = 'make:cast';
    protected string $myComponent = 'Casts';

    public function provider(): array
    {
        return [
            ['MyCast', null, null],
            ['MyCast', self::MODULE, null],
        ];
    }
}
