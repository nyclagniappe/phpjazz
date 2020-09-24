<?php

declare(strict_types=1);

namespace JazzTest\Laravel;

use Illuminate\Console\Command;

class SampleCommand extends Command
{
    protected $signature = 'jazz:sample';

    /**
     * Handles Execution
     */
    public function handle(): void
    {
        $this->line('JAZZ SAMPLE COMMAND');
    }
}
