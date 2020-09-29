<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\TestMakeCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Jazz\Laravel\Artisan\{
    TModuleRootNamespace,
    TModuleStubFile,
};

class MakeTest extends TestMakeCommand
{
    use TModuleRootNamespace;
    use TModuleStubFile;

    /**
     * Constructor
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        $key = Config::get('modules.key');
        $name = Config::get('modules.name');
        $signature = '{--' . $key . '= : ' . sprintf('Install in %s', $name) . '}';
        $this->signature .= $signature;

        parent::__construct($files);
    }

    /**
     * Get the destination class path
     * @param string $name
     * @return string
     */
    protected function getPath($name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        $name = Str::replaceFirst('\Tests', '', $name);
        $path = base_path('tests');

        $module = $this->option(Config::get('modules.key'));
        if ($module) {
            $path = $this->laravel->basePath() . '/' . Config::get('modules.path') . '/' . $module . '/Tests';
        }

        return $path . '/' . str_replace('\\', '/', $name) . '.php';
    }

    /**
     * Get the default namespace for the class
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Tests' . ($this->option('unit') ? '\Unit' : '\Feature');
    }

    /**
     * Returns stub file for generator
     * @return string
     */
    protected function getStub(): string
    {
        $stubFile = 'test.stub';
        if ($this->option('unit')) {
            $stubFile = 'test.unit.stub';
        }
        return $this->getStubFile($stubFile);
    }
}
