<?php

declare(strict_types=1);

namespace JazzTest\Modules\Database;

use JazzTest\Modules\ATestCase;
use Illuminate\Support\Str;

class ModelTest extends ATestCase
{
    /**
     * @dataProvider provider
     */
    public function testRun(string $factory, string $expected): void
    {
        $txt = '<?php' . PHP_EOL;
        $txt .= 'namespace ' . trim(Str::before($factory, class_basename($factory)), '\\') . ';' . PHP_EOL;
        $txt .= 'use Illuminate\Database\Eloquent\Factories\Factory;' . PHP_EOL;
        $txt .= 'class ' . class_basename($factory) . ' extends Factory {' . PHP_EOL;
        $txt .= 'public function definition(): array { return []; }' . PHP_EOL;
        $txt .= '}';

        $path = self::SANDBOX . '/database/factories/' . str_replace('\\', '', $factory) . '.php';
        file_put_contents($path, $txt);
        require_once($path);

        $factory = new $factory();
        $this->assertEquals($expected, $factory->modelName($factory), get_class($factory));
    }

    public function provider(): array
    {
        $modelNs = 'App\\Models\\';
        $moduleNs = 'Module\\Test\\';

        return [
            ['Database\\Factories\\MyModelFactory', $modelNs . 'MyModel'],
            ['Database\\Factories\\Sub\\MyModelFactory', $modelNs . 'Sub\\MyModel'],
            [$moduleNs . 'Database\\Factories\\MyModelFactory', $moduleNs . 'Models\\MyModel'],
            [$moduleNs . 'Database\\Factories\\Sub\\MyModelFactory', $moduleNs . 'Models\\Sub\\MyModel'],
        ];
    }
}
