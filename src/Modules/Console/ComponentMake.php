<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Foundation\Console\ComponentMakeCommand;
use Illuminate\Foundation\Inspiring;

class ComponentMake extends ComponentMakeCommand
{
    use TGenerator {
        buildClass as myBuildClass;
    }

    protected function getStub(): string
    {
        return $this->getStubFile('view-component.stub');
    }

    protected function buildClass($name): string
    {
        $stub = $this->myBuildClass($name);

        $replace = 'view(\'components.' . $this->getView() . '\')';
        return $this->replaceView($stub, $replace, $this->option('inline'));
    }

    protected function writeView(): void
    {
        $file = str_replace('.', '/', 'components.' . $this->getView()) . '.blade.php';
        $path = $this->viewPath($file);

        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        if ($this->files->exists($path) && !$this->option('force')) {
            $this->error('View already exists!');
            return;
        }

        $contents = "<div>\n    <!-- " . Inspiring::quote() . " -->\n</div>";
        file_put_contents($path, $contents);
    }
}
