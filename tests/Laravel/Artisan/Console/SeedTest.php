<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\ATestCase;

class SeedTest extends ATestCase
{
    /**
     * Test RUN
     * @param string|null $name
     * @param string|null $module
     * @param array|null $args
     * @dataProvider provider
     */
    public function testRun(?string $name, ?string $module, ?array $args): void
    {
        if ($name === null) {
            $this->markTestIncomplete();
        }

        if ($args === null) {
            $args = [];
        }
        $args['name'] = $name;
        $args['--module'] = $module;
        $args['--no-interaction'] = true;

        $this->artisan('make:seeder', $args)
            ->assertExitCode(0);

        unset($args['name']);
        $args['--class'] = $name;
        $this->artisan('db:seed', $args)
            ->assertExitCode(0);
    }

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MySeeder', null, []],
            ['MySeeder', 'Test', []],
        ];
    }
}
