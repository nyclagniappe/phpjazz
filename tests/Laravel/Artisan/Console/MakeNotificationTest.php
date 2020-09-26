<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;
use Illuminate\Notifications\Notification;

class MakeNotificationTest extends ATestCase
{
    protected $myCommand = 'make:notification';
    protected $myComponent = 'Notifications';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyNotification', false, null],
            ['MyMarkdownNotification', false, ['--markdown' => 'notification']],

            ['MyNotification', true, null],
            ['MyMarkdownNotification', true, ['--markdown' => 'notification']],
        ];
    }

    /**
     * Additional Assertions
     * @param string $class
     * @param array $args
     */
    protected function assertions(string $class, array $args): void
    {
        $this->assertTrue(is_subclass_of($class, Notification::class));
        $this->assertIsArray($args);

        if (isset($args['--markdown'])) {
            $file = '/resources/views/' . $args['--markdown'] . '.blade.php';
            $path = self::SANDBOX . $file;

            if ($args['--module']) {
                $path = dirname($this->getMyPath($args['name'], $args['--module']), 2) . $file;
            }
            $this->assertFileExists($path);
        }
    }
}
