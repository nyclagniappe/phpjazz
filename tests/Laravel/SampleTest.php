<?php

declare(strict_types=1);

namespace JazzTest\Laravel;

class SampleTest extends ATestCase
{
    /**
     * Test Sample Command
     */
    public function testSampleCommand(): void
    {
        $this->artisan('jazz:sample')
            ->expectsOutput('JAZZ SAMPLE COMMAND')
            ->assertExitCode(0);
    }
}
