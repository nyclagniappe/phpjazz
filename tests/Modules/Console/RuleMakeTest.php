<?php

declare(strict_types=1);

namespace JazzTest\Modules\Console;

use Illuminate\Contracts\Validation\Rule;

class RuleMakeTest extends ATestCase
{
    protected string $myCommand = 'make:rule';
    protected string $myComponent = 'Rules';

    public function provider(): array
    {
        return [
            ['MyRule', null, null],
            ['MyRule', self::MODULE, null],
        ];
    }

    protected function assertions(string $name, ?string $module): void
    {
        parent::assertions($name, $module);

        $class = $this->getMyClass($name, $module);
        $this->assertTrue(is_subclass_of($class, Rule::class));
    }
}
