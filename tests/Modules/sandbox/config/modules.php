<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Modules Namespace
    |--------------------------------------------------------------------------
    */
    'namespace' => env('MODULES_NAMESPACE', 'Module\\'),

    /*
    |--------------------------------------------------------------------------
    | Path to Modules (relative to Application base path)
    |--------------------------------------------------------------------------
    */
    'path' => env('MODULES_BASE', 'modules'),

    /*
    |--------------------------------------------------------------------------
    | Console Options KEY for Module
    |--------------------------------------------------------------------------
    | php artisan my:command --module=...
    */
    'key' => env('MODULES_KEY', 'module'),

    /*
    |--------------------------------------------------------------------------
    | Formal Name used for Descriptions/Comments
    |--------------------------------------------------------------------------
    */
    'name' => env('MODULES_NAME', 'Module'),



    /*
    |--------------------------------------------------------------------------
    | Module Registration Method
    |--------------------------------------------------------------------------
    | This indicates how to automatically load base Module Providers.
    |
    | - null: skip automatic loading
    | - path: searches through PATH directory for Module\Provider class
    | - environment: based on LIST variable (see below)
    */
    'register' => env('MODULES_REGISTER', 'path'),

    /*
    |--------------------------------------------------------------------------
    | Module Providers to automatically register based on ENVIRONMENT
    |--------------------------------------------------------------------------
    | ** only used when "register" value is "list" **
    |
    | 'always'
    | Indicates Module Providers that should always be loaded.
    |
    | [environment]
    | Indicates Module Providers that should be loaded when APP is working
    | in given environment. The KEY should match a possible APP_ENVIRONMENT
    | value.
    */
    'environment' => [
        'always' => [],
    ],
];
