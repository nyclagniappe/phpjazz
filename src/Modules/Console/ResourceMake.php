<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Foundation\Console\ResourceMakeCommand;

class ResourceMake extends ResourceMakeCommand
{
    use TGenerator;

    protected function getStub(): string
    {
        $stubFile = 'resource.stub';
        if ($this->collection()) {
            $stubFile = 'resource-collection.stub';
        }
        return $this->getStubFile($stubFile);
    }
}
