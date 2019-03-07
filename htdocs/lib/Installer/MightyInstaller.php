<?php

namespace DND\Installer;

class MightyInstaller {

    private $config_path;
    private $mysql_host;
    private $mysql_db;
    private $mysql_user;
    private $mysql_pass;
    private $base_url;
    private $base_salt;
    private $admin_mail;
    private $admin_pass;

    public function __construct($configPath) {
        $this->config_path = $configPath;
        $this->mysql_host = 'localhost';
        $this->mysql_db = 'dadi';
        $this->mysql_user = 'dadi';
        $this->mysql_pass = 'dadi';
        $this->base_url = 'http://localhost';
        $this->base_salt = '';
        $this->admin_mail = 'admin@localhost.de';
        $this->admin_pass = '';
    }

    public function install() {
        $cconfig = $this->_checkConfig();
        $cdocker = $this->_checkDocker();

        $this->_writeHead();
        if ($cconfig === NULL) {
            $this->_writeExit("Can't continue install: '_config.php' is present but not writable. Exit installer.");
            return;
        }

        if ($cdocker) {
            if ($cconfig === true) {
                $this->_writeMsg("Found '_config.php'.");
                if ($this->_checkDockerReinstall() === false) {
                    $this->_writeExit("Exit installer.");
                    return;
                }
            }
            $this->_autoInstall();
        } else {
            if ($cconfig === true) {
                $this->_writeMsg("Found '_config.php'. WARNING: If you continue all data would be deleted!");
                $this->_writeMsg("Do you want to reinstall the Application [y/N] ", '');
                $x = stream_get_line(STDIN, 1024, PHP_EOL);
                if (strtolower(trim($x)) != 'y') {
                    $this->_writeExit("Exit installer.");
                    return;
                }
            }
            $this->_manualInstall();
        }
    }

    public function update() {
        $this->_writeHead();
    }

    private function _checkDocker() {
        return (isset($_ENV["DADI_DOCKER"]) && !empty($_ENV["DADI_DOCKER"]) && $_ENV["DADI_DOCKER"] == 'yes') ? true : false;
    }

    private function _checkDockerReinstall() {
        return (isset($_ENV["DADI_REINSTALL"]) && !empty($_ENV["DADI_REINSTALL"]) && $_ENV["DADI_REINSTALL"] == 'yes') ? true : false;
    }

    private function _checkConfig() {
        if (!empty($this->config_path) && is_file($this->config_path)) {
            if (is_writable($this->config_path)) {
                return TRUE;
            } else {
                return NULL;
            }
        }
        return FALSE;
    }

    private function _manualInstall() {
        $this->_writeMsg("MySQL Host [" . $this->mysql_host . "]: ", '');
        $x = stream_get_line(STDIN, 1024, PHP_EOL);
        $this->mysql_host = !empty($x) ? trim($x) : $this->mysql_host;

        $this->_writeMsg("MySQL Dankenbank [" . $this->mysql_db . "]: ", '');
        $x = stream_get_line(STDIN, 1024, PHP_EOL);
        $this->mysql_db = !empty($x) ? trim($x) : $this->mysql_db;

        $this->_writeMsg("MySQL Username [" . $this->mysql_user . "]: ", '');
        $x = stream_get_line(STDIN, 1024, PHP_EOL);
        $this->mysql_user = !empty($x) ? trim($x) : $this->mysql_user;

        $this->_writeMsg("MySQL Password [" . $this->mysql_pass . "]: ", '');
        $x = stream_get_line(STDIN, 1024, PHP_EOL);
        $this->mysql_pass = !empty($x) ? trim($x) : $this->mysql_pass;

        $this->_writeMsg("Basis URL [" . $this->base_url . "]: ", '');
        $x = stream_get_line(STDIN, 1024, PHP_EOL);
        $this->base_url = !empty($x) ? trim($x) : $this->base_url;

        $this->_writeMsg("Salt [leave empty for Random Value]: ", '');
        $x = stream_get_line(STDIN, 1024, PHP_EOL);
        $this->base_salt = !empty($x) ? trim($x) : \DND\Helper\CryptoHelper::getRandomString(20);

        $this->_writeMsg("Admin Email [" . $this->admin_mail . "]: ", '');
        $x = stream_get_line(STDIN, 1024, PHP_EOL);
        $this->admin_mail = !empty($x) ? trim($x) : $this->admin_mail;

        $this->_writeMsg("Admin Password [leave empty for Random Value]: ", '');
        $x = stream_get_line(STDIN, 1024, PHP_EOL);
        $this->admin_pass = !empty($x) ? trim($x) : \DND\Helper\CryptoHelper::getRandomString(16);

        $this->_writeLine();
        $this->_doInstall();
    }

    private function _autoInstall() {
        $this->mysql_host = isset($_ENV["DADI_MYSQL_HOST"]) && !empty($_ENV["DADI_MYSQL_HOST"]) ? $_ENV["DADI_MYSQL_HOST"] : $this->mysql_host;
        $this->mysql_db = isset($_ENV["MYSQL_DATABASE"]) && !empty($_ENV["MYSQL_DATABASE"]) ? $_ENV["MYSQL_DATABASE"] : $this->mysql_db;
        $this->mysql_user = isset($_ENV["MYSQL_USER"]) && !empty($_ENV["MYSQL_USER"]) ? $_ENV["MYSQL_USER"] : $this->mysql_user;
        $this->mysql_pass = isset($_ENV["MYSQL_PASSWORD"]) && !empty($_ENV["MYSQL_PASSWORD"]) ? $_ENV["MYSQL_PASSWORD"] : $this->mysql_pass;
        $this->base_url = isset($_ENV["DADI_BASEURL"]) && !empty($_ENV["DADI_BASEURL"]) ? $_ENV["DADI_BASEURL"] : $this->base_url;
        $this->base_salt = isset($_ENV["DADI_SALT"]) && !empty($_ENV["DADI_SALT"]) ? $_ENV["DADI_SALT"] : \DND\Helper\CryptoHelper::getRandomString(20);
        $this->admin_mail = isset($_ENV["DADI_ADMIN_MAIL"]) && !empty($_ENV["DADI_ADMIN_MAIL"]) ? $_ENV["DADI_ADMIN_MAIL"] : $this->admin_mail;
        $this->admin_pass = isset($_ENV["DADI_ADMIN_PASSWORD"]) && !empty($_ENV["DADI_ADMIN_PASSWORD"]) ? $_ENV["DADI_ADMIN_PASSWORD"] : \DND\Helper\CryptoHelper::getRandomString(16);

        $this->_writeLine();
        $this->_doInstall();
    }

    private function _doInstall() {
        # Write Config
        $this->_writeMsg('Writing Config: ', '');
        $cfg = '<?php' . PHP_EOL;
        $cfg .= 'define(\'DEBUG\', FALSE);' . PHP_EOL;
        $cfg .= '' . PHP_EOL;
        $cfg .= '$settings = [' . PHP_EOL;
        $cfg .= '    \'addContentLengthHeader\' => false,' . PHP_EOL;
        $cfg .= '    \'settings\' => [' . PHP_EOL;
        $cfg .= '        \'displayErrorDetails\' => DEBUG,' . PHP_EOL;
        $cfg .= '        \'pdo\' => [' . PHP_EOL;
        $cfg .= '            \'type\' => \'mysql\',' . PHP_EOL;
        $cfg .= '            \'host\' => \'' . addslashes($this->mysql_host) . '\',' . PHP_EOL;
        $cfg .= '            \'dbname\' => \'' . addslashes($this->mysql_db) . '\',' . PHP_EOL;
        $cfg .= '            \'user\' => \'' . addslashes($this->mysql_user) . '\',' . PHP_EOL;
        $cfg .= '            \'pass\' => \'' . addslashes($this->mysql_pass) . '\',' . PHP_EOL;
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
        $cfg .= '        \'baseurl\' => \'' . addslashes($this->base_url) . '\',' . PHP_EOL;
        $cfg .= '        \'salt\' => \'' . addslashes($this->base_salt) . '\',' . PHP_EOL;
        $cfg .= '    ],' . PHP_EOL;
        $cfg .= '];' . PHP_EOL;
        file_put_contents($this->config_path, $cfg);
        $this->_writeMsg('OK', PHP_EOL, "");

        # Test DB
        $this->_writeMsg('Test Database: ', '');
        $pdo = new \PDO("mysql:host=" . $this->mysql_host . ";dbname=" . $this->mysql_db, $this->mysql_user, $this->mysql_pass, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, 0);
        $this->_writeMsg('OK', PHP_EOL, "");

        # Install DB
        $this->_writeMsg('Install Database:');
        foreach (glob(__DIR__ . '/sql/install/*.sql') as $filename) {
            $this->_writeMsg($filename . ': ', '', "\t\t");
            $commands = file_get_contents($filename);
            $pdo->exec($commands);
            if (intval($pdo->errorCode()) > 0) {
                $this->_writeExit('ERROR. Abort Installation');
                return;
            } else {
                $this->_writeMsg('OK', PHP_EOL, "");
            }
        }

        # Create User
        $this->_writeMsg('Create Admin User: ', '');
        $pass = \DND\Helper\CryptoHelper::Crypt($this->admin_pass, 50, $this->base_salt);
        $acc = new \DND\Objects\Account();
        $acc
                ->setActive(1)
                ->setMail($this->admin_mail)
                ->setPassword($pass)
                ->setToken(\DND\Helper\CryptoHelper::getSecureString(50))
                ->setSectoken(\DND\Helper\CryptoHelper::getSecureString(50))
                ->setLastlogin('0000-00-00 00:00:00')
                ->setGm(1);

        $cc = new \DND\Core\ObjectHandler($pdo);
        if (!$cc->addAccount($acc)) {
            $this->_writeExit('ERROR. Abort Installation');
            return;
        }
        $this->_writeMsg('OK', PHP_EOL, "");
        $this->_writeLine();
        $this->_writeMsg('Please login to ' . $this->base_url);
        $this->_writeMsg('Login: ' . $this->admin_mail, PHP_EOL, "\t\t");
        $this->_writeMsg('Password: ' . $this->admin_pass, PHP_EOL, "\t\t");
        $this->_writeLine();
        $this->_writeFinish();
    }

    private function _doUpdate() {

    }

    private function _writeHead() {
        $this->_writeLine();
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
        $this->_writeLine();
        echo PHP_EOL;
    }

    private function _writeLine() {
        $this->_writeMsg('-------------------------------------------------------------------', PHP_EOL, "");
    }

    private function _writeMsg($msg = '', $suffix = PHP_EOL, $prefix = "\t") {
        echo $prefix . $msg . $suffix;
    }

    private function _writeExit($msg = '') {
        die("\t" . $msg . PHP_EOL);
    }

    private function _writeFinish() {
        die("\tSetup Complete <(^.^)>" . PHP_EOL);
    }

}
