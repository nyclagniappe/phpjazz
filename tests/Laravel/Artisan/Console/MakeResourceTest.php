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
            ['MyResource', null, null],
            ['MyResourceCollection', null, ['--collection' => 'MyCollection']],

            ['MyResource', self::MODULE, null],
            ['MyResourceCollection', self::MODULE, ['--collection' => 'MyCollection']],
        ];
    }

    /**
     * Assertions
     * @param string $name
     * @param ?string $module
     */
    protected function assertions(string $name, ?string $module): void
    {
        $args = $this->myArgs;
        parent::assertions($name, $module);

        $class = $this->getMyClass($name, $module);
        $isSubClass = is_subclass_of($class, ResourceCollection::class);
        $isCollection = Str::endsWith($class, 'Collection') || array_key_exists('--collection', $args);
        $this->assertTrue($isCollection ? $isSubClass : !$isSubClass);
    }
}
