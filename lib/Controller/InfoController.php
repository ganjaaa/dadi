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

      function getCharsheet($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage()); // Kein Login
        }
        
        $listUser = [];
        $userData = null;
        $traits = [];
        $features = [];
        $spells = [];
        $mods = [];

        //+ UserData
        $query = "SELECT * FROM view_charsheet WHERE `accountId`=" . intval($this->authController->getLoginId()) . " AND `active`=1";
        $stmt = $this->container->pdo->query($query);
        if ($stmt) {
            $userData = $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        //+ Character List
        foreach ($this->objectController->listCharacter('`accountId`<>' . intval($this->authController->getLoginId()) . ' AND `active`=1 ORDER BY `charname`') as $u) {
            $listUser[] = $u->getAjax();
        }
        
        //+ Traits
        $searchTraits = "";
        $searchFeature = '';
        $searchSpells = "";
        if ($userData['races_traits'] && !empty($userData['races_traits'])) {
            $searchTraits .= (!empty($searchTraits) ? ',' : '') . trim($userData['races_traits']);
        }
        if ($userData['backgrounds_traits'] && !empty($userData['backgrounds_traits'])) {
            $searchTraits .= (!empty($searchTraits) ? ',' : '') . trim($userData['backgrounds_traits']);
        }

        for ($idx = 1; $idx <= 4; $idx++) {
            if ($userData['class' . $idx . '_features'] && !empty($userData['class' . $idx . '_features'])) {
                $searchFeature .= (!empty($searchFeature) ? ',' : '') . $userData['class' . $idx . '_features'];
            }
            if ($userData['class' . $idx . '_traits'] && !empty($userData['class' . $idx . '_traits'])) {
                $searchTraits .= (!empty($searchTraits) ? ',' : '') . trim($userData['class' . $idx . '_traits']);
            }
            if ($userData['class' . $idx . '_spells'] && !empty($userData['class' . $idx . '_spells'])) {
                $searchSpells .= (!empty($searchSpells) ? ',' : '') . trim($userData['class' . $idx . '_spells']);
            }
        }

        if (!empty($searchTraits)) {
            foreach ($this->objectController->listTraits('`id` IN (' . $searchTraits . ')') as $t) {
                $traits[] = $t->getAjax();
                $mods[] = $t->getModifier();
            }
        }
        if (!empty($searchFeature)) {
            foreach ($this->objectController->listFeatures('`id` IN (' . $searchFeature . ')') as $f) {
                $features[] = $f->getAjax();
                $mods[] = $f->getModifier();
            }
        }
        if (!empty($searchSpells)) {
            foreach ($this->objectController->listSpell('`id` IN (' . $searchSpells . ')') as $f) {
                $tmp = $f->getAjax();
                $tmp['description'] = nl2br($tmp['description']);
                $spells[] =$tmp;
            }
        }

        //+ Inventory
        $loop = [ "equipmentQuiver1", "equipmentQuiver2", "equipmentQuiver3", "equipmentHelmet", "equipmentCape", "equipmentNecklace", "equipmentWeapon1", "equipmentWeapon2", "equipmentWeapon3", "equipmentOffWeapon", "equipmentGloves", "equipmentArmor", "equipmentObject", "equipmentBelt", "equipmentBoots", "equipmentRing1", "equipmentRing2"];
        foreach ($loop as $name) {
            if (isset($userData[$name]) && !empty($userData[$name])) {
                $i = $this->objectController->getItem($userData[$name]);
                $mods[] = $i->getModifier();
            }
        }
        $inventory = array();
        foreach ($this->objectController->listInventory('`characterId` = ' . $userData['id']) as $name) {
            $i = $this->objectController->getItem($name->getItemid());
            $a = $name->getAjax();
            $a['item'] = $i->getAjax();
            $inventory[$i->getId()] = $a;
        }

        $modifier = \DND\Core\CharsheetHelper::combineModefier($mods, $userData['bonusModifier'], $userData['races_ability']);
        $userSheet = \DND\Core\CharsheetHelper::parseCheetData($userData, $inventory, $spells,  $modifier);

        
        $result['Charsheet'] = $userSheet;
        
        return $response->withStatus(200)->withJson($result);
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
