<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Support\Facades\Config;

trait TMarkdownTemplate
{
    protected function writeMarkdownTemplate(): void
    {
        $module = $this->option(Config::get('modules.key'));
        if ($module) {
            $path = $this->laravel->basePath() . '/' . Config::get('modules.path') . '/' . $module;
            $path .= '/resources/views/';

            if (!$this->files->isDirectory($path)) {
                $this->files->makeDirectory($path, 0755, true);
            }

            $path .= str_replace('.', '/', $this->option('markdown')) . '.blade.php';
            $this->files->put($path, file_get_contents($this->getStubFile('markdown.stub')));
            return;
        }
        parent::writeMarkdownTemplate();
    }
}
