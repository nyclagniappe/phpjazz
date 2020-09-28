<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Database;

use JazzTest\Laravel\ATestCase;
use Illuminate\Database\Eloquent\Factories\Factory as LaravelFactory;

class FactoryTest extends ATestCase
{
    /**
     * Test default Factory
     * @param string $model
     * @param string $expected
     * @dataProvider provider
     */
    public function testRun(string $model, string $expected): void
    {
        $this->assertEquals($expected, LaravelFactory::resolveFactoryName($model), $model);
    }

    /**
     * Provider
     * @return array
     */
    public function provider(): array
    {
        $dbNs = 'Database\\Factories\\';
        $moduleNs = 'App\\Modules\\Test\\';

        return [
            ['App\\Models\\MyModel', $dbNs . 'MyModelFactory'],
            ['App\\MyModel', $dbNs . 'MyModelFactory'],
            [$moduleNs . 'Models\\MyModel', $moduleNs . $dbNs . 'MyModelFactory'],
            [$moduleNs . 'Models\\My\\Model', $moduleNs . $dbNs . 'My\\ModelFactory'],
        ];
    }
}
