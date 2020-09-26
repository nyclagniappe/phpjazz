<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\NotificationMakeCommand;
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
}
