<?php

namespace DND\Controller;

use DND\Helper\ApiHelper;
use DND\Core\ObjectHandler;
use DND\Core\Calendar;
use DND\Objects\Account;

class ReactController extends Controller {

    private $authController;
    private $objectController;

    public function __construct(\Slim\Container &$container) {
        parent::__construct($container);
        $this->authController = new AuthController($container);
        $this->objectController = new ObjectHandler($container->pdo);
    }

    public function user_tableInventory($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }

        $fields = array(
            'id',
            'name',
            'description',
            'amount',
            'weight'
        );
        $userId = $this->authController->getLoginId();
        $page = !empty($request->getParam('page')) && $request->getParam('page') >= 0 ? \intval($request->getParam('page')) : 0;
        $pageSize = !empty($request->getParam('pageSize')) && $request->getParam('pageSize') >= 5 ? \intval($request->getParam('pageSize')) : 10;
        $sorted = !empty($request->getParam('sorted')) && \strlen($request->getParam('sorted')) > 0 ? \json_decode($request->getParam('sorted'), true) : [];
        $filtered = !empty($request->getParam('filtered')) && \strlen($request->getParam('filtered')) > 0 ? \json_decode($request->getParam('filtered'), true) : [];
        $result['pageSize'] = $pageSize;

        $query = 'SELECT * FROM view_inventory ';
        $filter = [
            '( amount > 0 )',
            '( characterId IN (SELECT id FROM `dnd_character` WHERE accountId=' . intval($userId) . ' AND active=1) )'
        ];
        if (count($filtered) > 0) {
            foreach ($filtered as $x) {
                if (!empty($x['id']) && \in_array($x['id'], $fields)) {
                    $filter[] = '(`' . $x['id'] . '` LIKE ' . $this->container->pdo->quote('%' . $x['value'] . '%') . ')';
                }
            }
        }
        $query_where = 'WHERE ' . \implode(' AND ', $filter) . ' ';

        $query_order = '';
        if (count($sorted) > 0) {
            foreach ($sorted as $x) {
                $query_order = 'ORDER BY `' . $x['id'] . '` ' . ($x['desc'] ? 'DESC' : 'ASC') . ' ';
            }
        }
        $query_limit = 'LIMIT ' . ($pageSize * ($page)) . ', ' . $pageSize;
        $stmt = $this->container->pdo->prepare($query . $query_where . $query_order . $query_limit);
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $x = (array) $rec;
            $result['data'][] = $x;
        }
        $recCount = $this->container->pdo->query('SELECT CEIL(count(*)/' . $pageSize . ') FROM view_inventory WHERE amount > 0 AND ( characterId IN (SELECT id FROM `dnd_character` WHERE accountId=' . intval($userId) . ' AND active=1) )')->fetch(\PDO::FETCH_NUM);
        $result['pages'] = $recCount[0];
        return $response->withStatus(200)->withJson($result);
    }

    public function user_tableSpell($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }
        $fields = array(
            'id',
            'name',
            'description'
        );
        $userId = $this->authController->getLoginId();
        $page = !empty($request->getParam('page')) && $request->getParam('page') >= 0 ? \intval($request->getParam('page')) : 0;
        $pageSize = !empty($request->getParam('pageSize')) && $request->getParam('pageSize') >= 5 ? \intval($request->getParam('pageSize')) : 10;
        $sorted = !empty($request->getParam('sorted')) && \strlen($request->getParam('sorted')) > 0 ? \json_decode($request->getParam('sorted'), true) : [];
        $filtered = !empty($request->getParam('filtered')) && \strlen($request->getParam('filtered')) > 0 ? \json_decode($request->getParam('filtered'), true) : [];
        $result['pageSize'] = $pageSize;

        $query = 'SELECT * FROM ' . \DND\Objects\Spell::tableName . ' ';
        $filter = ['1=1'];
        if (count($filtered) > 0) {
            foreach ($filtered as $x) {
                if (!empty($x['id']) && \in_array($x['id'], $fields)) {
                    $filter[] = '(`' . $x['id'] . '` LIKE ' . $this->container->pdo->quote('%' . $x['value'] . '%') . ')';
                }
            }
        }
        $query_where = 'WHERE ' . \implode(' AND ', $filter) . ' ';

        $query_order = '';
        if (count($sorted) > 0) {
            foreach ($sorted as $x) {
                $query_order = 'ORDER BY `' . $x['id'] . '` ' . ($x['desc'] ? 'DESC' : 'ASC') . ' ';
            }
        }

        $query_limit = 'LIMIT ' . ($pageSize * ($page)) . ', ' . $pageSize;
        $stmt = $this->container->pdo->prepare($query . $query_where . $query_order . $query_limit);
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result['data'][] = (array) $rec;
        }

        $recCount = $this->container->pdo->query('SELECT CEIL(count(*)/' . $pageSize . ') FROM ' . \DND\Objects\Spell::tableName . ' WHERE 1=1')->fetch(\PDO::FETCH_NUM);
        $result['pages'] = $recCount[0];

        return $response->withStatus(200)->withJson($result);
    }

    public function user_tableLog($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }

        $fields = array(
            'date',
            'message'
        );
        $userId = $this->authController->getLoginId();
        $page = !empty($request->getParam('page')) && $request->getParam('page') >= 0 ? \intval($request->getParam('page')) : 0;
        $pageSize = !empty($request->getParam('pageSize')) && $request->getParam('pageSize') >= 5 ? \intval($request->getParam('pageSize')) : 10;
        $sorted = !empty($request->getParam('sorted')) && \strlen($request->getParam('sorted')) > 0 ? \json_decode($request->getParam('sorted'), true) : [];
        $filtered = !empty($request->getParam('filtered')) && \strlen($request->getParam('filtered')) > 0 ? \json_decode($request->getParam('filtered'), true) : [];
        $result['pageSize'] = $pageSize;

        $query = 'SELECT * FROM ' . \DND\Objects\Info::tableName . ' ';
        $filter = [
            '( message > "" )',
            '( userId IN (SELECT id FROM ' . \DND\Objects\Character::tableName . ' WHERE accountId=' . intval($userId) . ' AND active=1) )'
        ];
        if (count($filtered) > 0) {
            foreach ($filtered as $x) {
                if (!empty($x['id']) && \in_array($x['id'], $fields)) {
                    $filter[] = '(`' . $x['id'] . '` LIKE ' . $this->container->pdo->quote('%' . $x['value'] . '%') . ')';
                }
            }
        }
        $query_where = 'WHERE ' . \implode(' AND ', $filter) . ' ';

        $query_order = '';
        if (count($sorted) > 0) {
            foreach ($sorted as $x) {
                $query_order = 'ORDER BY `' . $x['id'] . '` ' . ($x['desc'] ? 'DESC' : 'ASC') . ' ';
            }
        }

        $query_limit = 'LIMIT ' . ($pageSize * ($page)) . ', ' . $pageSize;
        $stmt = $this->container->pdo->prepare($query . $query_where . $query_order . $query_limit);
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result['data'][] = (array) $rec;
        }

        $recCount = $this->container->pdo->query('SELECT CEIL(count(*)/' . $pageSize . ') FROM ' . \DND\Objects\Info::tableName . ' WHERE (message > "") AND ( userId IN (SELECT id FROM ' . \DND\Objects\Character::tableName . ' WHERE accountId=' . intval($userId) . ' AND active=1) )')->fetch(\PDO::FETCH_NUM);
        $result['pages'] = $recCount[0];

        return $response->withStatus(200)->withJson($result);
    }

    public function user_inventoryEquipt($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }
        $id = $this->authController->getLoginId();
        $search = $this->objectController->listCharacter('accountId=' . intval($id) . ' AND active=1');
        if (count($search) == 1) {
            $user = $search[0];
            $params = $request->getParams();
            $params['id'] = abs(intval($params['id']));

            $inventory = $this->objectController->getInventory($params['id']);
            if ($inventory) {
                $item = $this->objectController->getItem($inventory->getItemid());
                if ($item) {
                    if ($inventory->getAmount() > 0 && $item->getWearable() > 0) {
                        // Das Item kann getragen werden
                        switch ($item->getWearable()) {
                            case \DND\Objects\Item::IDX_EQUIPT_SLOT_QUIVER:
                                if (empty($user->getEquipmentquiver1())) {
                                    $user->setEquipmentquiver1($item->getId());
                                } else if (empty($user->getEquipmentquiver2())) {
                                    $user->setEquipmentquiver2($item->getId());
                                } else if (empty($user->getEquipmentquiver3())) {
                                    $user->setEquipmentquiver3($item->getId());
                                } else {
                                    $user->setEquipmentquiver1($item->getId());
                                }
                                break;
                            case \DND\Objects\Item::IDX_EQUIPT_SLOT_HELMET:
                                $user->setEquipmenthelmet($item->getId());
                                break;
                            case \DND\Objects\Item::IDX_EQUIPT_SLOT_CAPE:
                                $user->setEquipmentcape($item->getId());
                                break;
                            case \DND\Objects\Item::IDX_EQUIPT_SLOT_NECKLACE:
                                $user->setEquipmentnecklace($item->getId());
                                break;
                            case \DND\Objects\Item::IDX_EQUIPT_SLOT_GLOVES:
                                $user->setEquipmentgloves($item->getId());
                                break;
                            case \DND\Objects\Item::IDX_EQUIPT_SLOT_RING:
                                if (empty($user->getEquipmentring1())) {
                                    $user->setEquipmentring1($item->getId());
                                } else if (empty($user->getEquipmentring2())) {
                                    $user->setEquipmentring2($item->getId());
                                } else {
                                    $user->setEquipmentring1($item->getId());
                                }
                                break;
                            case \DND\Objects\Item::IDX_EQUIPT_SLOT_ARMOR:
                                $user->setEquipmentarmor($item->getId());
                                break;
                            case \DND\Objects\Item::IDX_EQUIPT_SLOT_WEAPON:
                                if (empty($user->getEquipmentweapon1())) {
                                    $user->setEquipmentweapon1($item->getId());
                                } else if (empty($user->getEquipmentweapon2())) {
                                    $user->setEquipmentweapon2($item->getId());
                                } else if (empty($user->getEquipmentweapon3())) {
                                    $user->setEquipmentweapon3($item->getId());
                                } else {
                                    $user->setEquipmentweapon1($item->getId());
                                }
                                break;
                            case \DND\Objects\Item::IDX_EQUIPT_SLOT_OFF_WEAPON:
                                $user->setEquipmentoffweapon($item->getId());
                                break;
                            case \DND\Objects\Item::IDX_EQUIPT_SLOT_BELT:
                                $user->setEquipmentbelt($item->getId());
                                break;
                            case \DND\Objects\Item::IDX_EQUIPT_SLOT_BOOTS:
                                $user->setEquipmentboots($item->getId());
                                break;
                        }
                        $this->objectController->editCharacter($user);
                    }
                }
            }
        }

        return $response->withStatus(200)->withJson($result);
    }

    public function user_inventoryUnequipt($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }
        $id = $this->authController->getLoginId();
        $search = $this->objectController->listCharacter('accountId=' . intval($id) . ' AND active=1');
        if (count($search) == 1) {
            $user = $search[0];
            $params = $request->getParams();
            $params['id'] = abs(intval($params['id']));

            $inventory = $this->objectController->getInventory($params['id']);
            if ($inventory) {
                $item = $this->objectController->getItem($inventory->getItemid());
                if ($item && $item->getCursed() <= 0) {
                    if ($user->getEquipmentquiver1() == $item->getId()) {
                        $user->setEquipmentquiver1(0);
                    }
                    if ($user->getEquipmentquiver2() == $item->getId()) {
                        $user->setEquipmentquiver2(0);
                    }
                    if ($user->getEquipmentquiver3() == $item->getId()) {
                        $user->setEquipmentquiver3(0);
                    }
                    if ($user->getEquipmenthelmet() == $item->getId()) {
                        $user->setEquipmenthelmet(0);
                    }
                    if ($user->getEquipmentcape() == $item->getId()) {
                        $user->setEquipmentcape(0);
                    }
                    if ($user->getEquipmentnecklace() == $item->getId()) {
                        $user->setEquipmentnecklace(0);
                    }
                    if ($user->getEquipmentgloves() == $item->getId()) {
                        $user->setEquipmentgloves(0);
                    }
                    if ($user->getEquipmentring1() == $item->getId()) {
                        $user->setEquipmentring1(0);
                    }
                    if ($user->getEquipmentring2() == $item->getId()) {
                        $user->setEquipmentring2(0);
                    }
                    if ($user->getEquipmentring1() == $item->getId()) {
                        $user->setEquipmentring1(0);
                    }
                    if ($user->getEquipmentarmor() == $item->getId()) {
                        $user->setEquipmentarmor(0);
                    }
                    if ($user->getEquipmentweapon1() == $item->getId()) {
                        $user->setEquipmentweapon1(0);
                    }
                    if ($user->getEquipmentweapon2() == $item->getId()) {
                        $user->setEquipmentweapon2(0);
                    }
                    if ($user->getEquipmentweapon3() == $item->getId()) {
                        $user->setEquipmentweapon3(0);
                    }
                    if ($user->getEquipmentoffweapon() == $item->getId()) {
                        $user->setEquipmentoffweapon(0);
                    }
                    if ($user->getEquipmentbelt() == $item->getId()) {
                        $user->setEquipmentbelt(0);
                    }
                    if ($user->getEquipmentboots() == $item->getId()) {
                        $user->setEquipmentboots(0);
                    }
                    $this->objectController->editCharacter($user);
                }
            }
        }

        return $response->withStatus(200)->withJson($result);
    }

    public function user_inventoryDrop($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }
        $id = $this->authController->getLoginId();
        $search = $this->objectController->listCharacter('accountId=' . intval($id) . ' AND active=1');
        if (count($search) == 1) {
            $user = $search[0];
            $params = $request->getParams();
            $params['id'] = abs(intval($params['id']));
            $params['amount'] = abs(intval($params['amount']));

            $inventory = $this->objectController->getInventory($params['id']);
            if ($inventory) {
                if ($params['amount'] > $inventory->getAmount()) {
                    $params['amount'] = $inventory->getAmount();
                }
                $inventory->setAmount($inventory->getAmount() - $params['amount']);
                $this->objectController->editInventory($inventory);
            }
        }

        return $response->withStatus(200)->withJson($result);
    }

    public function user_inventoryGive($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }
        $id = $this->authController->getLoginId();
        $search = $this->objectController->listCharacter('accountId=' . intval($id) . ' AND active=1');
        if (count($search) == 1) {
            $user = $search[0];
            $params = $request->getParams();
            $params['id'] = abs(intval($params['id']));
            $params['target'] = abs(intval($params['target']));
            $params['amount'] = abs(intval($params['amount']));

            $inventory = $this->objectController->getInventory($params['id']);
            if ($inventory) {
                if ($params['amount'] > $inventory->getAmount()) {
                    $params['amount'] = $inventory->getAmount();
                }
                $inventory->setAmount($inventory->getAmount() - $params['amount']);
                $this->objectController->editInventory($inventory);

                $targetList = $this->objectController->listInventory('characterId=' . $params['target'] . ' AND itemId=' . $inventory->getItemid());
                if (count($targetList) > 0) {
                    foreach ($targetList as $inv) {
                        if ($inv->getKnowledge() < $inventory->getKnowledge()) {
                            $inv->setKnowledge($inventory->getKnowledge());
                        }
                        $inv->setAmount($inv->getAmount() + $params['amount']);
                        $this->objectController->editInventory($inv);
                    }
                } else {
                    $inventory->setId(null)->setCharacterid($params['target'])->setAmount($params['amount']);
                    $this->objectController->addInventory($inventory);
                }
            }
        }
        return $response->withStatus(200)->withJson($result);
    }

    public function user_spellEquipt($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }
        return $response->withStatus(200)->withJson($result);
    }

    public function user_spellUnequipt($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }
        return $response->withStatus(200)->withJson($result);
    }

    public function user_spellUse($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }
        return $response->withStatus(200)->withJson($result);
    }

    public function user_infoEnvironment($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }
        return $response->withStatus(200)->withJson($result);
    }

    public function user_infoCharsheet($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }

        $listUser = [];
        $userData = null;
        $traits = [
            'race' => [],
            'class' => [],
            'background' => [],
            'languages' => [],
        ];
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
        if ($userData['races_traits'] && !empty($userData['races_traits'])) {
            foreach ($this->objectController->listTraits('`id` IN (' . trim($userData['races_traits']) . ')') as $t) {
                if ($t->getName() == "Languages") {
                    $traits['languages'][] = $t->getAjax();
                } else {
                    $traits['race'][] = $t->getAjax();
                }
                $mods[] = $t->getModifier();
            }
        }
        if ($userData['backgrounds_traits'] && !empty($userData['backgrounds_traits'])) {
            foreach ($this->objectController->listTraits('`id` IN (' . trim($userData['backgrounds_traits']) . ')') as $t) {
                $traits['background'][] = $t->getAjax();
                $mods[] = $t->getModifier();
            }
        }

        for ($idx = 1; $idx <= 4; $idx++) {
            if ($userData['class' . $idx . '_traits'] && !empty($userData['class' . $idx . '_traits'])) {
                foreach ($this->objectController->listTraits('`id` IN (' . trim($userData['class' . $idx . '_traits']) . ')') as $t) {
                    if ($t->getName() == "Languages") {
                        $traits['languages'][] = $t->getAjax();
                    } else {
                        $traits['class'][] = $t->getAjax();
                    }
                    $mods[] = $t->getModifier();
                }
            }
            if ($userData['class' . $idx . '_features'] && !empty($userData['class' . $idx . '_features'])) {
                foreach ($this->objectController->listFeatures('`id` IN (' . $userData['class' . $idx . '_features'] . ')') as $f) {
                    $features[] = $f->getAjax();
                    $mods[] = $f->getModifier();
                }
            }
            if ($userData['class' . $idx . '_spells'] && !empty($userData['class' . $idx . '_spells'])) {
                foreach ($this->objectController->listSpell('`id` IN (' . $userData['class' . $idx . '_spells'] . ')') as $f) {
                    $tmp = $f->getAjax();
                    $tmp['description'] = nl2br($tmp['description']);
                    $spells[] = $tmp;
                }
            }
        }

        //+ Inventory
        $loop = ["equipmentQuiver1", "equipmentQuiver2", "equipmentQuiver3", "equipmentHelmet", "equipmentCape", "equipmentNecklace", "equipmentWeapon1", "equipmentWeapon2", "equipmentWeapon3", "equipmentOffWeapon", "equipmentGloves", "equipmentArmor", "equipmentObject", "equipmentBelt", "equipmentBoots", "equipmentRing1", "equipmentRing2"];
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
        $userSheet = \DND\Core\CharsheetHelper::parseCheetData($userData, $inventory, $spells, $modifier);
        $result['data'] = $userSheet;
        $result['data']['Userlist'] = $listUser;
        $userData['environment_map'] = '';
        $userData['environment_mapBG'] = '';
        $userData['environment_mapShadow'] = '';
        $result['data']['Userdata'] = $userData;
        $result['data']['UserId'] = $userData['id'];
        $result['data']['Traits'] = $traits;

        return $response->withStatus(200)->withJson($result);
    }

    public function user_infoTraits($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }
        return $response->withStatus(200)->withJson($result);
    }

    public function user_infoPoll($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }

        $id = $this->authController->getLoginId();
        $search = $this->objectController->listCharacter('accountId=' . intval($id) . ' AND active=1');
        if (count($search) == 1) {
            $user = $search[0];
            $result['data'] = [
                'messages' => [],
                'reload' => 0
            ];
            foreach ($this->objectController->listInfo('userId = ' . $user->getId() . ' AND `read` = 0') as $info) {
                if (!empty($info->getMessage())) {
                    $result['data']['messages'][] = $info->getAjax();
                }
                if ($info->getCommand() == "reload") {
                    $result['data']['reload'] = 1;
                }
                $info->setRead(1);
                $this->objectController->editInfo($info);
            }
        }

        return $response->withStatus(200)->withJson($result);
    }

    public function user_infoMap($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }
        return $response->withStatus(200)->withJson($result);
    }

    public function dm_dashboardCharacter($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin() && !$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }
        $result['data'] = [];
        foreach ($this->objectController->listCharacter() as $char) {
            $result['data'][] = $char->getAjax();
        }
        return $response->withStatus(200)->withJson($result);
    }

    public function dm_dashboardEnvironment($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin() && !$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }
        $result['data'] = [];
        foreach ($this->objectController->listEnvironment() as $env) {
            $env->setMap('');
            $env->setMapbg('');
            $env->setMapshadow('');
            $result['data'][] = $env->getAjax();
        }
        return $response->withStatus(200)->withJson($result);
    }

    public function dm_dashboardExp($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin() && !$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }

        $id = $request->getAttribute('charId');
        $val = $request->getParam('value');

        if (empty($val)) {
            return $response->withStatus(200)->withJson($result);
        }

        if ($id && $id > 0) { // Single
            $char = $this->objectController->getCharacter($id);
            if ($char) {
                // I dont trust "else" here
                if ($val > 0) {
                    $char->setExp($char->getExp() + \abs($val));
                    $info = new \DND\Objects\Info();
                    $info->setDate(\date('Y-m-d H:i:s'))->setMessage('You earned <b>' . \abs($val) . '</b> EXP')->setCommand('reload')->setUserid($char->getId())->setRead(0);
                    $this->objectController->addInfo($info);
                }
                if ($val < 0) {
                    $char->setExp($char->getExp() - \abs($val));
                    $info = new \DND\Objects\Info();
                    $info->setDate(\date('Y-m-d H:i:s'))->setMessage('You loose <b>' . \abs($val) . '</b> EXP')->setCommand('reload')->setUserid($char->getId())->setRead(0);
                    $this->objectController->addInfo($info);
                }
                $this->objectController->editCharacter($char);
            }
        } else { // all
            foreach ($this->objectController->listCharacter() as $char) {
                // I dont trust "else" here
                if ($val > 0) {
                    $char->setExp($char->getExp() + \abs($val));
                    $info = new \DND\Objects\Info();
                    $info->setDate(\date('Y-m-d H:i:s'))->setMessage('You earned <b>' . \abs($val) . '</b> EXP')->setCommand('reload')->setUserid($char->getId())->setRead(0);
                    $this->objectController->addInfo($info);
                }
                if ($val < 0) {
                    $char->setExp($char->getExp() - \abs($val));
                    $info = new \DND\Objects\Info();
                    $info->setDate(\date('Y-m-d H:i:s'))->setMessage('You loose <b>' . \abs($val) . '</b> EXP')->setCommand('reload')->setUserid($char->getId())->setRead(0);
                    $this->objectController->addInfo($info);
                }
                $this->objectController->editCharacter($char);
            }
        }

        return $response->withStatus(200)->withJson($result);
    }

    public function dm_dashboardHP($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin() && !$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }

        $id = $request->getAttribute('charId');
        $val = $request->getParam('value');

        if (empty($val)) {
            return $response->withStatus(200)->withJson($result);
        }

        if ($id && $id > 0) { // Single
            $char = $this->objectController->getCharacter($id);
            if ($char) {
                if ($val > 0) {
                    $hp = \explode(';', $char->getHp());
                    $hp[1] += \abs($val);
                    if ($hp[0] < $hp[1])
                        $hp[1] = $hp[0];
                    $char->setHp(\implode(';', $hp));
                    $info = new \DND\Objects\Info();
                    $info->setDate(\date('Y-m-d H:i:s'))->setMessage('You earned <b>' . \abs($val) . '</b> HP')->setCommand('reload')->setUserid($char->getId())->setRead(0);
                    $this->objectController->addInfo($info);
                }
                if ($val < 0) {
                    $hp = \explode(';', $char->getHp());
                    $hp[1] -= \abs($val);
                    if (0 > $hp[1])
                        $hp[1] = 0;
                    $char->setHp(\implode(';', $hp));
                    $info = new \DND\Objects\Info();
                    $info->setDate(\date('Y-m-d H:i:s'))->setMessage('You loose <b>' . \abs($val) . '</b> HP')->setCommand('reload')->setUserid($char->getId())->setRead(0);
                    $this->objectController->addInfo($info);
                }
                $this->objectController->editCharacter($char);
            }
        } else { // all
            foreach ($this->objectController->listCharacter() as $char) {
                // I dont trust "else" here
                if ($val > 0) {
                    $hp = \explode(';', $char->getHp());
                    $hp[1] += \abs($val);
                    if ($hp[0] < $hp[1])
                        $hp[1] = $hp[0];
                    $char->setHp(\implode(';', $hp));
                    $info = new \DND\Objects\Info();
                    $info->setDate(\date('Y-m-d H:i:s'))->setMessage('You earned <b>' . \abs($val) . '</b> HP')->setCommand('reload')->setUserid($char->getId())->setRead(0);
                    $this->objectController->addInfo($info);
                }
                if ($val < 0) {
                    $hp = \explode(';', $char->getHp());
                    $hp[1] -= \abs($val);
                    if (0 > $hp[1])
                        $hp[1] = 0;
                    $char->setHp(\implode(';', $hp));
                    $info = new \DND\Objects\Info();
                    $info->setDate(\date('Y-m-d H:i:s'))->setMessage('You loose <b>' . \abs($val) . '</b> HP')->setCommand('reload')->setUserid($char->getId())->setRead(0);
                    $this->objectController->addInfo($info);
                }
                $this->objectController->editCharacter($char);
            }
        }

        return $response->withStatus(200)->withJson($result);
    }

    public function dm_dashboardMsg($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin() && !$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }

        $id = $request->getAttribute('charId');
        $val = $request->getParam('value');

        if (empty($val)) {
            return $response->withStatus(200)->withJson($result);
        }

        if ($id && $id > 0) { // Single
            $char = $this->objectController->getCharacter($id);
            if ($char) {
                $info = new \DND\Objects\Info();
                $info->setDate(\date('Y-m-d H:i:s'))->setMessage($val)->setUserid($char->getId())->setRead(0);
                $this->objectController->addInfo($info);
            }
        } else { // all
            foreach ($this->objectController->listCharacter() as $char) {
                $info = new \DND\Objects\Info();
                $info->setDate(\date('Y-m-d H:i:s'))->setMessage($val)->setUserid($char->getId())->setRead(0);
                $this->objectController->addInfo($info);
            }
        }

        return $response->withStatus(200)->withJson($result);
    }

    public function dm_dashboardReload($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin() && !$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }

        $id = $request->getAttribute('charId');

        if (empty($val)) {
            return $response->withStatus(200)->withJson($result);
        }

        if ($id && $id > 0) { // Single
            $char = $this->objectController->getCharacter($id);
            if ($char) {
                $info = new \DND\Objects\Info();
                $info->setDate(\date('Y-m-d H:i:s'))->setCommand('reload')->setUserid($char->getId())->setRead(0);
                $this->objectController->addInfo($info);
            }
        } else { // all
            foreach ($this->objectController->listCharacter() as $char) {
                $info = new \DND\Objects\Info();
                $info->setDate(\date('Y-m-d H:i:s'))->setCommand('reload')->setUserid($char->getId())->setRead(0);
                $this->objectController->addInfo($info);
            }
        }

        return $response->withStatus(200)->withJson($result);
    }

    public function dm_dashboardRest($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin() && !$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }

        $id = $request->getAttribute('charId');

        if (empty($val)) {
            return $response->withStatus(200)->withJson($result);
        }

        if ($id && $id > 0) { // Single
            $char = $this->objectController->getCharacter($id);
            if ($char) {
                $info = new \DND\Objects\Info();
                $info->setDate(\date('Y-m-d H:i:s'))->setMessage('You feel refreshed')->setCommand('reload')->setUserid($char->getId())->setRead(0);
                $this->objectController->addInfo($info);
            }
        } else { // all
            foreach ($this->objectController->listCharacter() as $char) {
                $info = new \DND\Objects\Info();
                $info->setDate(\date('Y-m-d H:i:s'))->setMessage('You feel refreshed')->setCommand('reload')->setUserid($char->getId())->setRead(0);
                $this->objectController->addInfo($info);
            }
        }

        return $response->withStatus(200)->withJson($result);
    }

    public function dm_dashboardMoney($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin() && !$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }

        $id = $request->getAttribute('charId');
        $cp = $request->getParam('cp');
        $sp = $request->getParam('sp');
        $ep = $request->getParam('ep');
        $gp = $request->getParam('gp');
        $pp = $request->getParam('pp');

        if (empty($cp) && empty($sp) && empty($ep) && empty($gp) && empty($pp)) {
            return $response->withStatus(200)->withJson($result);
        }

        $cp = !empty($cp) ? $cp : 0;
        $sp = !empty($sp) ? $sp : 0;
        $ep = !empty($ep) ? $ep : 0;
        $gp = !empty($gp) ? $gp : 0;
        $pp = !empty($pp) ? $pp : 0;

        if ($id && $id > 0) { // Single
            $char = $this->objectController->getCharacter($id);
            if ($char) {
                $cash = \explode(';', $char->getMoney());

                $check = $cash[0] + $cash[1] * 10 + $cash[2] * 50 + $cash[3] * 100 + $cash[4] * 1000;
                $contr = $cp + $sp * 10 + $ep * 50 + $gp * 100 + $pp * 1000;
                if ($contr - $check > 0) {
                    return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
                }

                $cash[0] = ($cp >= 0) ? $cash[0] + \abs($cp) : $cash[0] - \abs($cp);
                $cash[1] = ($sp >= 0) ? $cash[1] + \abs($sp) : $cash[0] - \abs($sp);
                $cash[2] = ($ep >= 0) ? $cash[2] + \abs($ep) : $cash[0] - \abs($ep);
                $cash[3] = ($gp >= 0) ? $cash[3] + \abs($gp) : $cash[0] - \abs($gp);
                $cash[4] = ($pp >= 0) ? $cash[4] + \abs($pp) : $cash[0] - \abs($pp);

                if ($cash[4] < 0 || $cash[3] < 0 || $cash[2] < 0 || $cash[1] < 0 || $cash[0] < 0) {
                    while ($cash[4] < 0 || $cash[3] < 0 || $cash[2] < 0 || $cash[1] < 0 || $cash[0] < 0) {
                        if ($cash[4] < 0) {
                            $cash[2] --;
                        }
                        if ($cash[3] < 0) {
                            $cash[1] --;
                        }
                        if ($cash[2] < 0) {
                            $cash[1] --;
                        }
                        if ($cash[1] < 0) {
                            $cash[0] --;
                        }
                        if ($cash[0] < 0 && $cash[1] > 0) {
                            $cash[1] --;
                            $cash[0] += 10;
                        }
                        if ($cash[0] < 0 && $cash[3] > 0) {
                            $cash[3] --;
                            $cash[0] += 100;
                        }
                    }
                }
                $char->setMoney(\implode(';', $cash));

                $info = new \DND\Objects\Info();
                $info->setDate(\date('Y-m-d H:i:s'))->setMessage(
                        'Money change:<br \>' .
                        (!empty($cp) ? '<b>' . $cp . ' CP</b><br \>' : '') .
                        (!empty($sp) ? '<b>' . $sp . ' SP</b><br \>' : '') .
                        (!empty($ep) ? '<b>' . $ep . ' EP</b><br \>' : '') .
                        (!empty($gp) ? '<b>' . $gp . ' GP</b><br \>' : '') .
                        (!empty($pp) ? '<b>' . $pp . ' PP</b><br \>' : '')
                )->setCommand('reload')->setUserid($char->getId())->setRead(0);
                $this->objectController->addInfo($info);

                $this->objectController->editCharacter($char);
            }
        } else { // all
            $list = $this->objectController->listCharacter();
            foreach ($list as $char) {
                $cash = \explode(';', $char->getMoney());
                $check = $cash[0] + $cash[1] * 10 + $cash[2] * 50 + $cash[3] * 100 + $cash[4] * 1000;
                $contr = $cp + $sp * 10 + $ep * 50 + $gp * 100 + $pp * 1000;
                if ($contr > $check) {
                    return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
                }
            }
            foreach ($list as $char) {
                $cash = \explode(';', $char->getMoney());
                $cash[0] = ($cp >= 0) ? $cash[0] + \abs($cp) : $cash[0] - \abs($cp);
                $cash[1] = ($sp >= 0) ? $cash[1] + \abs($sp) : $cash[0] - \abs($sp);
                $cash[2] = ($ep >= 0) ? $cash[2] + \abs($ep) : $cash[0] - \abs($ep);
                $cash[3] = ($gp >= 0) ? $cash[3] + \abs($gp) : $cash[0] - \abs($gp);
                $cash[4] = ($pp >= 0) ? $cash[4] + \abs($pp) : $cash[0] - \abs($pp);

                if ($cash[4] < 0 || $cash[3] < 0 || $cash[2] < 0 || $cash[1] < 0 || $cash[0] < 0) {
                    while ($cash[4] < 0 || $cash[3] < 0 || $cash[2] < 0 || $cash[1] < 0 || $cash[0] < 0) {
                        if ($cash[4] < 0) {
                            $cash[2] --;
                        }
                        if ($cash[3] < 0) {
                            $cash[1] --;
                        }
                        if ($cash[2] < 0) {
                            $cash[1] --;
                        }
                        if ($cash[1] < 0) {
                            $cash[0] --;
                        }
                        if ($cash[0] < 0 && $cash[1] > 0) {
                            $cash[1] --;
                            $cash[0] += 10;
                        }
                        if ($cash[0] < 0 && $cash[3] > 0) {
                            $cash[3] --;
                            $cash[0] += 100;
                        }
                    }
                }
                $char->setMoney(\implode(';', $cash));

                $info = new \DND\Objects\Info();
                $info->setDate(\date('Y-m-d H:i:s'))->setMessage(
                        'Money change:<br \>' .
                        (!empty($cp) ? '<b>' . $cp . ' CP</b><br \>' : '') .
                        (!empty($sp) ? '<b>' . $sp . ' SP</b><br \>' : '') .
                        (!empty($ep) ? '<b>' . $ep . ' EP</b><br \>' : '') .
                        (!empty($gp) ? '<b>' . $gp . ' GP</b><br \>' : '') .
                        (!empty($pp) ? '<b>' . $pp . ' PP</b><br \>' : '')
                )->setCommand('reload')->setUserid($char->getId())->setRead(0);
                $this->objectController->addInfo($info);

                $this->objectController->editCharacter($char);
            }
        }

        return $response->withStatus(200)->withJson($result);
    }

    public function dm_dashboardDice($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin() && !$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }

        $id = $request->getAttribute('sides');
        $id = (empty($id) || $id < 1 || $id != intval($id)) ? \PHP_INT_MAX : intval($id);
        $result['data'] = [
            'sides' => $id,
            'value' => \random_int(1, $id)
        ];

        return $response->withStatus(200)->withJson($result);
    }

    function getEnvironment($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $value = $request->getAttribute('value');
        if (isset($id) && $id >= 0 && !isset($value)) {
            $a = $this->objectController->getEnvironment($id);
            $result['data'] = $a->getAjax();
        } else {
            $a = $this->objectController->listEnvironment('', (isset($value) && isset($id)) ? '`' . $id . '` = "' . $value . '" ORDER BY `name` ASC' : ' ORDER BY `name` ASC');
            foreach ($a as $aa) {
                $result['data'][] = $aa->getAjax();
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postEnvironment($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $params = $request->getParams();

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getEnvironment($id);
            $obj->fillFromPost($params);
            if (!$this->objectController->editEnvironment($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
            // Alle Updaten
            foreach ($this->objectController->listCharacter() as $char) {
                $info = new \DND\Objects\Info();
                $info->setDate(\date('Y-m-d H:i:s'))->setCommand('reload')->setUserid($char->getId())->setRead(0);
                $this->objectController->addInfo($info);
            }
        } else {
            $obj = new \DND\Objects\Environment();
            $obj->fillFromPost($params);

            if (!$this->objectController->addEnvironment($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function deleteEnvironment($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getEnvironment($id);
            if (!$this->objectController->delEnvironment($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }
        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

}
