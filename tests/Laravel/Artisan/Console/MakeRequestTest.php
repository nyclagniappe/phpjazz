<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;
use Illuminate\Foundation\Http\FormRequest;

class MakeRequestTest extends ATestCase
{
    protected $myCommand = 'make:request';
    protected $myComponent = 'Http.Requests';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyRequest', false, null],
            ['MyRequest', true, null],
        ];
    }

    /**
     * Additional Assertions
     * @param string $class
     * @param array $args
     */
    protected function assertions(string $class, array $args): void
    {
        $this->assertTrue(is_subclass_of($class, FormRequest::class));
        $this->assertIsArray($args);
    }
}
