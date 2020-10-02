<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;
use Illuminate\Mail\Mailable;

class MakeMailTest extends ATestCase
{
    protected $myCommand = 'make:mail';
    protected $myComponent = 'Mail';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyMail', null, null],
            ['MyMarkdownMail', null, ['--markdown' => 'mail']],

            ['MyMail', self::MODULE, null],
            ['MyMarkdownMail', self::MODULE, ['--markdown' => 'mail']],
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
        $this->assertTrue(is_subclass_of($class, Mailable::class));
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
