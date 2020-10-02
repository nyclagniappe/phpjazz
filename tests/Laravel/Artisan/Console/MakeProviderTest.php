<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;

class MakeProviderTest extends ATestCase
{
    protected $myCommand = 'make:provider';
    protected $myComponent = 'Providers';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyProvider', null, null],
            ['MyProvider', self::MODULE, null],
        ];
    }
}
