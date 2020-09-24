<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan;

trait TModuleStubFile
{
    /**
     * Get the stub file
     * @param string $name
     * @return string
     */
    protected function getStubFile(string $name): string
    {
        $path = 'stubs/' . $name;

        $localPath = $this->laravel->basePath($path);
        return file_exists($localPath)
            ? $localPath
            : __DIR__ . '/Console/' . $path;
    }
}
