<?php

namespace DND\Controller;

use DND\Core\ObjectHandler;
use DND\Helper\ApiHelper;
use DND\Objects\User;

class ShortcutController extends Controller {

    private $authController;
    private $objectController;

    public function __construct(\Slim\Container &$container) {
        parent::__construct($container);
        $this->authController = new AuthController($container);
        $this->objectController = new ObjectHandler($container->pdo);
    }

    public function getRandom($request, $response, $args) {
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }
        $id = $request->getAttribute('id');
        $max = (isset($id) && $id > 0) ? $id : PHP_INT_MAX;

        $list = [];
        for ($i = 0; $i < 100; $i++) {
            $list[] = random_int(1, $max);
        }
        $rslt = ApiHelper::getResponseDummy();
        $rslt['data'] = $list[random_int(0, 99)];

        return $response->withStatus(200)->withJson($rslt);
    }

    public function postUserDiary($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }
        $id = $this->authController->getLoginId();
        $user = $this->objectController->getUser($id);
        if ($user) {
            $user->setDiary($request->getParam('diary'));
            $this->objectController->editUser($user);
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postShortcutItem($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];
        if (!$this->authController->isLogin() || !$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $params = $request->getParams();

        if (!isset($params['itemId']) && empty($params['itemId'])) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $item = $this->objectController->getItem($params['itemId']);

        if (!empty($id) && $id > 0) {
            $addInv = true;
            $user = $this->objectController->getUser($id);
            //if ($item->getStackable() == \DND\Objects\Item::IDX_STACKABLE) {
                $search = $this->objectController->listInventory('`itemId` = ' . $item->getId() . ' AND `characterId` = ' . $user->getId());
                if (count($search) >= 1) {
                    $addInv = false;
                    $selected = $search[0];
                    $selected->setAmount($selected->getAmount() + $params['amount']);
                    if ($selected->getAmount() <= 0) { // Delete
                        $this->objectController->delInventory($selected);
                    } else {
                        $this->objectController->editInventory($selected);
                    }
                }
            //}
            if ($addInv) {
                $inv = new \DND\Objects\Inventory();
                $inv->fillFromPost($params);
                $inv->setCharacterid($user->getId());
                $this->objectController->addInventory($inv);
            }
            $result['data'][0] = $params['amount'];
            $result['data'][1] = $item->getName();
        } else {
            $users = $this->objectController->listUser('`gm` = 0');
            foreach ($users as $user) {
                $addInv = true;
                if ($item->getStackable() == \DND\Objects\Item::IDX_STACKABLE) {
                    $search = $this->objectController->listInventory('`itemId` = ' . $item->getId() . ' AND `characterId` = ' . $user->getId());
                    if (count($search) >= 1) {
                        $addInv = false;
                        $selected = $search[0];
                        $selected->setAmount($selected->getAmount() + $params['amount']);
                        if ($selected->getAmount() <= 0) { // Delete
                            $selected->setAmount(0);
                        }
                        $this->objectController->editInventory($selected);
                    }
                }
                if ($addInv) {
                    $inv = new \DND\Objects\Inventory();
                    $inv->fillFromPost($params);
                    $inv->setCharacterid($user->getId());
                    $this->objectController->addInventory($inv);
                }

                $result['data'][0] = $params['amount'];
                $result['data'][1] = $item->getName();
            }
        }

        return $response->withStatus(200)->withJson($result);
    }

    public function postShortcutExp($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin() || !$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }
        $id = $request->getAttribute('id');
        $exp = $request->getParam('exp');

        if (!isset($exp) || empty($exp)) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        if (!empty($id) && $id > 0) {
            $user = $this->objectController->getUser($id);
            $user->setExp($user->getExp() + $exp);
            $this->objectController->editUser($user);
            $result['data'] = $user->getDisplayData();
        } else {
            $result['data'] = [];
            $users = $this->objectController->listUser('gm = 0');
            foreach ($users as $user) {
                $user->setExp($user->getExp() + $exp);
                $this->objectController->editUser($user);
                $result['data'][] = $user->getDisplayData();
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postShortcutHP($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin() || !$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $hp = $request->getParam('hp');

        if (!isset($hp) || empty($hp)) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }
        if (!empty($id) && $id > 0) {
            $user = $this->objectController->getUser($id);
            $ar = explode(';', $user->getHp());
            $ar[1] += $hp;
            $user->setHp(implode(';', $ar));
            $this->objectController->editUser($user);
            $result['data'] = $user->getDisplayData();
        } else {
            $result['data'] = [];
            $users = $this->objectController->listUser('gm = 0');
            foreach ($users as $user) {
                $ar = explode(';', $user->getHp());
                $ar[1] += $hp;
                $user->setHp(implode(';', $ar));
                $this->objectController->editUser($user);
                $result['data'][] = $user->getDisplayData();
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postShortcutFullHP($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        $id = $request->getAttribute('id');

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(0));
        }

        if (!empty($id) && $id > 0) {
            $user = $this->objectController->getUser($id);
            $ar = explode(';', $user->getHp());
            $ar[User::IDX_HP_CURRENT] = $ar[User::IDX_HP_MAX];
            $user->setHp(implode(';', $ar));
            $this->objectController->editUser($user);
            $result['data'] = $user->getDisplayData();
        } else {
            $result['data'] = [];
            $users = $this->objectController->listUser('gm = 0');
            foreach ($users as $user) {
                $ar = explode(';', $user->getHp());
                $ar[User::IDX_HP_CURRENT] = $ar[User::IDX_HP_MAX];
                $user->setHp(implode(';', $ar));
                $this->objectController->editUser($user);
                $result['data'][] = $user->getDisplayData();
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postShortcutMoney($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        $id = $request->getAttribute('id');
        $cp = $request->getParam('cp');
        $sp = $request->getParam('sp');
        $ep = $request->getParam('ep');
        $gp = $request->getParam('gp');
        $pp = $request->getParam('pp');

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }

        if (!empty($id) && $id > 0) {
            $user = $this->objectController->getUser($id);
            $ar = explode(';', $user->getMoney());
            $ar[User::IDX_MONEY_CP] = (!empty($cp) ? $ar[User::IDX_MONEY_CP] + $cp : $ar[User::IDX_MONEY_CP] );
            $ar[User::IDX_MONEY_SP] = (!empty($sp) ? $ar[User::IDX_MONEY_SP] + $sp : $ar[User::IDX_MONEY_SP] );
            $ar[User::IDX_MONEY_EP] = (!empty($ep) ? $ar[User::IDX_MONEY_EP] + $ep : $ar[User::IDX_MONEY_EP] );
            $ar[User::IDX_MONEY_GP] = (!empty($gp) ? $ar[User::IDX_MONEY_GP] + $gp : $ar[User::IDX_MONEY_GP] );
            $ar[User::IDX_MONEY_PP] = (!empty($pp) ? $ar[User::IDX_MONEY_PP] + $pp : $ar[User::IDX_MONEY_PP] );
            $user->setMoney(implode(';', $ar));
            $this->objectController->editUser($user);
            $result['data'] = $user->getDisplayData();
        } else {
            $result['data'] = [];
            $users = $this->objectController->listUser('gm = 0');
            foreach ($users as $user) {
                $ar = explode(';', $user->getMoney());
                $ar[User::IDX_MONEY_CP] = (!empty($cp) ? $ar[User::IDX_MONEY_CP] + $cp : $ar[User::IDX_MONEY_CP] );
                $ar[User::IDX_MONEY_SP] = (!empty($sp) ? $ar[User::IDX_MONEY_SP] + $sp : $ar[User::IDX_MONEY_SP] );
                $ar[User::IDX_MONEY_EP] = (!empty($ep) ? $ar[User::IDX_MONEY_EP] + $ep : $ar[User::IDX_MONEY_EP] );
                $ar[User::IDX_MONEY_GP] = (!empty($gp) ? $ar[User::IDX_MONEY_GP] + $gp : $ar[User::IDX_MONEY_GP] );
                $ar[User::IDX_MONEY_PP] = (!empty($pp) ? $ar[User::IDX_MONEY_PP] + $pp : $ar[User::IDX_MONEY_PP] );
                $user->setMoney(implode(';', $ar));
                $this->objectController->editUser($user);
                $result['data'][] = $user->getDisplayData();
            }
        }


        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function datatableInfo($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }
        $fields = array(
            'date',
            'message'
        );
        $columns = $request->getParam('columns');
        $draw = $request->getParam('draw');
        $length = $request->getParam('length');
        $order = $request->getParam('order');
        $search = $request->getParam('search');
        $start = $request->getParam('start');
        $userId = $this->authController->getLoginId();

        #echo 'SELECT * FROM view_Inventory ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length,'characterId = ' . intval($userId));
        $stmt = $this->container->pdo->prepare('SELECT * FROM ' . \DND\Objects\Info::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length, 'message > "" AND userId = ' . intval($userId)));
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result['data'][] = (array) $rec;
        }
        $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Info::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, null, null, 'message > "" AND userId = ' . intval($userId)));
        $result['iTotalDisplayRecords'] = $res->rowCount();
        $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Info::tableName . ' WHERE message > "" AND userId = ' . intval($userId));
        $result['iTotalRecords'] = $res->rowCount();

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function datatableInventory($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }
        $fields = array(
            'id',
            'name',
            'description',
            'amount',
            'weight'
        );
        $columns = $request->getParam('columns');
        $draw = $request->getParam('draw');
        $length = $request->getParam('length');
        $order = $request->getParam('order');
        $search = $request->getParam('search');
        $start = $request->getParam('start');
        $userId = $this->authController->getLoginId();

        #echo 'SELECT * FROM view_Inventory ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length,'characterId = ' . intval($charId));
        $stmt = $this->container->pdo->prepare('SELECT * FROM view_inventory ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length, 'amount > 0 AND characterId = ' . intval($userId)));
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            if ($rec['knowledge'] == 0) {
                $rec['description'] = 'Ich weiß nicht was es ist aber es ist wunderschön!';
            } else {
                if ($rec['knowledge'] >= 1) {
                    $rec['description'] = nl2br($rec['description']) . '<br>';
                    $rec['description'] .=!empty($rec['ac']) ? '<b>AC:</b>' . $rec['ac'] . '<br>' : '';
                    $rec['description'] .=!empty($rec['strength']) ? '<b>Strength:</b>' . $rec['strength'] . '<br>' : '';
                    $rec['description'] .=!empty($rec['roll']) ? '<b>Roll:</b>' . $rec['roll'] . '<br>' : '';
                    $rec['description'] .=!empty($rec['dmg1']) ? '<b>Dmg1:</b>' . $rec['dmg1'] . '<br>' : '';
                    $rec['description'] .=!empty($rec['dmg2']) ? '<b>Dmg2:</b>' . $rec['dmg2'] . '<br>' : '';
                    $rec['description'] .=!empty($rec['dmgType']) ? '<b>DmgTyp:</b>' . $rec['dmgType'] . '<br>' : '';
                    $rec['description'] .=!empty($rec['property']) ? '<b>Eigenschaften:</b>' . $rec['property'] . '<br>' : '';
                    $rec['description'] .=!empty($rec['range']) ? '<b>Range:</b>' . $rec['range'] . '<br>' : '';
                }
                if ($rec['knowledge'] >= 2) {
                    if (!empty($rec['priceCP'] . $rec['priceSP'] . $rec['priceEP'] . $rec['priceGP'] . $rec['pricePP'])) {
                        $rec['description'] .= '<b>Preis:</b>' .
                                ($rec['priceCP'] > 0 ? $rec['priceCP'] . 'CP ' : '') .
                                ($rec['priceSP'] > 0 ? $rec['priceSP'] . 'SP ' : '') .
                                ($rec['priceEP'] > 0 ? $rec['priceEP'] . 'EP ' : '') .
                                ($rec['priceGP'] > 0 ? $rec['priceGP'] . 'GP ' : '') .
                                ($rec['pricePP'] > 0 ? $rec['pricePP'] . 'PP ' : '') . '<br>';
                    }
                    $rec['description'] .=!empty($rec['dmgType']) ? '<b>Modifier:</b>' . $rec['modifier'] . '<br>' : '';
                    $rec['description'] .=!empty($rec['dmgType']) ? '<b>Verflucht:</b>' . $rec['cursed'] . '<br>' : '';
                }
            }

            $result['data'][] = (array) $rec;
        }
        $res = $this->container->pdo->query('SELECT * FROM view_inventory ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, null, null, 'amount > 0 AND characterId = ' . intval($userId)));
        $result['iTotalDisplayRecords'] = $res->rowCount();
        $res = $this->container->pdo->query('SELECT * FROM view_inventory WHERE amount > 0 AND characterId = ' . intval($userId));
        $result['iTotalRecords'] = $res->rowCount();

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postDiary($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }
        $id = $this->authController->getLoginId();
        $user = $this->objectController->getUser($id);
        if ($user) {
            $user->setDiary($request->getParam('diary'));
            $this->objectController->editUser($user);
        }
        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postShortcutEquipt($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }

        $id = $this->authController->getLoginId();
        $user = $this->objectController->getUser($id);
        if ($user) {
            $iid = $request->getAttribute('id');
            $inventory = $this->objectController->getInventory($iid);
            $item = $this->objectController->getItem($inventory->getItemid());

            if ($inventory->getAmount() > 0 && $item->getWearable() > 0) {
                switch ($item->getWearable()) {
                    case \DND\Objects\Item::IDX_EQUIPT_SLOT_QUIVER:
                        if (empty($user->getEquipmentquiver1())) {
                            $user->setEquipmentquiver1($item->getId());
                            $inventory->setAmount($inventory->getAmount() - 1);
                        } else if (empty($user->getEquipmentquiver2())) {
                            $user->setEquipmentquiver2($item->getId());
                            $inventory->setAmount($inventory->getAmount() - 1);
                        } else if (empty($user->getEquipmentquiver3())) {
                            $user->setEquipmentquiver3($item->getId());
                            $inventory->setAmount($inventory->getAmount() - 1);
                        } else {
                            $oldItem = $user->getEquipmentquiver1();
                            if ($this->checkCurseFromItem($oldItem)) {
                                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
                            }
                            $oldInventory = $this->objectController->listInventory('characterId = ' . $user->getId() . ' AND itemId=' . $oldItem);
                            foreach ($oldInventory as $oi) {
                                $oi->setAmount($oi->getAmount() + 1);
                                $this->objectController->editInventory($oi);
                            }
                            $user->setEquipmentquiver1($item->getId());
                            $inventory->setAmount($inventory->getAmount() - 1);
                        }
                        break;
                    case \DND\Objects\Item::IDX_EQUIPT_SLOT_HELMET:
                        if (!empty($user->getEquipmenthelmet())) {
                            $oldItem = $user->getEquipmenthelmet();
                            if ($this->checkCurseFromItem($oldItem)) {
                                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
                            }
                            $oldInventory = $this->objectController->listInventory('characterId = ' . $user->getId() . ' AND itemId=' . $oldItem);
                            foreach ($oldInventory as $oi) {
                                $oi->setAmount($oi->getAmount() + 1);
                                $this->objectController->editInventory($oi);
                            }
                        }
                        $user->setEquipmenthelmet($item->getId());
                        $inventory->setAmount($inventory->getAmount() - 1);
                        break;
                    case \DND\Objects\Item::IDX_EQUIPT_SLOT_CAPE:
                        if (!empty($user->getEquipmentcape())) {
                            $oldItem = $user->getEquipmentcape();
                            if ($this->checkCurseFromItem($oldItem)) {
                                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
                            }
                            $oldInventory = $this->objectController->listInventory('characterId = ' . $user->getId() . ' AND itemId=' . $oldItem);
                            foreach ($oldInventory as $oi) {
                                $oi->setAmount($oi->getAmount() + 1);
                                $this->objectController->editInventory($oi);
                            }
                        }
                        $user->setEquipmentcape($item->getId());
                        $inventory->setAmount($inventory->getAmount() - 1);
                        break;
                    case \DND\Objects\Item::IDX_EQUIPT_SLOT_NECKLACE:
                        if (!empty($user->getEquipmentnecklace())) {
                            $oldItem = $user->getEquipmentnecklace();
                            if ($this->checkCurseFromItem($oldItem)) {
                                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
                            }
                            $oldInventory = $this->objectController->listInventory('characterId = ' . $user->getId() . ' AND itemId=' . $oldItem);
                            foreach ($oldInventory as $oi) {
                                $oi->setAmount($oi->getAmount() + 1);
                                $this->objectController->editInventory($oi);
                            }
                        }
                        $user->setEquipmentnecklace($item->getId());
                        $inventory->setAmount($inventory->getAmount() - 1);
                        break;
                    case \DND\Objects\Item::IDX_EQUIPT_SLOT_GLOVES:
                        if (!empty($user->getEquipmentgloves())) {
                            $oldItem = $user->getEquipmentgloves();
                            if ($this->checkCurseFromItem($oldItem)) {
                                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
                            }
                            $oldInventory = $this->objectController->listInventory('characterId = ' . $user->getId() . ' AND itemId=' . $oldItem);
                            foreach ($oldInventory as $oi) {
                                $oi->setAmount($oi->getAmount() + 1);
                                $this->objectController->editInventory($oi);
                            }
                        }
                        $user->setEquipmentgloves($item->getId());
                        $inventory->setAmount($inventory->getAmount() - 1);
                        break;
                    case \DND\Objects\Item::IDX_EQUIPT_SLOT_RING:
                        if (empty($user->getEquipmentring1())) {
                            $user->setEquipmentring1($item->getId());
                            $inventory->setAmount($inventory->getAmount() - 1);
                        } else if (empty($user->getEquipmentring2())) {
                            $user->setEquipmentring2($item->getId());
                            $inventory->setAmount($inventory->getAmount() - 1);
                        } else {
                            $oldItem = $user->getEquipmentring1();
                            if ($this->checkCurseFromItem($oldItem)) {
                                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
                            }
                            $oldInventory = $this->objectController->listInventory('characterId = ' . $user->getId() . ' AND itemId=' . $oldItem);
                            foreach ($oldInventory as $oi) {
                                $oi->setAmount($oi->getAmount() + 1);
                                $this->objectController->editInventory($oi);
                            }
                            $user->setEquipmentring1($item->getId());
                            $inventory->setAmount($inventory->getAmount() - 1);
                        }
                        break;
                    case \DND\Objects\Item::IDX_EQUIPT_SLOT_ARMOR:
                        if (!empty($user->getEquipmentarmor())) {
                            $oldItem = $user->getEquipmentarmor();
                            if ($this->checkCurseFromItem($oldItem)) {
                                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
                            }
                            $oldInventory = $this->objectController->listInventory('characterId = ' . $user->getId() . ' AND itemId=' . $oldItem);
                            foreach ($oldInventory as $oi) {
                                $oi->setAmount($oi->getAmount() + 1);
                                $this->objectController->editInventory($oi);
                            }
                        }
                        $user->setEquipmentarmor($item->getId());
                        $inventory->setAmount($inventory->getAmount() - 1);
                        break;
                    case \DND\Objects\Item::IDX_EQUIPT_SLOT_WEAPON:
                        if (empty($user->getEquipmentweapon1())) {
                            $user->setEquipmentweapon1($item->getId());
                            $inventory->setAmount($inventory->getAmount() - 1);
                        } else if (empty($user->getEquipmentweapon2())) {
                            $user->setEquipmentweapon2($item->getId());
                            $inventory->setAmount($inventory->getAmount() - 1);
                        } else if (empty($user->getEquipmentweapon3())) {
                            $user->setEquipmentweapon3($item->getId());
                            $inventory->setAmount($inventory->getAmount() - 1);
                        } else {
                            $oldItem = $user->getEquipmentweapon1();
                            if ($this->checkCurseFromItem($oldItem)) {
                                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
                            }
                            $oldInventory = $this->objectController->listInventory('characterId = ' . $user->getId() . ' AND itemId=' . $oldItem);
                            foreach ($oldInventory as $oi) {
                                $oi->setAmount($oi->getAmount() + 1);
                                $this->objectController->editInventory($oi);
                            }
                            $user->setEquipmentweapon1($item->getId());
                            $inventory->setAmount($inventory->getAmount() - 1);
                        }
                        break;
                    case \DND\Objects\Item::IDX_EQUIPT_SLOT_OFF_WEAPON:
                        if (!empty($user->getEquipmentoffweapon())) {
                            $oldItem = $user->getEquipmentoffweapon();
                            if ($this->checkCurseFromItem($oldItem)) {
                                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
                            }
                            $oldInventory = $this->objectController->listInventory('characterId = ' . $user->getId() . ' AND itemId=' . $oldItem);
                            foreach ($oldInventory as $oi) {
                                $oi->setAmount($oi->getAmount() + 1);
                                $this->objectController->editInventory($oi);
                            }
                        }
                        $user->setEquipmentoffweapon($item->getId());
                        $inventory->setAmount($inventory->getAmount() - 1);
                        break;
                    case \DND\Objects\Item::IDX_EQUIPT_SLOT_BELT:
                        if (!empty($user->getEquipmentbelt())) {
                            $oldItem = $user->getEquipmentbelt();
                            if ($this->checkCurseFromItem($oldItem)) {
                                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
                            }
                            $oldInventory = $this->objectController->listInventory('characterId = ' . $user->getId() . ' AND itemId=' . $oldItem);
                            foreach ($oldInventory as $oi) {
                                $oi->setAmount($oi->getAmount() + 1);
                                $this->objectController->editInventory($oi);
                            }
                        }
                        $user->setEquipmentbelt($item->getId());
                        $inventory->setAmount($inventory->getAmount() - 1);
                        break;
                    case \DND\Objects\Item::IDX_EQUIPT_SLOT_BOOTS:
                        if (!empty($user->getEquipmentboots())) {
                            $oldItem = $user->getEquipmentboots();
                            if ($this->checkCurseFromItem($oldItem)) {
                                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
                            }
                            $oldInventory = $this->objectController->listInventory('characterId = ' . $user->getId() . ' AND itemId=' . $oldItem);
                            foreach ($oldInventory as $oi) {
                                $oi->setAmount($oi->getAmount() + 1);
                                $this->objectController->editInventory($oi);
                            }
                        }
                        $user->setEquipmentboots($item->getId());
                        $inventory->setAmount($inventory->getAmount() - 1);
                        break;
                }
                $this->objectController->editUser($user);
                $this->objectController->editInventory($inventory);
            }
        }
        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    private function checkCurseFromItem($itemId) {
        $item = $this->objectController->getItem($itemId);
        return $item->getCursed() > 0;
    }

    public function postShortcutUnequipt($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }
        $id = $this->authController->getLoginId();
        $user = $this->objectController->getUser($id);
        if ($user) {
            $iid = $request->getAttribute('id');
            $item = $this->objectController->getItem($iid);
            if ($item->getCursed() < 1) {
                if ($user->getEquipmentquiver1() == $iid)
                    $user->setEquipmentquiver1(NULL);
                if ($user->getEquipmentquiver2() == $iid)
                    $user->setEquipmentquiver2(NULL);
                if ($user->getEquipmentquiver3() == $iid)
                    $user->setEquipmentquiver3(NULL);
                if ($user->getEquipmenthelmet() == $iid)
                    $user->setEquipmenthelmet(NULL);
                if ($user->getEquipmentcape() == $iid)
                    $user->setEquipmentcape(NULL);
                if ($user->getEquipmentnecklace() == $iid)
                    $user->setEquipmentnecklace(NULL);
                if ($user->getEquipmentweapon1() == $iid)
                    $user->setEquipmentweapon1(NULL);
                if ($user->getEquipmentweapon2() == $iid)
                    $user->setEquipmentweapon2(NULL);
                if ($user->getEquipmentweapon3() == $iid)
                    $user->setEquipmentweapon3(NULL);
                if ($user->getEquipmentoffweapon() == $iid)
                    $user->setEquipmentoffweapon(NULL);
                if ($user->getEquipmentgloves() == $iid)
                    $user->setEquipmentgloves(NULL);
                if ($user->getEquipmentarmor() == $iid)
                    $user->setEquipmentarmor(NULL);
                if ($user->getEquipmentobject() == $iid)
                    $user->setEquipmentobject(NULL);
                if ($user->getEquipmentbelt() == $iid)
                    $user->setEquipmentbelt(NULL);
                if ($user->getEquipmentboots() == $iid)
                    $user->setEquipmentboots(NULL);
                if ($user->getEquipmentring1() == $iid)
                    $user->setEquipmentring1(NULL);
                if ($user->getEquipmentring2() == $iid)
                    $user->setEquipmentring2(NULL);


                $find = $this->objectController->listInventory('characterId = ' . $user->getId() . ' AND itemId = ' . intval($iid));
                if (count($find) == 1) {
                    $find[0]->setAmount($find[0]->getAmount() + 1);
                    $this->objectController->editInventory($find[0]);
                } else {
                    $new = new \DND\Objects\Inventory();
                    $new->setCharacterid($user->getId())->setItemid($iid)->setKnowledge(\DND\Objects\Inventory::IDX_KNOWLEDGE_UNKNOWN)->setAmount(1);
                    $this->objectController->addInventory($new);
                }
                $this->objectController->editUser($user);
            }
        }
        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postShortcutTrade($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }
        $id = $this->authController->getLoginId();
        $user = $this->objectController->getUser($id);
        if ($user) {
            $params = $request->getParams();
            $params['amount'] = abs($params['amount']);
            $iid = $request->getAttribute('id');

            $inventory = $this->objectController->getInventory($iid);
            if ($params['amount'] > $inventory->getAmount()) {
                $params['amount'] = $inventory->getAmount();
            }

            $search = $this->objectController->listInventory('characterId = ' . intval($params['userId']) . ' AND itemId = ' . intval($inventory->getItemid()));
            if (count($search) == 1) {
                $edit = $search[0];
                $edit->setAmount($edit->getAmount() + $params['amount']);
                if ($edit->getKnowledge() > $inventory->getKnowledge())
                    $edit->setKnowledge($inventory->getKnowledge());
                $this->objectController->editInventory($edit);
            }else {
                $new = new \DND\Objects\Inventory();
                $new->setCharacterid($params['userId'])->setItemid($inventory->getItemid())->setAmount($params['amount'])->setKnowledge($inventory->getKnowledge());
                $this->objectController->addInventory($new);
            }

            $inventory->setAmount($inventory->getAmount() - $params['amount']);
            $this->objectController->editInventory($inventory);
        }
        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postShortcutDrop($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(4));
        }
        $id = $this->authController->getLoginId();
        $user = $this->objectController->getUser($id);
        if ($user) {
            $params = $request->getParams();
            $params['amount'] = abs($params['amount']);
            $iid = $request->getAttribute('id');

            $inventory = $this->objectController->getInventory($iid);
            if ($params['amount'] > $inventory->getAmount()) {
                $params['amount'] = $inventory->getAmount();
            }
            $inventory->setAmount($inventory->getAmount() - $params['amount']);
            $this->objectController->editInventory($inventory);
        }
        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

}
