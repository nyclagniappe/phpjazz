<?php

declare(strict_types=1);

namespace Jazz\Laravel;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{

    /**
     * Register any application services
     */
    public function register(): void
    {
        $this->app->register(ArtisanProvider::class);
    }

    /**
     * Boostrap Application Services
     */
    public function boot(): void
    {
        $config = dirname(__DIR__, 2) . '/configs/modules.php';
        $this->publishes([$config]);
    }
}
