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
            ['MyMiddleware', false, null],
            ['MyMiddleware', true, null],
        ];
    }

    /**
     * Additional Assertions
     * @param string $class
     * @param array $args
     */
    protected function assertions(string $class, array $args): void
    {
        $this->assertMethodInClass($class, 'handle', true);
        $this->assertIsArray($args);
    }
}
