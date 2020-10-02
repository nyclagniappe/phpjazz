<?php

include_once dirname(__DIR__) . '/vendor/autoload.php';

$deleteDir = static function (string $path) use (&$deleteDir) {
    if (!is_dir($path)) {
        return;
    }

    $dir = new DirectoryIterator($path);
    foreach ($dir as $file) {
        if ($file->isDot() || $file->getFilename() === '.gitignore') {
            continue;
        }

        if ($file->isDir()) {
            $deleteDir($file->getRealPath());
            rmdir($file->getRealPath());
        } else {
            unlink($dir->getRealPath());
        }
    }
};

$sandboxPaths = [
    'bootstrap/cache',
    'app',
    'database/factories',
    'database/migrations',
    'database/seeders',
    'resources/views',
    'tests/Feature',
    'tests/Unit',
];
foreach ($sandboxPaths as $path) {
    $deleteDir(__DIR__ . '/Laravel/sandbox/' . $path);
}
