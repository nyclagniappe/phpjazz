<?php

declare(strict_types=1);

namespace Jazz\Laravel;

use Illuminate\Foundation\Providers\ArtisanServiceProvider;

class ArtisanProvider extends ArtisanServiceProvider
{

    /**
     * Register the Service Provider
     */
    public function register(): void
    {
        parent::register();

        // add NEW Commands not currently registered
    }


    // REGISTER METHODS
}
