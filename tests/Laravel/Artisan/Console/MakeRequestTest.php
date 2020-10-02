<?php

declare(strict_types=1);

namespace JazzTest\Laravel\Artisan\Console;

use JazzTest\Laravel\Artisan\ATestCase;
use Illuminate\Foundation\Http\FormRequest;

class MakeRequestTest extends ATestCase
{
    protected $myCommand = 'make:request';
    protected $myComponent = 'Http.Requests';

    /**
     * Data Provider
     * @return array
     */
    public function provider(): array
    {
        return [
            ['MyRequest', null, null],
            ['MyRequest', self::MODULE, null],
        ];
    }

    /**
     * Assertions
     * @param string $name
     * @param ?string $module
     */
    protected function assertions(string $name, ?string $module): void
    {
        parent::assertions($name, $module);

        $class = $this->getMyClass($name, $module);
        $this->assertTrue(is_subclass_of($class, FormRequest::class));
    }
}
