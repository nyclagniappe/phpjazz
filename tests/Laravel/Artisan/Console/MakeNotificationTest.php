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
            ['MyNotification', null, null],
            ['MyMarkdownNotification', null, ['--markdown' => 'notification']],

            ['MyNotification', self::MODULE, null],
            ['MyMarkdownNotification', self::MODULE, ['--markdown' => 'notification']],
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
        $this->assertTrue(is_subclass_of($class, Notification::class));
        $this->assertIsArray($args);

        if (isset($args['--markdown'])) {
            $file = '/resources/views/' . $args['--markdown'] . '.blade.php';
            $path = self::SANDBOX . $file;

            if (isset($args[$this->myModuleKey])) {
                $path = dirname($this->getMyPath($args['name'], $args[$this->myModuleKey]), 2) . $file;
            }
            $this->assertFileExists($path);
        }
    }
}
