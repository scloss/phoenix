<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PDO Fetch Style
    |--------------------------------------------------------------------------
    |
    | By default, database results will be returned as instances of the PHP
    | stdClass object; however, you may desire to retrieve records in an
    | array format for simplicity. Here you can tweak the fetch style.
    |
    */

    'fetch' => PDO::FETCH_OBJ,

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'phoenix_tt_db'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'mysql2' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST2', '172.16.136.35'),
            'port' => env('DB_PORT2', '3306'),
            'database' => env('DB_DATABASE2', 'login_plugin_db'),
            'username' => env('DB_USERNAME2', 'mehraj'),
            'password' => env('DB_PASSWORD2', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        'mysql3' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST3', '172.16.136.35'),
            'port' => env('DB_PORT3', '3306'),
            'database' => env('DB_DATABASE3', 'hr_tool_db'),
            'username' => env('DB_USERNAME3', 'mehraj'),
            'password' => env('DB_PASSWORD3', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ], 
        'mysql5' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST5', '172.16.136.80'),
            'port' => env('DB_PORT5', '3306'),
            'database' => env('DB_DATABASE5', 'scl_sms_db'),
            'username' => env('DB_USERNAME5', 'phoenix'),
            'password' => env('DB_PASSWORD5', 'noctoolisdead1234!@#$'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],        

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST4', '172.16.136.14'),
            'port' => env('DB_PORT4', '5432'),
            'database' => env('DB_DATABASE4', 'opennms'),
            'username' => env('DB_USERNAME4', 'postgres'),
            'password' => env('DB_PASSWORD4', 'Summitscl'),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'cluster' => false,

        'default' => [
            'host' => env('REDIS_HOST', 'localhost'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
