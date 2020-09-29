<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\StubPublishCommand;
use Illuminate\Filesystem\Filesystem;
use DirectoryIterator;

class StubPublish extends StubPublishCommand
{
    protected $signature = 'stub:publish
                            {--force : Overwrite any existing files}
                            {--useLaravel : Use Laravel Base stubs instead of Jazz}';

    /**
     * Execute command
     */
    public function handle(): void
    {
        if ($this->option('useLaravel')) {
            parent::handle();
            return;
        }

        $fromPath = __DIR__ . '/stubs';
        $toPath = $this->laravel->basePath('stubs') . '/';
        if (!is_dir($toPath)) {
            (new Filesystem())->makeDirectory($toPath);
        }

        $dir = new DirectoryIterator($fromPath);
        foreach ($dir as $file) {
            if ($file->isDot() || $file->isDir()) {
                continue;
            }

            $to = $toPath . '/' . $file->getFilename();
            if (!file_exists($to) || $this->option('force')) {
                file_put_contents($to, file_get_contents($file->getPathname()));
            }
        }

        $this->info('Stubs published successfully');
    }
}
