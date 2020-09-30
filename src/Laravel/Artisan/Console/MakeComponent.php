<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\ComponentMakeCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Inspiring;
use Jazz\Laravel\Artisan\{
    TModuleOptions,
    TModulePath,
    TModuleRootNamespace,
    TModuleStubFile,
};

class MakeComponent extends ComponentMakeCommand
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
        return $this->getStubFile('view-component.stub');
    }

    /**
     * Build the class with the given name
     * @param string $name
     * @return string
     */
    protected function buildClass($name): string
    {
        $name = parent::buildClass($name);
        $replace = 'view(\'components.' . $this->getView() . '\')';
        if ($this->option('inline')) {
            $replace = "<<<'blade'\n<div>\n    <!-- " . Inspiring::quote() . " -->\n</div>\nblade";
        }
        return str_replace(['DummyView', '{{view}}', '{{ view }}'], $replace, $name);
    }

    /**
     * Write the view for the component
     */
    protected function writeView(): void
    {
        $file = str_replace('.', '/', 'components.' . $this->getView()) . '.blade.php';
        $path = $this->viewPath($file);

        $module = $this->option(Config::get('modules.key'));
        if ($module) {
            $path = $this->laravel->basePath() . '/'
                . Config::get('modules.path') . '/'
                . $module . '/resources/views/' . $file;
        }

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
