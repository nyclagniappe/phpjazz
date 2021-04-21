<?php

declare(strict_types=1);

namespace Jazz\Modules;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{

    /**
     * Register any application services
     */
    public function register(): void
    {
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
