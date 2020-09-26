<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\MailMakeCommand;
use Jazz\Laravel\Artisan\{
    TModuleOptions,
    TModulePath,
    TModuleRootNamespace,
    TModuleStubFile,
    TModuleMarkdownTemplate,
};

class MakeMail extends MailMakeCommand
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
        $stubFile = 'mail.stub';
        if ($this->option('markdown')) {
            $stubFile = 'mail.markdown.stub';
        }
        return $this->getStubFile($stubFile);
    }
}
