<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    public string $defaultGroup = 'default';

    public array $default = [
        'DSN'          => '',
        'hostname'     => '',
        'username'     => '',
        'password'     => '',
        'database'     => '',
        'DBDriver'     => 'MySQLi',
        'DBPrefix'     => '',
        'pConnect'     => false,
        'DBDebug'      => true,
        'charset'      => 'utf8mb4',
        'DBCollat'     => 'utf8mb4_general_ci',
        'swapPre'      => '',
        'encrypt'      => false,
        'compress'     => false,
        'strictOn'     => false,
        'failover'     => [],
        'port'         => 3306,
        'numberNative' => false,
        'foundRows'    => false,
        'dateFormat'   => [
            'date'     => 'Y-m-d',
            'datetime' => 'Y-m-d H:i:s',
            'time'     => 'H:i:s',
        ],
    ];

    public array $tests = [
        'DSN'         => '',
        'hostname'    => '127.0.0.1',
        'username'    => '',
        'password'    => '',
        'database'    => ':memory:',
        'DBDriver'    => 'SQLite3',
        'DBPrefix'    => 'db_',
        'pConnect'    => false,
        'DBDebug'     => true,
        'charset'     => 'utf8',
        'DBCollat'    => '',
        'swapPre'     => '',
        'encrypt'     => false,
        'compress'    => false,
        'strictOn'    => false,
        'failover'    => [],
        'port'        => 3306,
        'foreignKeys' => true,
        'busyTimeout' => 1000,
        'dateFormat'  => [
            'date'     => 'Y-m-d',
            'datetime' => 'Y-m-d H:i:s',
            'time'     => 'H:i:s',
        ],
    ];

    public function __construct()
    {
        parent::__construct();

        if (ENVIRONMENT === 'production') {
            $this->default = [
                'DSN'          => '',
                'hostname'     => getenv('database.production.hostname'),
                'username'     => getenv('database.production.username'),
                'password'     => getenv('database.production.password'),
                'database'     => getenv('database.production.database'),
                'DBDriver'     => getenv('database.production.DBDriver'),
                'DBPrefix'     => '',
                'pConnect'     => false,
                'DBDebug'      => true,
                'charset'      => 'utf8mb4',
                'DBCollat'     => 'utf8mb4_general_ci',
                'swapPre'      => '',
                'encrypt'      => false,
                'compress'     => false,
                'strictOn'     => false,
                'failover'     => [],
                'port'         => 3306,
                'numberNative' => false,
                'foundRows'    => false,
                'dateFormat'   => [
                    'date'     => 'Y-m-d',
                    'datetime' => 'Y-m-d H:i:s',
                    'time'     => 'H:i:s',
                ],
            ];
        } else {
            $this->default = [
                'DSN'          => '',
                'hostname'     => getenv('database.default.hostname'),
                'username'     => getenv('database.default.username'),
                'password'     => getenv('database.default.password'),
                'database'     => getenv('database.default.database'),
                'DBDriver'     => getenv('database.default.DBDriver'),
                'DBPrefix'     => '',
                'pConnect'     => false,
                'DBDebug'      => true,
                'charset'      => 'utf8mb4',
                'DBCollat'     => 'utf8mb4_general_ci',
                'swapPre'      => '',
                'encrypt'      => false,
                'compress'     => false,
                'strictOn'     => false,
                'failover'     => [],
                'port'         => 3306,
                'numberNative' => false,
                'foundRows'    => false,
                'dateFormat'   => [
                    'date'     => 'Y-m-d',
                    'datetime' => 'Y-m-d H:i:s',
                    'time'     => 'H:i:s',
                ],
            ];
        }

        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}
