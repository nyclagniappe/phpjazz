<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;

class MakeCastTest extends ATestCase
{
    protected $myCommand = 'make:cast';
    protected $myComponent = 'Casts';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyCast', null, null],
            ['MyCast', self::MODULE, null],
        ];
    }
}
