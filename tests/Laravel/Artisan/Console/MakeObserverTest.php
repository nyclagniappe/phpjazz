<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;

class MakeObserverTest extends ATestCase
{

    protected $myCommand = 'make:observer';
    protected $myComponent = 'Observers';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyObserver', false, ['--model' => null]],
            ['MyModelObserver', false, ['--model' => 'MyFakeModel']],

            ['MyObserver', true, ['--model' => null]],
            ['MyModelObserver', true, ['--model' => 'MyFakeModel']],
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
        $this->assertMethodInClass($class, 'created', $hasModel);
        $this->assertMethodInClass($class, 'updated', $hasModel);
        $this->assertMethodInClass($class, 'deleted', $hasModel);
        $this->assertMethodInClass($class, 'restored', $hasModel);
        $this->assertMethodInClass($class, 'forceDeleted', $hasModel);

        $this->assertIsArray($args);
    }
}
