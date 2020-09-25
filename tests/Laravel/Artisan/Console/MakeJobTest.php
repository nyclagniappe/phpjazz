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
            ['MyJob', false, ['--sync' => false]],
            ['MySyncJob', false, ['--sync' => true]],

            ['MyJob', true, ['--sync' => false]],
            ['MySyncJob', true, ['--sync' => true]],
        ];
    }

    /**
     * Additional Assertions
     * @param string $class
     * @param array $args
     */
    protected function assertions(string $class, array $args): void
    {
        $implements = is_subclass_of($class, ShouldQueue::class);
        $this->assertTrue($args['--sync'] ? $implements : !$implements);

        $this->assertIsArray($args);
    }
}
