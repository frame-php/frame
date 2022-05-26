<?php

const PROVIDER_DEFAULT = 'default';
const PROVIDER_MYSQL = 'mysql';

return [
    'default' => 'default_mysql_connection',
    'connections' => [
        'default_mysql_connection' => [
            'provider' => PROVIDER_MYSQL,
            'config' => [
                'host' => 'frame-mysql',
                'port' => 3036,
                'user' => 'framework',
                'pass' => 'framework',
                'base' => 'framework',
            ],
        ],
    ],
];
