<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\NotificationMakeCommand;
use Illuminate\Console\GeneratorCommand;
use Jazz\Laravel\Artisan\{
    TModuleOptions,
    TModulePath,
    TModuleRootNamespace,
    TModuleStubFile,
    TModuleMarkdownTemplate,
};

class MakeNotification extends NotificationMakeCommand
{
    use TModuleOptions;
    use TModulePath;
    use TModuleRootNamespace;
    use TModuleStubFile;
    use TModuleMarkdownTemplate;

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
     * Build the class with given name
     * @param string $name
     * @return string
     * @throws
     */
    protected function buildClass($name): string
    {
        $name = GeneratorCommand::buildClass($name);
        if ($this->option('markdown')) {
            $name = str_replace(['DummyView', '{{view}}', '{{ view }}'], $this->option('markdown'), $name);
        }
        return $name;
    }
}
