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
            ['MyMail', false, null],
            ['MyMarkdownMail', false, ['--markdown' => 'mail']],

            ['MyMail', true, null],
            ['MyMarkdownMail', true, ['--markdown' => 'mail']],
        ];
    }

    /**
     * Additional Assertions
     * @param string $class
     * @param array $args
     */
    protected function assertions(string $class, array $args): void
    {
        $this->assertTrue(is_subclass_of($class, Mailable::class));
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
