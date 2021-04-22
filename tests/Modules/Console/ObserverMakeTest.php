<?php

declare(strict_types=1);

namespace JazzTest\Modules\Console;

class ObserverMakeTest extends ATestCase
{

    protected string $myCommand = 'make:observer';
    protected string $myComponent = 'Observers';

    public function provider(): array
    {
        return [
            ['MyObserver', null, ['--model' => null]],
            ['MyModelObserver', null, ['--model' => 'MyFakeModel']],

            ['MyObserver', self::MODULE, ['--model' => null]],
            ['MyModelObserver', self::MODULE, ['--model' => 'MyFakeModel']],
        ];
    }

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
