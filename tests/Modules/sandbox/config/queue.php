<?php

return [
    'default' => env('QUEUE_CONNECTION', 'sync'),
    'connections' => [

        'sync' => [
            'driver' => 'sync',
        ],

    ],
    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database'),
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
    ],

];
