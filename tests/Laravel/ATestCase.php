<?php

declare(strict_types=1);

namespace JazzTest\Laravel;

use DirectoryIterator;
use Illuminate\Foundation\{
    Testing\TestCase as LaravelTestCase,
    Application as LaravelApplication,
    Console\Kernel as LaravelKernel,
    Exceptions\Handler as LaravelExceptionHandler
};
use Illuminate\Contracts\{
    Console\Kernel as ContractKernel,
    Debug\ExceptionHandler as ContractExceptionHandler
};
use Illuminate\Events\Dispatcher;

abstract class ATestCase extends LaravelTestCase
{
    protected const SANDBOX = __DIR__ . '/sandbox';
    protected const APP_PATH = self::SANDBOX . '/app';

    /**
     * Set Up
     * @throws
     * @postcondition clears the APP and DATABASE directories of created files
     */
    public function setUp(): void
    {
        parent::setUp();

        $deleteDir = static function (string $path) use (&$deleteDir) {
            $dir = new DirectoryIterator($path);
            foreach ($dir as $file) {
                if ($file->isDot() || $file->getFilename() === '.gitignore') {
                    continue;
                }

                if ($file->isDir()) {
                    $deleteDir($file->getRealPath());
                    rmdir($file->getRealPath());
                } else {
                    unlink($dir->getRealPath());
                }
            }
        };

        $deleteDir(self::SANDBOX . '/bootstrap/cache');
        $deleteDir(self::SANDBOX . '/app');
        $deleteDir(self::SANDBOX . '/database/factories');
        $deleteDir(self::SANDBOX . '/database/migrations');
        $deleteDir(self::SANDBOX . '/database/seeds');
        $deleteDir(self::SANDBOX . '/resources/views');
    }

    /**
     * Creates the Laravel Application
     * @return LaravelApplication
     */
    public function createApplication(): LaravelApplication
    {
        $app = new LaravelApplication(self::SANDBOX);
        $events = new Dispatcher();

        $app->singleton(
            ContractKernel::class,
            function () use ($app, $events) {
                return new class ($app, $events) extends LaravelKernel {
                    protected $commands = [SampleCommand::class];
                };
            }
        );

        $app->singleton(
            ContractExceptionHandler::class,
            LaravelExceptionHandler::class
        );

        $app->make(ContractKernel::class)->bootstrap();
        return $app;
    }
}
