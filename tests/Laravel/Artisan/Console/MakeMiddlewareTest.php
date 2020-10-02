<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;

class MakeMiddlewareTest extends ATestCase
{

    protected $myCommand = 'make:middleware';
    protected $myComponent = 'Http.Middleware';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyMiddleware', null, null],
            ['MyMiddleware', self::MODULE, null],
        ];
    }

    /**
     * Assertions
     * @param string $name
     * @param ?string $module
     */
    protected function assertions(string $name, ?string $module): void
    {
        parent::assertions($name, $module);

        $class = $this->getMyClass($name, $module);
        $this->assertMethodInClass($class, 'handle', true);
    }
}
