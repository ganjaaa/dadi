<?php

namespace DND\Controller;

use DND\Helper\ApiHelper;
use DND\Core\ObjectHandler;
use DND\Core\Calendar;
use DND\Objects\User;

class InfoController extends Controller {

    private $authController;
    private $objectController;

    public function __construct(\Slim\Container &$container) {
        parent::__construct($container);
        $this->authController = new AuthController($container);
        $this->objectController = new ObjectHandler($container->pdo);
    }

    public function getData($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }
        $id = $this->authController->getLoginId();
        $user = $this->objectController->getUser($id);

        $devn = [];
        $env = $this->objectController->getEnvironment($user->getEnvironmentid());
        if ($env) {
            $env->setMap('');
            $env->setMapbg('');
            $env->setMapshadow('');
            $devn = $env->getAjax();
            $devn['date'] = $env->getMoon();
            $char = $user->getDisplayData($env);
        } else {
            $char = $user->getDisplayData();
        }
        $result['data'] = $char;
        $result['data']['env'] = $devn;
        return $response->withStatus(200)->withJson($result);
    }

    public function getInfo($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $this->authController->getLoginId();
        $find = $this->objectController->listCharacter('`accountId` = ' . intval($id) . ' AND `active` = 1');
        if (count($find) == 0) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }
        $user = $find[0];
        $user->setLastactivity(date('Y-m-d H:i:s'));
        $this->objectController->editCharacter($user);

        $list = $this->objectController->listInfo(' `read` = 0 AND userId = ' . $user->getId());
        foreach ($list as $info) {
            $result['data'][] = $info->getAjax();
            $info->setRead(1);
            $this->objectController->editInfo($info);
        }

        return $response->withStatus(200)->withJson($result);
    }

    public function postInfo($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $params = $request->getParams();

        if (isset($id) && $id >= 0) {
            $info = new \DND\Objects\Info();
            $info->fillFromPost($params);
            $info
                    ->setUserid($id)
                    ->setDate(date('Y-m-d H:i:s'))
                    ->setRead(0);
            $this->objectController->addInfo($info);
        } else {
            $list = $this->objectController->listCharacter('`active` = 1');
            foreach ($list as $user) {
                $info = new \DND\Objects\Info();
                $info->fillFromPost($params);
                $info
                        ->setUserid($user->getId())
                        ->setDate(date('Y-m-d H:i:s'))
                        ->setRead(0);
                $this->objectController->addInfo($info);
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

}
