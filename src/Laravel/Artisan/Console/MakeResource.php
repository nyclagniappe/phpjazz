<?php

declare(strict_types=1);

namespace Jazz\Laravel\Artisan\Console;

use Illuminate\Foundation\Console\ResourceMakeCommand;
use Jazz\Laravel\Artisan\TModuleGenerator;

class MakeResource extends ResourceMakeCommand
{
    use TModuleGenerator;

    /**
     * Returns stub file for generator
     * @return string
     */
    protected function getStub(): string
    {
        $stubFile = 'resource.stub';
        if ($this->collection()) {
            $stubFile = 'resource-collection.stub';
        }
        return $this->getStubFile($stubFile);
    }
}
