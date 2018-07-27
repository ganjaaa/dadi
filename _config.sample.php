<?php

define('DEBUG', true);

$settings = [
    'addContentLengthHeader' => false,
    'settings' => [
        'displayErrorDetails' => DEBUG,
        'pdo' => [
            'type' => 'mysql',
            'host' => 'localhost',
            'dbname' => 'dadi',
            'user' => 'dadi',
            'pass' => 'someSecret',
        ],
        'smarty' => [
            'debugging' => DEBUG,
            'caching' => false,
            'templateDir' => __DIR__ . '/templates',
            'compileDir' => __DIR__ . '/templates_compile',
            'cacheDir' => __DIR__ . '/templates_cache',
            'pluginDir' => __DIR__ . '/templates_plugins',
        ],
        'collaboration' => [
            'type' => 'firepad', // firepad or codimd
            'firepad' => [
                'apiKey' => "someKey",
                'authDomain' => "someDomain.firebaseapp.com",
                'databaseURL' => "https://someDomain.firebaseio.com",
                'projectId' => "someDomain",
                'storageBucket' => "someDomain.appspot.com",
                'messagingSenderId' => "someNumericId",
            ],
            'codiframe' => ''
        ],
        'baseurl' => 'https://URL.de',
        'salt' => 'someSalt',
    ],
];
