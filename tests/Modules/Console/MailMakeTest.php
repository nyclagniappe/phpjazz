<?php

declare(strict_types=1);

namespace JazzTest\Modules\Console;

use Illuminate\Mail\Mailable;

class MailMakeTest extends ATestCase
{
    protected string $myCommand = 'make:mail';
    protected string $myComponent = 'Mail';

    public function provider(): array
    {
        return [
            ['MyMail', null, null],
            ['MyMarkdownMail', null, ['--markdown' => 'mail']],

            ['MyMail', self::MODULE, null],
            ['MyMarkdownMail', self::MODULE, ['--markdown' => 'mail']],
        ];
    }

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
