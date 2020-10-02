<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

class SeedTest extends MakeSeederTest
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
        parent::testRun($name, $module, $args);

        $args = ($args ?? []);
        $args['--class'] = $name;
        $args['--no-interaction'] = true;
        if ($module) {
            $args[$this->myModuleKey] = $module;
        }

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
            ['MySeedSeeder', null, []],
            ['MySeedSeeder', self::MODULE, []],
        ];
    }
}
