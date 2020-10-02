<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;
use Illuminate\Contracts\Queue\ShouldQueue;

class MakeJobTest extends ATestCase
{

    protected $myCommand = 'make:job';
    protected $myComponent = 'Jobs';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyJob', null, ['--sync' => false]],
            ['MySyncJob', null, ['--sync' => true]],

            ['MyJob', self::MODULE, ['--sync' => false]],
            ['MySyncJob', self::MODULE, ['--sync' => true]],
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
        $implements = is_subclass_of($class, ShouldQueue::class);
        $this->assertTrue($args['--sync'] ? $implements : !$implements);
    }
}
