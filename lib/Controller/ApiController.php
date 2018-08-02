<?php

namespace DND\Controller;

use DND\Helper\ApiHelper;
use DND\Core\ObjectHandler;
use DND\Core\Calendar;
use DND\Objects\User;

class ApiController extends Controller {

    private $authController;
    private $objectController;

    public function __construct(\Slim\Container &$container) {
        parent::__construct($container);
        $this->authController = new AuthController($container);
        $this->objectController = new ObjectHandler($container->pdo);
    }

    function postUserGive($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage()); // Kein Login
        }

        $id = $request->getAttribute('id');
        if (!isset($id) || $id <= 0) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage()); // Kein Object ausgewählt
        }
        $params = $request->getParams();
        if (!isset($params['amount']) || !isset($params['user']) || $params['amount'] <= 0 || $params['user'] == $this->authController->getLoginId()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage()); // Menge/User nicht Definiert oder kleiner 0
        }
        $obj = $this->objectController->getInventory($id);
        if ($obj->getCharacterid() != $this->authController->getLoginId()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage()); // Gehört nicht den User
        }

        $search = $this->objectController->listInventory('characterId = ' . intval($params['user']) . '  AND itemId = ' . intval($obj->getItemid()) . ' ORDER BY `name`');
        if (count($search) == 1) { // Benutzer hat schon das Item oder das Wissen dazu
            $search[0]->setAmount($search[0]->getAmount() + $params['amount']);
            if (!$this->objectController->editInventory($search[0])) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage()); // Konnte nicht bearbeitet werden
            }
        } else { // Benutzer bekommt das Item
            $inv = clone $obj;
            $inv->setAmount($params['amount']);
            $inv->setCharacterid($params['user']);
            if (!$this->objectController->addInventory($inv)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage()); // Konnte nicht bearbeitet werden
            }
        }

        $obj->setAmount($obj->getAmount() - $params['amount']);
        if (!$this->objectController->editInventory($obj)) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage()); // Konnte nicht bearbeitet werden
        }

        return $response->withStatus(200)->withJson($result);
    }

    function postUserInventory($request, $response, $args) { // Bei Usern nur für die Bearbeitung der Anzahl nach unten
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage()); // Kein Login
        }

        $id = $request->getAttribute('id');
        if (!isset($id) || $id <= 0) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage()); // Kein Object ausgewählt
        }
        $params = $request->getParams();
        if (!isset($params['amount'])) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage()); // Menge nicht Definiert
        }
        $obj = $this->objectController->getInventory($id);
        if ($obj->getCharacterid() != $this->authController->getLoginId()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage()); // Gehört nicht den User
        }
        $obj->setAmount($obj->getAmount() - abs($params['amount'])); // Ziehe den Absoluten Wert ab (Wer denkt er bekommt bei negativen Zahlen ein plus irrt sich ;) )
        if ($obj->getAmount() < 0) {    // Wenn es kleiner 0 ist dann 0
            $obj->setAmount(0);
        }

        if (!$this->objectController->editInventory($obj)) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage()); // Konnte nicht bearbeitet werden
        }

        return $response->withStatus(200)->withJson($result);
    }

    function postGMInventory($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $params = $request->getParams();
        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getInventory($id);
            $obj->fillFromPost($params);
            if (!$this->objectController->editInventory($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        } else {
            $obj = new \DND\Objects\Inventory();
            $obj->fillFromPost($params);
            if (!$this->objectController->addInventory($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }
        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postAuthLogin($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        $username = $request->getParam('username');
        $password = $request->getParam('password');

        if (empty($username) || empty($password)) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(1));
        }

        $password = \DND\Helper\CryptoHelper::Crypt($password, 50, $this->container->salt);
        $search = $this->objectController->listUser('active = 1 AND mail = ' . $this->container->pdo->quote($username) . ' and `password` = ' . $this->container->pdo->quote($password) . ' ORDER BY `mail`');
        if (count($search) != 1) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(2));
        }

        $user = $search[0];
        $user->setLastLogin(date('Y-m-d H:i:s'));
        $user->setLastIp($_SERVER['REMOTE_ADDR']);
        if (!$this->objectController->editUser($user)) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(3));
        }

        $this->authController->login($user->getId(), $_SERVER['REMOTE_ADDR'], $user->getGm());

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function datatableItem($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }
        $fields = array(
            'id',
            'name',
            'description',
            'modifier',
            'rarity'
        );
        $columns = $request->getParam('columns');
        $draw = $request->getParam('draw');
        $length = $request->getParam('length');
        $order = $request->getParam('order');
        $search = $request->getParam('search');
        $start = $request->getParam('start');

        #echo 'SELECT * FROM view_Item ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length);
        $stmt = $this->container->pdo->prepare('SELECT * FROM ' . \DND\Objects\Item::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length));
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result['data'][] = (array) $rec;
        }
        $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Item::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order));
        $result['iTotalDisplayRecords'] = $res->rowCount();
        $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Item::tableName . '');
        $result['iTotalRecords'] = $res->rowCount();

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function getItem($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $value = $request->getAttribute('value');
        if (isset($id) && $id >= 0 && !isset($value)) {
            $a = $this->objectController->getItem($id);
            $result['data'] = $a->getAjax();
        } else {
            $search = [];
            if (isset($id) && isset($value)) {
                foreach (explode('|', $value) as $v) {
                    $search[] = '(`' . $id . '` = "' . $value . '")';
                }
            }
            $a = $this->objectController->listItem(implode(' OR ', $search));
            foreach ($a as $aa) {
                $result['data'][] = $aa->getAjax();
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postItem($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $params = $request->getParams();

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getItem($id);
            $obj->fillFromPost($params);
            if (!$this->objectController->editItem($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        } else {
            // Item Bearbeiten
            $obj = new \DND\Objects\Item();
            $obj->fillFromPost($params);

            if (!$this->objectController->addItem($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function deleteItem($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getItem($id);
            if (!$this->objectController->delItem($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }
        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function datatableEnvironment($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }
        $fields = array(
            'id',
            'name',
            'modifier',
            'id'
        );
        $columns = $request->getParam('columns');
        $draw = $request->getParam('draw');
        $length = $request->getParam('length');
        $order = $request->getParam('order');
        $search = $request->getParam('search');
        $start = $request->getParam('start');

        #echo 'SELECT * FROM view_Environment ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length);
        $stmt = $this->container->pdo->prepare('SELECT * FROM ' . \DND\Objects\Environment::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length));
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result['data'][] = (array) $rec;
        }
        $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Environment::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order));
        $result['iTotalDisplayRecords'] = $res->rowCount();
        $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Environment::tableName . '');
        $result['iTotalRecords'] = $res->rowCount();

        return $response
                        ->withStatus(200)
                        ->withJson($result);
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
            $a = $this->objectController->listEnvironment((isset($value) && isset($id)) ? '`' . $id . '` = "' . $value . '" ORDER BY `name`' : ' ORDER BY `name`');
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
        } else {
            // Environment Bearbeiten
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

    public function datatableSpell($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }
        $fields = array(
            'id',
            'name',
            'description'
        );
        $columns = $request->getParam('columns');
        $draw = $request->getParam('draw');
        $length = $request->getParam('length');
        $order = $request->getParam('order');
        $search = $request->getParam('search');
        $start = $request->getParam('start');

        #echo 'SELECT * FROM view_Spell ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length);
        $stmt = $this->container->pdo->prepare('SELECT * FROM ' . \DND\Objects\Spell::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length));
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result['data'][] = (array) $rec;
        }
        $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Spell::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order));
        $result['iTotalDisplayRecords'] = $res->rowCount();
        $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Spell::tableName . '');
        $result['iTotalRecords'] = $res->rowCount();

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function getSpell($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $value = $request->getAttribute('value');
        if (isset($id) && $id >= 0 && !isset($value)) {
            $a = $this->objectController->getSpell($id);
            $result['data'] = $a->getAjax();
        } else {
            $search = [];
            if (isset($id) && isset($value)) {
                foreach (explode('|', $value) as $v) {
                    $search[] = '(`' . $id . '` = "' . $value . '")';
                }
            }
            $a = $this->objectController->listSpell(implode(' OR ', $search));
            foreach ($a as $aa) {
                $result['data'][] = $aa->getAjax();
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postSpell($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $params = $request->getParams();

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getSpell($id);
            $obj->fillFromPost($params);
            if (!$this->objectController->editSpell($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        } else {
            // Spell Bearbeiten
            $obj = new \DND\Objects\Spell();
            $obj->fillFromPost($params);

            if (!$this->objectController->addSpell($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function deleteSpell($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getSpell($id);
            if (!$this->objectController->delSpell($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }
        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function datatableInventory($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isGm()) {
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
        $charId = $request->getParam('characterId');
        if (empty($charId)) {
            $charId = 0;
        }
        #echo 'SELECT * FROM view_Inventory ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length,'characterId = ' . intval($charId));
        $stmt = $this->container->pdo->prepare('SELECT * FROM view_inventory ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length, 'characterId = ' . intval($charId)));
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result['data'][] = (array) $rec;
        }
        $res = $this->container->pdo->query('SELECT * FROM view_inventory ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, null, null, 'characterId = ' . intval($charId)));
        $result['iTotalDisplayRecords'] = $res->rowCount();
        $res = $this->container->pdo->query('SELECT * FROM view_inventory WHERE characterId = ' . intval($charId));
        $result['iTotalRecords'] = $res->rowCount();

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function getInventory($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $value = $request->getAttribute('value');
        if (isset($id) && $id >= 0 && !isset($value)) {
            $a = $this->objectController->getInventory($id);
            $result['data'] = $a->getAjax();
        } else {
            $a = $this->objectController->listInventory((isset($value) && isset($id)) ? '`' . $id . '` = "' . $value . '" ORDER BY `name`' : ' ORDER BY `name`');
            foreach ($a as $aa) {
                $result['data'][] = $aa->getAjax();
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postInventory($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $params = $request->getParams();

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getInventory($id);
            $obj->fillFromPost($params);
            if (!$this->objectController->editInventory($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        } else {
            $obj = new \DND\Objects\Inventory();
            $obj->fillFromPost($params);

            $check = $this->objectController->listInventory('characterId = ' . intval($obj->getCharacterid()) . ' AND itemId = ' . intval($obj->getItemid()));
            if (count($check) > 0) {
                $inv = $check[0];
                $inv->setAmount($inv->getAmount() + $obj->getAmount());
                if ($obj->getKnowledge() > $inv->getKnowledge()) {
                    $inv->setKnowledge($obj->getKnowledge());
                }
                if (!$this->objectController->editInventory($inv)) {
                    return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
                }
            } else {
                if (!$this->objectController->addInventory($obj)) {
                    return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
                }
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function deleteInventory($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getInventory($id);
            if (!$this->objectController->delInventory($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }
        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function datatableUser($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }
        $fields = array(
            'id',
            'mail',
            'charname'
        );
        $columns = $request->getParam('columns');
        $draw = $request->getParam('draw');
        $length = $request->getParam('length');
        $order = $request->getParam('order');
        $search = $request->getParam('search');
        $start = $request->getParam('start');

        #echo 'SELECT * FROM view_User ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length);
        $stmt = $this->container->pdo->prepare('SELECT * FROM ' . \DND\Objects\User::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length));
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result['data'][] = (array) $rec;
        }
        $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\User::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order));
        $result['iTotalDisplayRecords'] = $res->rowCount();
        $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\User::tableName . '');
        $result['iTotalRecords'] = $res->rowCount();

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function getUser($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $value = $request->getAttribute('value');
        if (isset($id) && $id >= 0 && !isset($value)) {
            $a = $this->objectController->getUser($id);
            $result['data'] = $a->getAjax();
        } else {
            $a = $this->objectController->listUser((isset($value) && isset($id)) ? '`' . $id . '` = "' . $value . '" ORDER BY `name`' : ' ORDER BY `name`');
            foreach ($a as $aa) {
                $result['data'][] = $aa->getAjax();
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postUser($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $params = $request->getParams();
        if (isset($params['password']) && !empty($params['password'])) {
            $params['password'] = \DND\Helper\CryptoHelper::Crypt($params['password'], 50, $this->container->salt);
        }

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getUser($id);
            $obj->fillFromPost($params);
            if (!$this->objectController->editUser($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        } else {
            // User Bearbeiten
            $obj = new \DND\Objects\User();
            $obj->fillFromPost($params);

            if (!$this->objectController->addUser($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function deleteUser($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getUser($id);
            if (!$this->objectController->delUser($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }
        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function datatableRaces($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }
        $fields = array(
            'id',
            'name',
            'size',
            'speed',
            'ability',
            'proficiency',
            'id'
        );
        $columns = $request->getParam('columns');
        $draw = $request->getParam('draw');
        $length = $request->getParam('length');
        $order = $request->getParam('order');
        $search = $request->getParam('search');
        $start = $request->getParam('start');

        $stmt = $this->container->pdo->prepare('SELECT * FROM ' . \DND\Objects\Races::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length));
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result['data'][] = (array) $rec;
        }
        $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Races::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, null, null));
        $result['iTotalDisplayRecords'] = $res->rowCount();
        $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Races::tableName);
        $result['iTotalRecords'] = $res->rowCount();

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function getRaces($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $value = $request->getAttribute('value');
        if (isset($id) && $id >= 0 && !isset($value)) {
            $a = $this->objectController->getRaces($id);
            $result['data'] = $a->getAjax();
        } else {
            $a = $this->objectController->listRaces((isset($value) && isset($id)) ? '`' . $id . '` = "' . $value . '" ORDER BY `name`' : ' ORDER BY `name`');
            foreach ($a as $aa) {
                $result['data'][] = $aa->getAjax();
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postRaces($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $params = $request->getParams();

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getRaces($id);
            $obj->fillFromPost($params);

            if (!$this->objectController->editRaces($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        } else {
            $obj = new \DND\Objects\Races();
            $obj->fillFromPost($params);

            if (!$this->objectController->addRaces($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function deleteRaces($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getRaces($id);
            if (!$this->objectController->delRaces($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }
        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function datatableClasses($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }
        $fields = array(
            'id',
            'name',
            'hd',
            'proficiency',
            'spellAbility',
        );
        $columns = $request->getParam('columns');
        $draw = $request->getParam('draw');
        $length = $request->getParam('length');
        $order = $request->getParam('order');
        $search = $request->getParam('search');
        $start = $request->getParam('start');

        #echo 'SELECT * FROM view_Classes ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length);
        $stmt = $this->container->pdo->prepare('SELECT * FROM ' . \DND\Objects\Classes::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length));
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result['data'][] = (array) $rec;
        }
        $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Classes::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order));
        $result['iTotalDisplayRecords'] = $res->rowCount();
        $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Classes::tableName . '');
        $result['iTotalRecords'] = $res->rowCount();

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function getClasses($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $value = $request->getAttribute('value');
        if (isset($id) && $id >= 0 && !isset($value)) {
            $a = $this->objectController->getClasses($id);
            $result['data'] = $a->getAjax();
        } else {
            $search = [];
            if (isset($id) && isset($value)) {
                foreach (explode('|', $value) as $v) {
                    $search[] = '(`' . $id . '` = "' . $value . '")';
                }
            }
            $a = $this->objectController->listClasses(implode(' OR ', $search));
            foreach ($a as $aa) {
                $result['data'][] = $aa->getAjax();
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postClasses($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $params = $request->getParams();

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getClasses($id);
            $obj->fillFromPost($params);
            if (!$this->objectController->editClasses($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        } else {
            // Classes Bearbeiten
            $obj = new \DND\Objects\Classes();
            $obj->fillFromPost($params);

            if (!$this->objectController->addClasses($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function deleteClasses($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getClasses($id);
            if (!$this->objectController->delClasses($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }
        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function datatableBackgrounds($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }
        $fields = array(
            'id',
            'name',
            'proficiency'
        );
        $columns = $request->getParam('columns');
        $draw = $request->getParam('draw');
        $length = $request->getParam('length');
        $order = $request->getParam('order');
        $search = $request->getParam('search');
        $start = $request->getParam('start');

        #echo 'SELECT * FROM view_Backgrounds ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length);
        $stmt = $this->container->pdo->prepare('SELECT * FROM ' . \DND\Objects\Backgrounds::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length));
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result['data'][] = (array) $rec;
        }
        $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Backgrounds::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order));
        $result['iTotalDisplayRecords'] = $res->rowCount();
        $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Backgrounds::tableName . '');
        $result['iTotalRecords'] = $res->rowCount();

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function getBackgrounds($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $value = $request->getAttribute('value');
        if (isset($id) && $id >= 0 && !isset($value)) {
            $a = $this->objectController->getBackgrounds($id);
            $result['data'] = $a->getAjax();
        } else {
            $search = [];
            if (isset($id) && isset($value)) {
                foreach (explode('|', $value) as $v) {
                    $search[] = '(`' . $id . '` = "' . $value . '")';
                }
            }
            $a = $this->objectController->listBackgrounds(implode(' OR ', $search));
            foreach ($a as $aa) {
                $result['data'][] = $aa->getAjax();
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postBackgrounds($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $params = $request->getParams();

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getBackgrounds($id);
            $obj->fillFromPost($params);
            if (!$this->objectController->editBackgrounds($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        } else {
            // Backgrounds Bearbeiten
            $obj = new \DND\Objects\Backgrounds();
            $obj->fillFromPost($params);

            if (!$this->objectController->addBackgrounds($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function deleteBackgrounds($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getBackgrounds($id);
            if (!$this->objectController->delBackgrounds($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }
        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

}
