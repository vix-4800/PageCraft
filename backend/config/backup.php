<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Storage Configuration
    |--------------------------------------------------------------------------
    |
    | The directory where the backups will be stored.
    */
    'directory' => storage_path('backups'),

    /*
    |--------------------------------------------------------------------------
    | Backup Retention
    |--------------------------------------------------------------------------
    |
    | The period after which the backups will be deleted.
    | Possible values: 'days', 'weeks', 'months', 'years'
    */

    'delete_after_method' => 'months',

    'delete_after' => 1,
];
