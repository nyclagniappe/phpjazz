<?php

declare(strict_types=1);

namespace JazzTest\Modules\Console;

use Illuminate\Contracts\Queue\ShouldQueue;

class JobMakeTest extends ATestCase
{

    protected string $myCommand = 'make:job';
    protected string $myComponent = 'Jobs';

    public function provider(): array
    {
        return [
            ['MyJob', null, ['--sync' => false]],
            ['MySyncJob', null, ['--sync' => true]],

            ['MyJob', self::MODULE, ['--sync' => false]],
            ['MySyncJob', self::MODULE, ['--sync' => true]],
        ];
    }

    protected function assertions(string $name, ?string $module): void
    {
        $args = $this->myArgs;
        parent::assertions($name, $module);

        $class = $this->getMyClass($name, $module);
        $implements = is_subclass_of($class, ShouldQueue::class);
        $this->assertTrue($args['--sync'] ? $implements : !$implements);
    }
}
