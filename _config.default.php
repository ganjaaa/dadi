<?php

define('DEBUG', false);

$settings = [
    'addContentLengthHeader' => false,
    'settings' => [
        'displayErrorDetails' => true,
        'pdo' => [
            'type' => 'mysql',
            'host' => '127.0.0.1',
            'dbname' => 'ohmydadi',
            'user' => 'username',
            'pass' => 'password',
        ],
        'smarty' => [
            'debugging' => false,
            'caching' => false,
            'templateDir' => __DIR__ . '/templates',
            'compileDir' => __DIR__ . '/templates_compile',
            'cacheDir' => __DIR__ . '/templates_cache',
            'pluginDir' => __DIR__ . '/templates_plugins',
        ],
        'baseurl' => 'https://foo.bar',
        'salt' => 'S0meRad0mSh!t',
    ]
];
