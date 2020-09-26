<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan;

use Illuminate\Database\Migrations\MigrationCreator as LaravelMigrationCreator;

class MigrationCreator extends LaravelMigrationCreator
{
    /**
     * Get the path to the stubs
     * @return string
     */
    public function stubPath(): string
    {
        return __DIR__ . '/Console/stubs';
    }
}
