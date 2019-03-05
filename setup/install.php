<?php

(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('cli only');
(!is_dir(__DIR__ . '/../vendor') || !file_exists(__DIR__ . '/../vendor/autoload.php')) && die('Please run "composer install" @ main dir');


echo 'DDDDDDDDDDDDD                         DDDDDDDDDDDDD      IIIIIIIIII' . PHP_EOL;
echo 'D::::::::::::DDD                      D::::::::::::DDD   I::::::::I' . PHP_EOL;
echo 'D:::::::::::::::DD                    D:::::::::::::::DD I::::::::I' . PHP_EOL;
echo 'DDD:::::DDDDD:::::D                   DDD:::::DDDDD:::::DII::::::II' . PHP_EOL;
echo '  D:::::D    D:::::D  aaaaaaaaaaaaa     D:::::D    D:::::D I::::I  ' . PHP_EOL;
echo '  D:::::D     D:::::D a::::::::::::a    D:::::D     D:::::DI::::I  ' . PHP_EOL;
echo '  D:::::D     D:::::D aaaaaaaaa:::::a   D:::::D     D:::::DI::::I  ' . PHP_EOL;
echo '  D:::::D     D:::::D          a::::a   D:::::D     D:::::DI::::I  ' . PHP_EOL;
echo '  D:::::D     D:::::D   aaaaaaa:::::a   D:::::D     D:::::DI::::I  ' . PHP_EOL;
echo '  D:::::D     D:::::D aa::::::::::::a   D:::::D     D:::::DI::::I  ' . PHP_EOL;
echo '  D:::::D     D:::::Da::::aaaa::::::a   D:::::D     D:::::DI::::I  ' . PHP_EOL;
echo '  D:::::D    D:::::Da::::a    a:::::a   D:::::D    D:::::D I::::I  ' . PHP_EOL;
echo 'DDD:::::DDDDD:::::D a::::a    a:::::a DDD:::::DDDDD:::::DII::::::II' . PHP_EOL;
echo 'D:::::::::::::::DD  a:::::aaaa::::::a D:::::::::::::::DD I::::::::I' . PHP_EOL;
echo 'D::::::::::::DDD     a::::::::::aa:::aD::::::::::::DDD   I::::::::I' . PHP_EOL;
echo 'DDDDDDDDDDDDD         aaaaaaaaaa  aaaaDDDDDDDDDDDDD      IIIIIIIIII' . PHP_EOL;
echo '-------------------------------------------------------------------' . PHP_EOL;
echo PHP_EOL;
echo PHP_EOL;

$new_install = !file_exists(__DIR__ . '/../_config.php') ? true : false;
if ($new_install) {
    echo '- Detecting no "_config.php"' . PHP_EOL;
    echo '- Do you want to install a new Application? [y/N]';
    $contin = stream_get_line(STDIN, 1024, PHP_EOL);
    if (strtolower($contin) != 'y') {
        die('- Exit installer' . PHP_EOL);
    }
} else {
    echo '- Detecting "_config.php"' . PHP_EOL;
    echo '- Do you want to a update? [y/N]';
    $contin = stream_get_line(STDIN, 1024, PHP_EOL);
    if (strtolower($contin) != 'y') {
        die('- Exit installer' . PHP_EOL);
    }
}

if (!file_exists(__DIR__ . '/../_config.php')) {
    echo PHP_EOL;
    echo PHP_EOL;
    echo "- Creating _config.php." . PHP_EOL;
    echo PHP_EOL;

    echo "- MySQL Host: ";
    $a = stream_get_line(STDIN, 1024, PHP_EOL);
    echo "- MySQL Dankenbank: ";
    $b = stream_get_line(STDIN, 1024, PHP_EOL);
    echo "- MySQL Username: ";
    $c = stream_get_line(STDIN, 1024, PHP_EOL);
    echo "- MySQL Password: ";
    $d = stream_get_line(STDIN, 1024, PHP_EOL);
    echo "- Basis URL (eg. https://wasmitleder.de ): ";
    $e = stream_get_line(STDIN, 1024, PHP_EOL);
    echo "- Salt (leave empty for Random Value): ";
    $f = stream_get_line(STDIN, 1024, PHP_EOL);
    if (empty($f)) {
        $bytes = random_bytes(20);
        $f = bin2hex($bytes);
    }

    $cfg = '<?php' . PHP_EOL;
    $cfg .= 'define(\'DEBUG\', false);' . PHP_EOL;
    $cfg .= '' . PHP_EOL;
    $cfg .= '$settings = [' . PHP_EOL;
    $cfg .= '    \'addContentLengthHeader\' => false,' . PHP_EOL;
    $cfg .= '    \'settings\' => [' . PHP_EOL;
    $cfg .= '        \'displayErrorDetails\' => DEBUG,' . PHP_EOL;
    $cfg .= '        \'pdo\' => [' . PHP_EOL;
    $cfg .= '            \'type\' => \'mysql\',' . PHP_EOL;
    $cfg .= '            \'host\' => \'' . addslashes($a) . '\',' . PHP_EOL;
    $cfg .= '            \'dbname\' => \'' . addslashes($b) . '\',' . PHP_EOL;
    $cfg .= '            \'user\' => \'' . addslashes($c) . '\',' . PHP_EOL;
    $cfg .= '            \'pass\' => \'' . addslashes($d) . '\',' . PHP_EOL;
    $cfg .= '        ],' . PHP_EOL;
    $cfg .= '        \'smarty\' => [' . PHP_EOL;
    $cfg .= '            \'debugging\' => DEBUG,' . PHP_EOL;
    $cfg .= '            \'caching\' => false,' . PHP_EOL;
    $cfg .= '            \'templateDir\' => __DIR__ . \'/templates\',' . PHP_EOL;
    $cfg .= '            \'compileDir\' => __DIR__ . \'/templates_compile\',' . PHP_EOL;
    $cfg .= '            \'cacheDir\' => __DIR__ . \'/templates_cache\',' . PHP_EOL;
    $cfg .= '            \'pluginDir\' => __DIR__ . \'/templates_plugins\',' . PHP_EOL;
    $cfg .= '        ],' . PHP_EOL;
    $cfg .= '        \'collaboration\' => [' . PHP_EOL;
    $cfg .= '            \'type\' => \'firepad\', // firepad or codimd' . PHP_EOL;
    $cfg .= '            \'firepad\' => [' . PHP_EOL;
    $cfg .= '                \'apiKey\' => \'\',' . PHP_EOL;
    $cfg .= '                \'authDomain\' => \'\',' . PHP_EOL;
    $cfg .= '                \'databaseURL\' => \'\',' . PHP_EOL;
    $cfg .= '                \'projectId\' => \'\',' . PHP_EOL;
    $cfg .= '                \'storageBucket\' => \'\',' . PHP_EOL;
    $cfg .= '                \'messagingSenderId\' => \'\',' . PHP_EOL;
    $cfg .= '            ],' . PHP_EOL;
    $cfg .= '            \'codiframe\' => \'\'' . PHP_EOL;
    $cfg .= '        ],' . PHP_EOL;
    $cfg .= '        \'baseurl\' => \'' . addslashes($e) . '\',' . PHP_EOL;
    $cfg .= '        \'salt\' => \'' . addslashes($f) . '\',' . PHP_EOL;
    $cfg .= '    ],' . PHP_EOL;
    $cfg .= '];' . PHP_EOL;

    file_put_contents(__DIR__ . '/../_config.php', $cfg);
}

require_once __DIR__ . '/../_config.php';
require_once __DIR__ . '/../vendor/autoload.php';

$db = $settings['settings']['pdo'];
$pdo = new PDO($db['type'] . ":host=" . $db['host'] . ";dbname=" . $db['dbname'], $db['user'], $db['pass'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);

if ($new_install) {
    echo '- Setup Database ....' . PHP_EOL;

    foreach (glob(__DIR__ . '/sql/*.sql') as $filename) {
        $commands = file_get_contents($filename);
        $pdo->exec($commands);
        echo $pdo->errorCode() . PHP_EOL;
        die('- Installer aborted' . PHP_EOL);
    }

    echo "- Admin Email: ";
    $mail = stream_get_line(STDIN, 1024, PHP_EOL);
    echo "- Admin Password: ";
    $pass = stream_get_line(STDIN, 1024, PHP_EOL);
    $pass = \DND\Helper\CryptoHelper::Crypt($pass, 50, $settings['settings']['salt']);

    $acc = new DND\Objects\Account();
    $acc
            ->setActive(1)
            ->setMail($mail)
            ->setPassword($pass)
            ->setToken(DND\Helper\CryptoHelper::getSecureString(50))
            ->setSectoken(DND\Helper\CryptoHelper::getSecureString(50))
            ->setLastlogin('0000-00-00 00:00:00')
            ->setGm(1) ;

    $cc = new \DND\Core\ObjectHandler($pdo);
    $cc->addAccount($acc);
}else{
    
}