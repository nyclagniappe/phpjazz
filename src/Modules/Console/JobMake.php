<?php

declare(strict_types=1);

namespace Jazz\Modules\Console;

use Illuminate\Foundation\Console\JobMakeCommand;

class JobMake extends JobMakeCommand
{
    use TGenerator;

    protected function getStub(): string
    {
        $stubFile = 'job.stub';
        if ($this->option('sync')) {
            $stubFile = 'job.queued.stub';
        }
        return $this->getStubFile($stubFile);
    }
}
