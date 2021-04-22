<?php

declare(strict_types=1);

namespace Jazz\Modules\Database;

use Illuminate\Database\Migrations\MigrationCreator;

class Migration extends MigrationCreator
{
    public function stubPath(): string
    {
        return dirname(__DIR__) . '/Console/stubs';
    }
}
