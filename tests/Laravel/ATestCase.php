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
use Illuminate\Support\Str;
use Illuminate\Testing\PendingCommand;

abstract class ATestCase extends LaravelTestCase
{
    protected const SANDBOX = __DIR__ . '/sandbox';
    protected const APP_PATH = self::SANDBOX . '/app';
    protected const APP_NAMESPACE = 'App\\';

    protected bool $sandboxCleanOnSetUp = true;
    protected bool $sandboxCleanOnTearDown = false;
    protected array $sandboxPaths = [
        'bootstrap/cache',
        'app',
        'database/factories',
        'database/migrations',
        'database/seeders',
        'resources/views',
        'tests/Feature',
        'tests/Unit',
    ];

    /**
     * Set Up
     * @throws
     * @postcondition clears the APP and DATABASE directories of created files
     */
    public function setUp(): void
    {
        parent::setUp();

        if ($this->sandboxCleanOnSetUp) {
            foreach ($this->sandboxPaths as $path) {
                $this->sandboxClean($path);
            }
        }
        $this->sandboxClean('stubs');
    }

    /**
     * Tear Down
     */
    public function tearDown(): void
    {
        parent::tearDown();

        if ($this->sandboxCleanOnTearDown) {
            foreach ($this->sandboxPaths as $path) {
                $this->sandboxClean($path);
            }
        }
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
                return new class ($app, $events) extends LaravelKernel
                {
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

    /**
     * Create an Artisan Command
     * @param string $command
     * @param array $args
     * @return PendingCommand
     */
    protected function createArtisan(string $command, array $args = []): PendingCommand
    {
        return $this->artisan($command, $args)
            ->assertExitCode(0);
    }



    /**
     * Clean Sandbox
     * @param string $path
     */
    private function sandboxClean(string $path): void
    {
        if (!Str::contains($path, self::SANDBOX)) {
            $path = self::SANDBOX . '/' . $path;
        }

        if (!is_dir($path)) {
            return;
        }

        $dir = new DirectoryIterator($path);
        foreach ($dir as $file) {
            if ($file->isDot() || $file->getFilename() === '.gitignore') {
                continue;
            }

            if ($file->isDir()) {
                $this->sandboxClean($file->getRealPath());
                rmdir($file->getRealPath());
            } else {
                unlink($dir->getRealPath());
            }
        }
    }
}
