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
            ['MyObserver', null, ['--model' => null]],
            ['MyModelObserver', null, ['--model' => 'MyFakeModel']],

            ['MyObserver', self::MODULE, ['--model' => null]],
            ['MyModelObserver', self::MODULE, ['--model' => 'MyFakeModel']],
        ];
    }

    /**
     * Assertions
     * @param string $name
     * @param ?string $module
     */
    protected function assertions(string $name, ?string $module): void
    {
        $args = $this->myArgs;
        parent::assertions($name, $module);

        $class = $this->getMyClass($name, $module);
        $hasModel = $args['--model'] !== null;
        $this->assertMethodInClass($class, 'created', $hasModel);
        $this->assertMethodInClass($class, 'updated', $hasModel);
        $this->assertMethodInClass($class, 'deleted', $hasModel);
        $this->assertMethodInClass($class, 'restored', $hasModel);
        $this->assertMethodInClass($class, 'forceDeleted', $hasModel);
    }
}
