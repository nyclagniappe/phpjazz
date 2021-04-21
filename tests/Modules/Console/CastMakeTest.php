<?php

declare(strict_types=1);

namespace JazzTest\Modules\Console;

class CastMakeTest extends ATestCase
{
    protected $myCommand = 'make:cast';
    protected $myComponent = 'Casts';

    public function provider(): array
    {
        return [
            ['MyCast', null, null],
            ['MyCast', self::MODULE, null],
        ];
    }
}
