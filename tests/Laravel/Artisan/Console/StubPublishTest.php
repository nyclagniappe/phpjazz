<?php

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\ATestCase;
use DirectoryIterator;

class StubPublishTest extends ATestCase
{
    /**
     * Test Stub Files
     * @param int $total expected total of STUB files
     * @param bool $useLaravel
     * @dataProvider provider
     */
    public function testRun(int $total, bool $useLaravel): void
    {
        $args = [];
        if ($useLaravel) {
            $args['--useLaravel'] = null;
        }

        $this->createArtisan('stub:publish', $args);

        $count = 0;
        $dir = new DirectoryIterator(self::SANDBOX . '/stubs');
        foreach ($dir as $file) {
            if ($file->isDot()) {
                continue;
            }
            ++$count;
        }
        $this->assertEquals($total, $count, 'Inaccurate Files Count');
    }

    /**
     * Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            [47, false],
            [27, true],
        ];
    }
}
