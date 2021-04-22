<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Foundation\Console\MailMakeCommand;

class MailMake extends MailMakeCommand
{
    use TGenerator {
        buildClass as myBuildClass;
    }
    use TMarkdownTemplate;

    protected function getStub(): string
    {
        $stubFile = 'mail.stub';
        if ($this->option('markdown')) {
            $stubFile = 'mail.markdown.stub';
        }
        return $this->getStubFile($stubFile);
    }

    protected function buildClass($name): string
    {
        $stub = $this->myBuildClass($name);
        if ($this->option('markdown')) {
            $stub = $this->replaceView($stub, $this->option('markdown'));
        }
        return $stub;
    }
}
