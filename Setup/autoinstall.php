<?php

(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('cli only');
(!is_dir(__DIR__ . '/../vendor') || !file_exists(__DIR__ . '/../vendor/autoload.php')) && die('Please run "composer install" @ main dir');

echo '---------------------------------------------' . PHP_EOL;
echo '- WARNING' . PHP_EOL;
echo '- these installer override all Data in the Database and ist only for new Installations!' . PHP_EOL;
echo '- for updates use the update.php file !' . PHP_EOL;
echo '---------------------------------------------' . PHP_EOL;
echo PHP_EOL;
echo PHP_EOL;
echo 'Continue Install [y/N]';
$contin = stream_get_line(STDIN, 1024, PHP_EOL);
if (strtolower($contin) != 'y') {
    var_dump($contin);
    var_dump($contin != 'y');
    die('Exit installer' . PHP_EOL);
}


if (!file_exists(__DIR__ . '/../_config.php')) {
    echo "Erschaffe _config.php." . PHP_EOL;
    echo PHP_EOL;

    echo "MySQL Host: ";
    $a = stream_get_line(STDIN, 1024, PHP_EOL);
    echo "MySQL Dankenbank: ";
    $b = stream_get_line(STDIN, 1024, PHP_EOL);
    echo "MySQL Username: ";
    $c = stream_get_line(STDIN, 1024, PHP_EOL);
    echo "MySQL Password: ";
    $d = stream_get_line(STDIN, 1024, PHP_EOL);
    echo "Basis URL (eg. https://wasmitleder.de ): ";
    $e = stream_get_line(STDIN, 1024, PHP_EOL);
    echo "Salt (leave empty for Random Value): ";
    $f = stream_get_line(STDIN, 1024, PHP_EOL);
    if (empty($f)) {
        $bytes = random_bytes(20);
        $f = bin2hex($bytes);
    }

    $cfg = '<?php' . PHP_EOL;
    $cfg = 'define(\'DEBUG\', true);' . PHP_EOL;
    $cfg = '' . PHP_EOL;
    $cfg = '$settings = [' . PHP_EOL;
    $cfg = '    \'addContentLengthHeader\' => false,' . PHP_EOL;
    $cfg = '    \'settings\' => [' . PHP_EOL;
    $cfg = '        \'displayErrorDetails\' => DEBUG,' . PHP_EOL;
    $cfg = '        \'pdo\' => [' . PHP_EOL;
    $cfg = '            \'type\' => \'mysql\',' . PHP_EOL;
    $cfg = '            \'host\' => \'' . addslashes($a) . '\',' . PHP_EOL;
    $cfg = '            \'dbname\' => \'' . addslashes($b) . '\',' . PHP_EOL;
    $cfg = '            \'user\' => \'' . addslashes($c) . '\',' . PHP_EOL;
    $cfg = '            \'pass\' => \'' . addslashes($d) . '\',' . PHP_EOL;
    $cfg = '        ],' . PHP_EOL;
    $cfg = '        \'smarty\' => [' . PHP_EOL;
    $cfg = '            \'debugging\' => DEBUG,' . PHP_EOL;
    $cfg = '            \'caching\' => false,' . PHP_EOL;
    $cfg = '            \'templateDir\' => __DIR__ . \'/templates\',' . PHP_EOL;
    $cfg = '            \'compileDir\' => __DIR__ . \'/templates_compile\',' . PHP_EOL;
    $cfg = '            \'cacheDir\' => __DIR__ . \'/templates_cache\',' . PHP_EOL;
    $cfg = '            \'pluginDir\' => __DIR__ . \'/templates_plugins\',' . PHP_EOL;
    $cfg = '        ],' . PHP_EOL;
    $cfg = '        \'collaboration\' => [' . PHP_EOL;
    $cfg = '            \'type\' => \'firepad\', // firepad or codimd' . PHP_EOL;
    $cfg = '            \'firepad\' => [' . PHP_EOL;
    $cfg = '                \'apiKey\' => \'\',' . PHP_EOL;
    $cfg = '                \'authDomain\' => \'\',' . PHP_EOL;
    $cfg = '                \'databaseURL\' => \'\',' . PHP_EOL;
    $cfg = '                \'projectId\' => \'\',' . PHP_EOL;
    $cfg = '                \'storageBucket\' => \'\',' . PHP_EOL;
    $cfg = '                \'messagingSenderId\' => \'\',' . PHP_EOL;
    $cfg = '            ],' . PHP_EOL;
    $cfg = '            \'codiframe\' => \'\'' . PHP_EOL;
    $cfg = '        ],' . PHP_EOL;
    $cfg = '        \'baseurl\' => \'' . addslashes($e) . '\',' . PHP_EOL;
    $cfg = '        \'salt\' => \'' . addslashes($f) . '\',' . PHP_EOL;
    $cfg = '    ],' . PHP_EOL;
    $cfg = '];' . PHP_EOL;

    file_put_contents(__DIR__ . '/../_config.php', $cfg);
}

require_once __DIR__ . '/../_config.php';
require_once __DIR__ . '/../vendor/autoload.php';

echo PHP_EOL;
echo 'Viel Magie usw ....' . PHP_EOL;
$cv = new DND\Core\MightyCreator();
foreach (glob(__DIR__ . '/xml/*.xml') as $filename) {
    $cv->loadXML($filename);
    $cv->setT_class(__DIR__ . '/../lib/Objects');
    $cv->setT_sql(__DIR__ . '/sql');
    $cv->setT_templates(__DIR__ . '/../templates/forms');
    $cv->setT_controller(__DIR__ . '/../lib/Core');
    $cv->info();
    $cv->create();
}
$cv->writeController();
$cv->finish();

$db = $settings['settings']['pdo'];
$pdo = new PDO($db['type'] . ":host=" . $db['host'] . ";dbname=" . $db['dbname'], $db['user'], $db['pass'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

foreach (glob(__DIR__ . '/sql/*.sql') as $filename) {
    $commands = file_get_contents($filename);
    $pdo->query($commands);
    echo $pdo->errorCode() . PHP_EOL;
}
$view = "CREATE VIEW `view_inventory` AS select `dnd_inventory`.`id` AS `id`,`dnd_inventory`.`characterId` AS `characterId`,`dnd_inventory`.`itemId` AS `itemId`,`dnd_inventory`.`amount` AS `amount`,`dnd_inventory`.`knowledge` AS `knowledge`,`dnd_item`.`name` AS `name`,`dnd_item`.`description` AS `description`,`dnd_item`.`weight` AS `weight`,`dnd_item`.`priceCP` AS `priceCP`,`dnd_item`.`priceSP` AS `priceSP`,`dnd_item`.`priceEP` AS `priceEP`,`dnd_item`.`priceGP` AS `priceGP`,`dnd_item`.`pricePP` AS `pricePP`,`dnd_item`.`type` AS `type`,`dnd_item`.`rarity` AS `rarity`,`dnd_item`.`ac` AS `ac`,`dnd_item`.`strength` AS `strength`,`dnd_item`.`stealth` AS `stealth`,`dnd_item`.`modifier` AS `modifier`,`dnd_item`.`roll` AS `roll`,`dnd_item`.`dmg1` AS `dmg1`,`dnd_item`.`dmg2` AS `dmg2`,`dnd_item`.`dmgType` AS `dmgType`,`dnd_item`.`property` AS `property`,`dnd_item`.`range` AS `range`,`dnd_item`.`wearable` AS `wearable`,`dnd_item`.`cursed` AS `cursed`,(select count(0) from `dnd_user` where ((`dnd_user`.`id` = `dnd_inventory`.`characterId`) and ((`dnd_user`.`equipmentQuiver1` = `dnd_inventory`.`itemId`) or (`dnd_user`.`equipmentQuiver2` = `dnd_inventory`.`itemId`) or (`dnd_user`.`equipmentQuiver3` = `dnd_inventory`.`itemId`) or (`dnd_user`.`equipmentHelmet` = `dnd_inventory`.`itemId`) or (`dnd_user`.`equipmentCape` = `dnd_inventory`.`itemId`) or (`dnd_user`.`equipmentNecklace` = `dnd_inventory`.`itemId`) or (`dnd_user`.`equipmentWeapon1` = `dnd_inventory`.`itemId`) or (`dnd_user`.`equipmentWeapon2` = `dnd_inventory`.`itemId`) or (`dnd_user`.`equipmentWeapon3` = `dnd_inventory`.`itemId`) or (`dnd_user`.`equipmentOffWeapon` = `dnd_inventory`.`itemId`) or (`dnd_user`.`equipmentGloves` = `dnd_inventory`.`itemId`) or (`dnd_user`.`equipmentArmor` = `dnd_inventory`.`itemId`) or (`dnd_user`.`equipmentObject` = `dnd_inventory`.`itemId`) or (`dnd_user`.`equipmentBelt` = `dnd_inventory`.`itemId`) or (`dnd_user`.`equipmentBoots` = `dnd_inventory`.`itemId`) or (`dnd_user`.`equipmentRing1` = `dnd_inventory`.`itemId`) or (`dnd_user`.`equipmentRing2` = `dnd_inventory`.`itemId`)))) AS `equipt` from (`dnd_inventory` left join `dnd_item` on((`dnd_item`.`id` = `dnd_inventory`.`itemId`)));";
$pdo->query($view);

echo "Admin Email: ";
$mail = stream_get_line(STDIN, 1024, PHP_EOL);
echo "Admin Password: ";
$pass = stream_get_line(STDIN, 1024, PHP_EOL);
$pass = \DND\Helper\CryptoHelper::Crypt($pass, 50, $settings['settings']['salt']);


$user = new DND\Objects\User();
$user
        ->setMail($mail)
        ->setPassword($pass)
        ->setActive(1)
        ->setGm(1)
        ->setMoney('99;99;99;99;99')
        ->setSkills('1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1')
        ->setSavingthrows('20;20;20;20;20;20')
        ->setHp('900;900;0')
        ->setAc(999)
        ->setLevel(99)
        ->setExp(0)
        ->setInspiration(0)
        ->setProficiency(0)
        ->setEnvironmentid(0);
$cc = new \DND\Core\ObjectHandler($pdo);
$cc->addUser($user);

