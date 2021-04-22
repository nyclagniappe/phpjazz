<?php

declare(strict_types=1);

namespace JazzTest\Modules\Console;

class SeedTest extends SeederMakeTest
{

    /**
     * @dataProvider provider
     */
    public function testRun(string $name, ?string $module, ?array $args): void
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

    public function provider(): array
    {
        return [
            ['MySeedSeeder', null, []],
            ['MySeedSeeder', self::MODULE, []],
        ];
    }
}
