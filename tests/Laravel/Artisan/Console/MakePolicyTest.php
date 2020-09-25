<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;

class MakePolicyTest extends ATestCase
{

    protected $myCommand = 'make:policy';
    protected $myComponent = 'Policies';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyPolicy', false, ['--model' => null]],
            ['MyModelPolicy', false, ['--model' => 'MyFakeModel']],

            ['MyPolicy', true, ['--model' => null]],
            ['MyModelPolicy', true, ['--model' => 'MyFakeModel']],
        ];
    }

    /**
     * Additional Assertions
     * @param string $class
     * @param array $args
     */
    protected function assertions(string $class, array $args): void
    {
        $hasModel = $args['--model'] !== null;
        $this->assertMethodInClass($class, 'viewAny', $hasModel);
        $this->assertMethodInClass($class, 'view', $hasModel);
        $this->assertMethodInClass($class, 'create', $hasModel);
        $this->assertMethodInClass($class, 'update', $hasModel);
        $this->assertMethodInClass($class, 'delete', $hasModel);
        $this->assertMethodInClass($class, 'restore', $hasModel);
        $this->assertMethodInClass($class, 'forceDelete', $hasModel);

        $this->assertIsArray($args);
    }
}
