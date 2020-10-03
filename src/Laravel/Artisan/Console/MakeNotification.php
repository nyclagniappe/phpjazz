<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\NotificationMakeCommand;
use Jazz\Laravel\Artisan\{
    TModuleGenerator,
    TModuleMarkdownTemplate,
};

class MakeNotification extends NotificationMakeCommand
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
        $stub = $this->myBuildClass($name);
        if ($this->option('markdown')) {
            $stub = $this->replaceView($stub, $this->option('markdown'));
        }
        return $stub;
    }
}
