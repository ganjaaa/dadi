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

$docker = (isset($_ENV["DADI_DOCKER"]) && !empty($_ENV["DADI_DOCKER"]) && $_ENV["DADI_DOCKER"] == 'yes') ? true : false;

$new_install = !file_exists(__DIR__ . '/../_config.php') ? true : false;
if (!$docker) {
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
}

if (!file_exists(__DIR__ . '/../_config.php')) {
    echo PHP_EOL;
    echo PHP_EOL;
    echo "- Creating _config.php." . PHP_EOL;
    echo PHP_EOL;

    echo "- MySQL Host [localhost] ";
    if ($docker) {
        echo PHP_EOL;
        $a = isset($_ENV["DADI_MYSQL_HOST"]) && !empty($_ENV["DADI_MYSQL_HOST"]) ? $_ENV["DADI_MYSQL_HOST"] : 'localhost';
    } else {
        $a = stream_get_line(STDIN, 1024, PHP_EOL);
        if (empty($a)) {
            $a = 'localhost';
        }
    }
    echo "- MySQL Dankenbank [dadi]: ";
    if ($docker) {
        echo PHP_EOL;
        $b = isset($_ENV["MYSQL_DATABASE"]) && !empty($_ENV["MYSQL_DATABASE"]) ? $_ENV["MYSQL_DATABASE"] : 'localhost';
    } else {
        $b = stream_get_line(STDIN, 1024, PHP_EOL);
        if (empty($b)) {
            $b = 'dadi';
        }
    }
    echo "- MySQL Username [dadi]: ";
    if ($docker) {
        echo PHP_EOL;
        $c = isset($_ENV["MYSQL_USER"]) && !empty($_ENV["MYSQL_USER"]) ? $_ENV["MYSQL_USER"] : 'dadi';
    } else {
        $c = stream_get_line(STDIN, 1024, PHP_EOL);
        if (empty($c)) {
            $c = 'dadi';
        }
    }
    echo "- MySQL Password [dadi]: ";
    if ($docker) {
        echo PHP_EOL;
        $d = isset($_ENV["MYSQL_PASSWORD"]) && !empty($_ENV["MYSQL_PASSWORD"]) ? $_ENV["MYSQL_PASSWORD"] : 'dadi';
    } else {
        $d = stream_get_line(STDIN, 1024, PHP_EOL);
        if (empty($d)) {
            $d = 'dadi';
        }
    }
    echo "- Basis URL [http://localhost]: ";
    if ($docker) {
        echo PHP_EOL;
        $e = isset($_ENV["DADI_BASEURL"]) && !empty($_ENV["DADI_BASEURL"]) ? $_ENV["DADI_BASEURL"] : 'http://localhost';
    } else {
        $e = stream_get_line(STDIN, 1024, PHP_EOL);
        if (empty($e)) {
            $e = 'http://localhost';
        }
    }
    echo "- Salt (leave empty for Random Value): ";
    if ($docker) {
        echo PHP_EOL;
        $f = isset($_ENV["DADI_SALT"]) && !empty($_ENV["DADI_SALT"]) ? $_ENV["DADI_SALT"] : bin2hex(random_bytes(20));
    } else {
        $f = stream_get_line(STDIN, 1024, PHP_EOL);
        if (empty($f)) {
            $bytes = random_bytes(20);
            $f = bin2hex($bytes);
        }
    }

    $cfg = '<?php' . PHP_EOL;
    $cfg .= 'define(\'DEBUG\', ' . (isset($_ENV["DADI_DEBUG"]) && !empty($_ENV["DADI_DEBUG"] && $_ENV["DADI_DEBUG"] == 'yes') ? 'TRUE' : 'FALSE') . ');' . PHP_EOL;
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
        echo "Code: " . $pdo->errorCode() . PHP_EOL;
        #die('- Installer aborted' . PHP_EOL);
    }

    echo "- Admin Email [admin@dadi.de]: ";
    if ($docker) {
        echo PHP_EOL;
        $mail = isset($_ENV["DADI_ADMIN_MAIL"]) && !empty($_ENV["DADI_ADMIN_MAIL"]) ? $_ENV["DADI_ADMIN_MAIL"] : 'admin@dadi.de';
    } else {
        $mail = stream_get_line(STDIN, 1024, PHP_EOL);
        if (empty($mail)) {
            $mail = 'admin@dadi.de';
        }
    }
    echo "- Admin Password [RANDOM]: ";
    if ($docker) {
        echo PHP_EOL;
        $mail = isset($_ENV["DADI_ADMIN_PASSWORD"]) && !empty($_ENV["DADI_ADMIN_PASSWORD"]) ? $_ENV["DADI_ADMIN_PASSWORD"] : \DND\Helper\CryptoHelper::getRandomString(16);
    } else {
        $pass = stream_get_line(STDIN, 1024, PHP_EOL);
        if (empty($pass)) {
            $pass = \DND\Helper\CryptoHelper::getRandomString(16);
            echo "- Save it: " . $pass . PHP_EOL;
        }
    }
    $pass = \DND\Helper\CryptoHelper::Crypt($pass, 50, $settings['settings']['salt']);

    $acc = new \DND\Objects\Account();
    $acc
            ->setActive(1)
            ->setMail($mail)
            ->setPassword($pass)
            ->setToken(DND\Helper\CryptoHelper::getSecureString(50))
            ->setSectoken(DND\Helper\CryptoHelper::getSecureString(50))
            ->setLastlogin('0000-00-00 00:00:00')
            ->setGm(1);

    $cc = new \DND\Core\ObjectHandler($pdo);
    $cc->addAccount($acc);
} else {
    
}
echo 'Well Done :)' . PHP_EOL;
