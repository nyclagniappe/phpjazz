<?php

declare(strict_types=1);

namespace JazzTest\Modules\Console;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;

class ResourceMakeTest extends ATestCase
{
    protected string $myCommand = 'make:resource';
    protected string $myComponent = 'Http.Resources';

    public function provider(): array
    {
        return [
            ['MyResource', null, null],
            ['MyResourceCollection', null, ['--collection' => 'MyCollection']],

            ['MyResource', self::MODULE, null],
            ['MyResourceCollection', self::MODULE, ['--collection' => 'MyCollection']],
        ];
    }

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
