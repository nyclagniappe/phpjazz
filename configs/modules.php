<?php

return [

    /**
     * Modules Namespace
     */
    'namespace' => env('MODULES_NAMESPACE', 'App\\Modules\\'),

    /**
     * Console Options KEY for Module
     * php artisan my:command --module=...
     */
    'key' => env('MODULES_KEY', 'module'),

    /**
     * Path to Modules from Application base
     */
    'path' => env('MODULES_BASE', 'app/Modules'),

    /**
     * Formal Name used for Descriptions/Comments
     */
    'name' => env('MODULES_NAME', 'Module'),

];
