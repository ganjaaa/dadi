<?php

(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('cli only');
require_once __DIR__ . '/../vendor/autoload.php';
/* * * Config Start ** */

$xml_dir = __DIR__ . '/xml';
$sql_dir = __DIR__ . '/sql';
$classes_dir = __DIR__ . '/../lib/Objects';
$controller_dir = __DIR__ . '/../lib/Core';
$template_dir = __DIR__ . '/../templates/forms';


/* * * Config End ** */
$cv = new DND\Core\MightyCreator();
foreach (glob($xml_dir . '/*.xml') as $filename) {
    $cv->loadXML($filename);
    $cv->setT_class($classes_dir);
    $cv->setT_sql($sql_dir);
    $cv->setT_templates($template_dir);
    $cv->setT_controller($controller_dir);
    $cv->info();
    $cv->create();
}
$cv->writeController();
$cv->finish();
