<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\ComponentMakeCommand;
use Illuminate\Foundation\Inspiring;
use Jazz\Laravel\Artisan\TModuleGenerator;

class MakeComponent extends ComponentMakeCommand
{
    use TModuleGenerator {
        buildClass as myBuildClass;
    }

    /**
     * Returns stub file for generator
     * @return string
     */
    protected function getStub(): string
    {
        return $this->getStubFile('view-component.stub');
    }

    /**
     * Build the class with given name
     * @param string $name
     * @return string
     */
    protected function buildClass($name): string
    {
        $stub = $this->myBuildClass($name);

        $replace = 'view(\'components.' . $this->getView() . '\')';
        return $this->replaceView($stub, $replace, $this->option('inline'));
    }

    /**
     * Write the view for the component
     */
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
