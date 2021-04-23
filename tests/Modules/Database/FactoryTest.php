<?php

declare(strict_types=1);

namespace JazzTest\Modules\Database;

use JazzTest\Modules\ATestCase;
use Illuminate\Database\Eloquent\Factories\Factory as LaravelFactory;

class FactoryTest extends ATestCase
{
    /**
     * @dataProvider provider
     */
    public function testRun(string $model, string $expected): void
    {
        $this->assertEquals($expected, LaravelFactory::resolveFactoryName($model), $model);
    }

    public function provider(): array
    {
        $dbNs = 'Database\\Factories\\';
        $moduleNs = 'Module\\Test\\';

        return [
            ['App\\Models\\MyModel', $dbNs . 'MyModelFactory'],
            ['App\\MyModel', $dbNs . 'MyModelFactory'],
            [$moduleNs . 'Models\\MyModel', $moduleNs . $dbNs . 'MyModelFactory'],
            [$moduleNs . 'Models\\My\\Model', $moduleNs . $dbNs . 'My\\ModelFactory'],
        ];
    }
}
