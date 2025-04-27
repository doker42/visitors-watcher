<?php

return [

    'admin_prefix' => env('ADMIN_PREFIX', 'adm'),

    'middleware' => [
        'visitors' => [
            'enabled' => true,
        ],
        'throttle_404' => [
            'enabled' => false,
            'attempts' => 20,
            'sleep_time' => 60 * 1,
        ],
        'throttle_404_with_limit' => [
            'enabled' => false,
            'attempts' => 10,
            'sleep_time' => 60 * 60,
        ],
    ],

    'bad_request' => [
        'sleep_time' => 60 * 1,
    ],

    'banned' => [
        'sleep_time' => 60 * 2,
    ],

    'bad_agents' => [
        'curl',
        'sqlmap',
        'python',
        'nmap',
        'scanner',
        'libwww',
        'go-http-client'
    ],

    'bad_paths' => [
        'wp-admin',
        'cms',
        'sdk',
        'whoami',
        'wordpress',
        'config',
        'application',
        'secret',
        'db.ini',
        'secure',
        'wp-config',
        'phpinfo',
        'administrator',
        'cgi-bin',
        'laravel',
        'package',
        'openapi',
        'phpmyadmin',
        'wp-login',
        'admin.php',
        'xmlrpc',
        'env',
        '.env',
        '.git',
        '.bash',
        'openapi',
        'backup',
        'sql',
        'var',
        'sitemap',
        'query',
    ],

];
