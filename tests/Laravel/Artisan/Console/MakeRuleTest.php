<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;
use Illuminate\Contracts\Validation\Rule;

class MakeRuleTest extends ATestCase
{
    protected $myCommand = 'make:rule';
    protected $myComponent = 'Rules';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyRule', false, null],
            ['MyRule', true, null],
        ];
    }

    /**
     * Additional Assertions
     * @param string $class
     * @param array $args
     */
    protected function assertions(string $class, array $args): void
    {
        $this->assertTrue(is_subclass_of($class, Rule::class));
        $this->assertIsArray($args);
    }
}
