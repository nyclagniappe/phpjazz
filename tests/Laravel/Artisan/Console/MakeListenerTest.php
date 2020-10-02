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
            ['MyListener', null, ['--event' => null, '--queued' => false]],
            ['MyEventListener', null, ['--event' => 'MyListenerEvent', '--queued' => false]],
            ['MyQueuedListener', null, ['--event' => null, '--queued' => true]],
            ['MyQueuedEventListener', null, ['--event' => 'MyListenerEvent', '--queued' => true]],

            ['MyListener', self::MODULE, ['--event' => null, '--queued' => false]],
            ['MyEventListener', self::MODULE, ['--event' => 'MyListenerEvent', '--queued' => false]],
            ['MyQueuedListener', self::MODULE, ['--event' => null, '--queued' => true]],
            ['MyQueuedEventListener', self::MODULE, ['--event' => 'MyListenerEvent', '--queued' => true]],
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
        $this->assertTrue($args['--queued'] ? $implements : !$implements);
        $this->assertMethodInClass($class, 'handle', true);
    }
}
