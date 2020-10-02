<?php

return [

    /**
     * Modules Namespace
     */
    'namespace' => env('MODULES_NAMESPACE', 'App\\Modules\\'),

    /**
     * Path to Modules from Application base
     */
    'path' => env('MODULES_BASE', 'app/Modules'),

    /**
     * Console Options KEY for Module
     * php artisan my:command --module=...
     */
    'key' => env('MODULES_KEY', 'module'),

    /**
     * Formal Name used for Descriptions/Comments
     */
    'name' => env('MODULES_NAME', 'Module'),

    /**
     * Full List of available Modules (optional)
     * - filled in manually after publishing config file
     *
     * Following Commands add Module elements to operation if listed.
     * - event:generate
     * - event:list
     * - schema:dump
     */
    'list' => [],

];
