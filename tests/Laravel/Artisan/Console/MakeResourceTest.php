<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;

class MakeResourceTest extends ATestCase
{
    protected $myCommand = 'make:resource';
    protected $myComponent = 'Http.Resources';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyResource', false, null],
            ['MyCollectionResource', false, ['--collection' => 'MyCollection']],
            ['MyResourceCollection', false, null],

            ['MyResource', true, null],
            ['MyCollectionResource', true, ['--collection' => 'MyCollection']],
            ['MyResourceCollection', true, null],
        ];
    }

    /**
     * Additional Assertions
     * @param string $class
     * @param array $args
     */
    protected function assertions(string $class, array $args): void
    {
        $isSubClass = is_subclass_of($class, ResourceCollection::class);
        $isCollection = Str::endsWith($class, 'Collection') || array_key_exists('--collection', $args);
        $this->assertTrue($isCollection ? $isSubClass : !$isSubClass);

        $this->assertIsArray($args);
    }
}
