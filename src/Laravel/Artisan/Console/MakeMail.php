<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\MailMakeCommand;
use Jazz\Laravel\Artisan\{
    TModuleGenerator,
    TModuleMarkdownTemplate,
};

class MakeMail extends MailMakeCommand
{
    use TModuleGenerator {
        buildClass as myBuildClass;
    }
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

    /**
     * Build the class with given name
     * @param string $name
     * @return string
     * @throws
     */
    protected function buildClass($name): string
    {
        $stub = $this->myBuildClass($name);
        if ($this->option('markdown')) {
            $stub = $this->replaceView($stub, $this->option('markdown'));
        }
        return $stub;
    }
}
