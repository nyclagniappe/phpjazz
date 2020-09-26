<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\NotificationMakeCommand;
use Illuminate\Support\Facades\Config;
use Jazz\Laravel\Artisan\{
    TModuleOptions,
    TModulePath,
    TModuleRootNamespace,
    TModuleStubFile,
};

class MakeNotification extends NotificationMakeCommand
{
    use TModuleOptions;
    use TModulePath;
    use TModuleRootNamespace;
    use TModuleStubFile;

    /**
     * Returns stub file for generator
     * @return string
     */
    protected function getStub(): string
    {
        $stubFile = 'notification.stub';
        if ($this->option('markdown')) {
            $stubFile = 'notification.markdown.stub';
        }
        return $this->getStubFile($stubFile);
    }

    /**
     * Write the Markdown template for Mailable
     */
    protected function writeMarkdownTemplate(): void
    {
        $module = $this->option(Config::get('modules.key'));
        if ($module) {
            $path = $this->laravel->basePath() . '/' . Config::get('modules.path') . '/' . $module;
            $path .= '/resources/views/';

            if (!$this->files->isDirectory($path)) {
                $this->files->makeDirectory($path, 0755, true);
            }

            $path .= str_replace('.', '/', $this->option('markdown')) . '.blade.php';
            $this->files->put($path, file_get_contents($this->getStubFile('markdown.stub')));
            return;
        }
        parent::writeMarkdownTemplate();
    }
}
