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
            ['MyPolicy', null, ['--model' => null]],
            ['MyModelPolicy', null, ['--model' => 'MyFakeModel']],

            ['MyPolicy', self::MODULE, ['--model' => null]],
            ['MyModelPolicy', self::MODULE, ['--model' => 'MyFakeModel']],
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
