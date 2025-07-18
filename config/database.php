<?php

use Illuminate\Support\Str;

return [

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

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        // Koneksi Default Laravel (Warehouse)
        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
        
        // Koneksi INLISLite Lokal (XAMPP)
        'mysql_inlislite_local' => [
            'driver' => 'mysql',
            'host' => env('DB_INLIS_LOCAL_HOST', '127.0.0.1'),
            'port' => env('DB_INLIS_LOCAL_PORT', '3309'),
            'database' => env('DB_INLIS_LOCAL_DATABASE'),
            'username' => env('DB_INLIS_LOCAL_USERNAME'),
            'password' => env('DB_INLIS_LOCAL_PASSWORD'),
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? [
                PDO::ATTR_TIMEOUT => 3, // max tunggu 3 detik
            ] : [],
        ],

        // Koneksi INLISLite Online (via SSH Tunnel)
        'mysql_inlislite_ssh' => [
            'driver' => 'mysql',
            'host' => env('DB_INLIS_ONLINE_HOST', '127.0.0.1'),
            'port' => env('DB_INLIS_ONLINE_PORT', '3306'),
            'database' => env('DB_INLIS_ONLINE_DATABASE'),
            'username' => env('DB_INLIS_ONLINE_USERNAME'),
            'password' => env('DB_INLIS_ONLINE_PASSWORD'),
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
            'options' => [
                'ssh' => [
                    'host' => env('DB_INLIS_SSH_HOST'),
                    'username' => env('DB_INLIS_SSH_USER'),
                    'password' => env('DB_INLIS_SSH_PASSWORD'),
                ],
            ],
        ],

        // Koneksi eLib Lokal (SSMS)
        'sqlsrv_elib_local' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_ELIB_LOCAL_HOST', 'localhost\\SQLEXPRESS'),
            'port' => env('DB_ELIB_LOCAL_PORT', '1433'),
            'database' => env('DB_ELIB_LOCAL_DATABASE'),
            'username' => env('DB_ELIB_LOCAL_USERNAME'),
            'password' => env('DB_ELIB_LOCAL_PASSWORD'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

        // Koneksi eLib Online (Jaringan Kampus)
        'sqlsrv_elib_remote' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_ELIB_REMOTE_HOST'),
            'port' => env('DB_ELIB_REMOTE_PORT', '1433'),
            'database' => env('DB_ELIB_REMOTE_DATABASE'),
            'username' => env('DB_ELIB_REMOTE_USERNAME'),
            'password' => env('DB_ELIB_REMOTE_PASSWORD'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'options' => [
                'ConnectionTimeout' => 3, // max tunggu 3 detik juga
                'QueryTimeout' => 3,
            ],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
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
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
