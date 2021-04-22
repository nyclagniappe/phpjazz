<?php

namespace JazzTest\Modules\Console;

use JazzTest\Modules\ATestCase;
use DirectoryIterator;

class StubPublishTest extends ATestCase
{
    /**
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

    public function provider(): array
    {
        return [
            [47, false],
            [30, true],
        ];
    }
}
