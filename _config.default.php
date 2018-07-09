<?php

define('DEBUG', true);

$settings = [
    'displayErrorDetails' => true,
    'addContentLengthHeader' => false,
    'settings' => [
        'pdo' => [
            'type' => 'mysql',
            'host' => 'localhost',
            'dbname' => 'dnd',
            'user' => 'dnd',
            'pass' => 'password',
        ],
        'smarty' => [
            'debugging' => true,
            'caching' => false,
            'templateDir' => __DIR__ . '/templates',
            'compileDir' => __DIR__ . '/templates_compile',
            'cacheDir' => __DIR__ . '/templates_cache',
            'pluginDir' => __DIR__ . '/templates_plugins',
        ],
        'baseurl' => 'https://wasmitleder.de',
        'salt' => 'ni8989(en8"§n48f8cm"/$nBHJSDDncuU',
    ]
];
