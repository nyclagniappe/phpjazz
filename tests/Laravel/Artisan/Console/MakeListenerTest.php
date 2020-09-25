<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;
use Illuminate\Contracts\Queue\ShouldQueue;

class MakeListenerTest extends ATestCase
{

    protected $myCommand = 'make:listener';
    protected $myComponent = 'Listeners';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyListener', false, ['--event' => null, '--queued' => false]],
            ['MyEventListener', false, ['--event' => 'MyListenerEvent', '--queued' => false]],
            ['MyQueuedListener', false, ['--event' => null, '--queued' => true]],
            ['MyQueuedEventListener', false, ['--event' => 'MyListenerEvent', '--queued' => true]],

            ['MyListener', true, ['--event' => null, '--queued' => false]],
            ['MyEventListener', true, ['--event' => 'MyListenerEvent', '--queued' => false]],
            ['MyQueuedListener', true, ['--event' => null, '--queued' => true]],
            ['MyQueuedEventListener', true, ['--event' => 'MyListenerEvent', '--queued' => true]],
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
        $this->assertTrue($args['--queued'] ? $implements : !$implements);
        $this->assertMethodInClass($class, 'handle', true);

        $this->assertIsArray($args);
    }
}
