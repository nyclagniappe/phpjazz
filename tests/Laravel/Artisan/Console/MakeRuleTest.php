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
            ['MyRule', null, null],
            ['MyRule', self::MODULE, null],
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
        $this->assertTrue(is_subclass_of($class, Rule::class));
    }
}
