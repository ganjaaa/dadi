<?php

namespace DND\Controller;

use DND\Core\ObjectHandler;

class AuthController extends Controller {

    private $objectController;

    public function __construct(\Slim\Container &$container) {
        parent::__construct($container);
        $this->objectController = new ObjectHandler($container->pdo);
    }

    public function login($userId = NULL, $userIp = NULL, $aacountGm = NULL) {
        $_SESSION['userId'] = $userId;
        $_SESSION['userIp'] = $userIp;
        $_SESSION['userGm'] = $aacountGm;
    }

    public function isLogin() {
        if (isset($_SESSION['userId']) && $_SESSION['userId'] > 0 && isset($_SESSION['userIp']) /*&& $_SESSION['userIp'] == $_SERVER['REMOTE_ADDR']*/) {
            $this->container->smarty->assign('isLogin', true);
            $this->container->smarty->assign('userId', $_SESSION['userId']);
            $this->isGm();
            return true;
        }
        $this->container->smarty->assign('isLogin', false);
        return false;
    }

    public function isGm() {
        if (isset($_SESSION['userGm'])) {
            $this->container->smarty->assign('isGm', ($_SESSION['userGm'] == 1 ? true : false));
            $this->container->smarty->assign('isSuperGm', ($_SESSION['userGm'] == 2 ? true : false));
            return ($_SESSION['userGm'] > 0) ? true : false;
        }
        return false;
    }

    public function getLoginId() {
        return isset($_SESSION['userId']) ? $_SESSION['userId'] : 0;
    }

    public function logout() {
        if (isset($_SESSION['userId'])) {
            $_SESSION['userId'] = 0;
            unset($_SESSION['userId']);
        }
        if (isset($_SESSION['userIp'])) {
            $_SESSION['userIp'] = 0;
            unset($_SESSION['userIp']);
        }
        if (isset($_SESSION['userGm'])) {
            $_SESSION['userGm'] = 0;
            unset($_SESSION['userGm']);
        }
    }

    public function setLogin($userId, $gm = 0) {
        $_SESSION['userId'] = $userId;
        $_SESSION['userIp'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['userGm'] = $gm;
    }

}
