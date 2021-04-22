<?php

declare(strict_types=1);

namespace JazzTest\Modules\Console;

use Illuminate\Foundation\Http\FormRequest;

class RequestMakeTest extends ATestCase
{
    protected string $myCommand = 'make:request';
    protected string $myComponent = 'Http.Requests';

    public function provider(): array
    {
        return [
            ['MyRequest', null, null],
            ['MyRequest', self::MODULE, null],
        ];
    }

    protected function assertions(string $name, ?string $module): void
    {
        parent::assertions($name, $module);

        $class = $this->getMyClass($name, $module);
        $this->assertTrue(is_subclass_of($class, FormRequest::class));
    }
}
