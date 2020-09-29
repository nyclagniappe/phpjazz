<?php

declare(strict_types=1);

namespace Jazz\Laravel\Database;

use Illuminate\Database\Migrations\MigrationCreator as LaravelMigrationCreator;

class MigrationCreator extends LaravelMigrationCreator
{
    /**
     * Get the path to the stubs
     * @return string
     */
    public function stubPath(): string
    {
        return dirname(__DIR__) . '/Artisan/Console/stubs';
    }
}
