<?php

declare(strict_types=1);

namespace JazzTest\Modules\Console;

class ProviderMakeTest extends ATestCase
{
    protected string $myCommand = 'make:provider';
    protected string $myComponent = 'Providers';

    public function provider(): array
    {
        return [
            ['MyProvider', null, null],
            ['MyProvider', self::MODULE, null],
        ];
    }
}
