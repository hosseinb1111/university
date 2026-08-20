<?php

declare(strict_types=1);

/**
 * =========================================================
 * Sadra University Website
 * Database Configuration
 * =========================================================
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Database Connection
    |--------------------------------------------------------------------------
    */

    'driver' => env(
        'DB_DRIVER',
        'mysql'
    ),

    'host' => env(
        'DB_HOST',
        '127.0.0.1'
    ),

    'port' => (int) env(
        'DB_PORT',
        '3306'
    ),

    'database' => env(
        'DB_DATABASE',
        'sadra'
    ),

    'username' => env(
        'DB_USERNAME',
        'root'
    ),

    'password' => env(
        'DB_PASSWORD',
        ''
    ),

    /*
    |--------------------------------------------------------------------------
    | Character Set
    |--------------------------------------------------------------------------
    |
    | utf8mb4 is required for Persian text and modern Unicode content.
    |
    */

    'charset' => env(
        'DB_CHARSET',
        'utf8mb4'
    ),

    /*
    |--------------------------------------------------------------------------
    | Collation
    |--------------------------------------------------------------------------
    */

    'collation' => env(
        'DB_COLLATION',
        'utf8mb4_unicode_ci'
    ),

    /*
    |--------------------------------------------------------------------------
    | PDO Options
    |--------------------------------------------------------------------------
    */

    'options' => [

        /*
        | Return database errors as PDO exceptions.
        */
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

        /*
        | Return query results as associative arrays by default.
        */
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

        /*
        | Disable emulated prepared statements.
        |
        | This is important for proper parameterized queries.
        */
        PDO::ATTR_EMULATE_PREPARES => false,

        /*
        | Keep connections available when possible.
        */
        PDO::ATTR_PERSISTENT => false,
    ],
];