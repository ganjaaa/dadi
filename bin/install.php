#!/usr/bin/env php
<?php
(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('cli only');
(!is_dir(__DIR__ . '/../vendor') || !file_exists(__DIR__ . '/../vendor/autoload.php')) && die('Please run "composer install" @ main dir');

require_once __DIR__ . '/../vendor/autoload.php';
$config = __DIR__ . '/../_config.php';

$installer = new \DND\Installer\MightyInstaller($config);
$installer->install();
