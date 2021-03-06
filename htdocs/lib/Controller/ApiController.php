<?php

namespace DND\Controller;

use DND\Helper\ApiHelper;
use DND\Core\ObjectHandler;
use DND\Core\Calendar;
use DND\Objects\Account;

class ApiController extends Controller {

    const REACT = false;

    private $authController;
    private $objectController;

    public function __construct(\Slim\Container &$container) {
        parent::__construct($container);
        $this->authController = new AuthController($container);
        $this->objectController = new ObjectHandler($container->pdo);
    }

    function postAccountGive($request, $response, $args) {
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
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage()); // Menge/Account nicht Definiert oder kleiner 0
        }
        $obj = $this->objectController->getInventory($id);
        if ($obj->getCharacterid() != $this->authController->getLoginId()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage()); // Gehört nicht den Account
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

    function postAccountInventory($request, $response, $args) { // Bei Accountn nur für die Bearbeitung der Anzahl nach unten
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
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage()); // Gehört nicht den Account
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

    public function getAuthLogout($request, $response, $args) {
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

        $result = ApiHelper::getResponseDummy();
        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function getAuthCheck($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['success'] = false;

        if ($this->authController->isLogin()) {
            $result['success'] = true;
            $result['data'] = array();
            $result['data']['id'] = $this->authController->getLoginId();
            $result['data']['admin'] = true;

            if (!$this->authController->isGm()) {
                $result['data']['admin'] = false;
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
        $search = $this->objectController->listAccount('active = 1 AND mail = ' . $this->container->pdo->quote($username) . ' and `password` = ' . $this->container->pdo->quote($password) . ' ORDER BY `mail`');
        if (count($search) != 1) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage(2));
        }

        $user = $search[0];
        $user->setLastLogin(date('Y-m-d H:i:s'));
        $user->setLastIp($_SERVER['REMOTE_ADDR']);
        if (!$this->objectController->editAccount($user)) {
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
        if (!self::REACT) {
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
                $row = (array) $rec;
                $row['description'] = nl2br($row['description']);
                $result['data'][] = $row;
            }
            $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Item::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order));
            $result['iTotalDisplayRecords'] = $res->rowCount();
            $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Item::tableName . '');
            $result['iTotalRecords'] = $res->rowCount();
            return $response
                            ->withStatus(200)
                            ->withJson($result);
        } else {

            $fields = array(
                'id',
                'name',
                'description',
                'modifier',
                'rarity'
            );

            $page = !empty($request->getParam('page')) && $request->getParam('page') >= 0 ? \intval($request->getParam('page')) : 0;
            $pageSize = !empty($request->getParam('pageSize')) && $request->getParam('pageSize') >= 5 ? \intval($request->getParam('pageSize')) : 10;
            $sorted = !empty($request->getParam('sorted')) && \strlen($request->getParam('sorted')) > 0 ? \json_decode($request->getParam('sorted'), true) : [];
            $filtered = !empty($request->getParam('filtered')) && \strlen($request->getParam('filtered')) > 0 ? \json_decode($request->getParam('filtered'), true) : [];


            $query = 'SELECT * FROM ' . \DND\Objects\Item::tableName . ' ';

            $query_where = '';
            if (count($filtered) > 0) {
                $filter = [];
                foreach ($filtered as $x) {
                    if (!empty($x['id']) && \in_array($x['id'], $fields)) {
                        $filter[] = '(`' . $x['id'] . '` LIKE ' . $this->container->pdo->quote('%' . $x['value'] . '%') . ')';
                    }
                }
                if (count($filter) > 0) {
                    $query_where = 'WHERE ' . \implode(' AND ', $filter) . ' ';
                }
            }

            $query_order = '';
            if (count($sorted) > 0) {
                foreach ($sorted as $x) {
                    $query_order = 'ORDER BY `' . $x['id'] . '` ' . ($x['desc'] ? 'DESC' : 'ASC') . ' ';
                }
            }

            $query_limit = 'LIMIT ' . ($pageSize * ($page )) . ', ' . $pageSize;
            $stmt = $this->container->pdo->prepare($query . $query_where . $query_order . $query_limit);
            $stmt->execute();
            while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $result['data'][] = (array) $rec;
            }

            $recCount = $this->container->pdo->query('SELECT CEIL(count(*)/' . $pageSize . ') FROM ' . \DND\Objects\Item::tableName)->fetch(\PDO::FETCH_NUM);
            $result['pages'] = $recCount[0];

            return $response
                            ->withStatus(200)
                            ->withJson($result);
        }
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
        if (!self::REACT) {
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
        } else {
            $fields = array(
                'id',
                'name',
                'modifier'
            );

            $page = !empty($request->getParam('page')) && $request->getParam('page') >= 0 ? \intval($request->getParam('page')) : 0;
            $pageSize = !empty($request->getParam('pageSize')) && $request->getParam('pageSize') >= 5 ? \intval($request->getParam('pageSize')) : 10;
            $sorted = !empty($request->getParam('sorted')) && \strlen($request->getParam('sorted')) > 0 ? \json_decode($request->getParam('sorted'), true) : [];
            $filtered = !empty($request->getParam('filtered')) && \strlen($request->getParam('filtered')) > 0 ? \json_decode($request->getParam('filtered'), true) : [];
            $result['pageSize'] = $pageSize;

            $query = 'SELECT * FROM ' . \DND\Objects\Environment::tableName . ' ';

            $query_where = '';
            if (count($filtered) > 0) {
                $filter = [];
                foreach ($filtered as $x) {
                    if (!empty($x['id']) && \in_array($x['id'], $fields)) {
                        $filter[] = '(`' . $x['id'] . '` LIKE ' . $this->container->pdo->quote('%' . $x['value'] . '%') . ')';
                    }
                }
                if (count($filter) > 0) {
                    $query_where = 'WHERE ' . \implode(' AND ', $filter) . ' ';
                }
            }

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

            $recCount = $this->container->pdo->query('SELECT CEIL(count(*)/' . $pageSize . ') FROM ' . \DND\Objects\Environment::tableName)->fetch(\PDO::FETCH_NUM);
            $result['pages'] = $recCount[0];

            return $response
                            ->withStatus(200)
                            ->withJson($result);
        }
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
            /*
              $a = \explode(',', $result['data']['mapShadow'], 2);
              $b = \explode(',', $result['data']['mapBG'], 2);
              $src = imagecreatefromstring(base64_decode($a[1]));
              $dest = imagecreatefromstring(base64_decode($b[1]));
              imagecopy($dest, $src, 0, 0, 0, 0, 770, 570);
              ob_start();
              imagepng($dest);
              $imageData = ob_get_contents();
              ob_end_clean();
              imagedestroy($src);
              imagedestroy($dest);
              $result['data']['map'] = $imageData;
             */
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
        if (!self::REACT) {
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
                $row = (array) $rec;
                $row['description'] = nl2br($row['description']);
                $result['data'][] = $row;
            }
            $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Spell::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order));
            $result['iTotalDisplayRecords'] = $res->rowCount();
            $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Spell::tableName . '');
            $result['iTotalRecords'] = $res->rowCount();
            return $response
                            ->withStatus(200)
                            ->withJson($result);
        } else {
            $fields = array(
                'id',
                'name',
                'description'
            );

            $page = !empty($request->getParam('page')) && $request->getParam('page') >= 0 ? \intval($request->getParam('page')) : 0;
            $pageSize = !empty($request->getParam('pageSize')) && $request->getParam('pageSize') >= 5 ? \intval($request->getParam('pageSize')) : 10;
            $sorted = !empty($request->getParam('sorted')) && \strlen($request->getParam('sorted')) > 0 ? \json_decode($request->getParam('sorted'), true) : [];
            $filtered = !empty($request->getParam('filtered')) && \strlen($request->getParam('filtered')) > 0 ? \json_decode($request->getParam('filtered'), true) : [];


            $query = 'SELECT * FROM ' . \DND\Objects\Spell::tableName . ' ';

            $query_where = '';
            if (count($filtered) > 0) {
                $filter = [];
                foreach ($filtered as $x) {
                    if (!empty($x['id']) && \in_array($x['id'], $fields)) {
                        $filter[] = '(`' . $x['id'] . '` LIKE ' . $this->container->pdo->quote('%' . $x['value'] . '%') . ')';
                    }
                }
                if (count($filter) > 0) {
                    $query_where = 'WHERE ' . \implode(' AND ', $filter) . ' ';
                }
            }

            $query_order = '';
            if (count($sorted) > 0) {
                foreach ($sorted as $x) {
                    $query_order = 'ORDER BY `' . $x['id'] . '` ' . ($x['desc'] ? 'DESC' : 'ASC') . ' ';
                }
            }

            $query_limit = 'LIMIT ' . ($pageSize * ($page )) . ', ' . $pageSize;
            $stmt = $this->container->pdo->prepare($query . $query_where . $query_order . $query_limit);
            $stmt->execute();
            while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $a = (array) $rec;
                $a['description'] = \nl2br($a['description']);
                $result['data'][] = $a;
            }

            $recCount = $this->container->pdo->query('SELECT CEIL(count(*)/' . $pageSize . ') FROM ' . \DND\Objects\Spell::tableName)->fetch(\PDO::FETCH_NUM);
            $result['pages'] = $recCount[0];

            return $response
                            ->withStatus(200)
                            ->withJson($result);
        }
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
        $knowledge = $request->getParam('knowledge');
        if (empty($charId)) {
            $charId = 0;
        }
        #echo 'SELECT * FROM view_Inventory ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length,'characterId = ' . intval($charId));
        $stmt = $this->container->pdo->prepare('SELECT * FROM view_inventory ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length, 'characterId = ' . intval($charId) . ($knowledge ? ' AND amount > 0' : '')));
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result['data'][] = (array) $rec;
        }
        $res = $this->container->pdo->query('SELECT * FROM view_inventory ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, null, null, 'characterId = ' . intval($charId) . ($knowledge ? ' AND amount > 0' : '')));
        $result['iTotalDisplayRecords'] = $res->rowCount();
        $res = $this->container->pdo->query('SELECT * FROM view_inventory WHERE characterId = ' . intval($charId) . ($knowledge ? ' AND amount > 0' : ''));
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

    public function datatableAccount($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }
        if (!self::REACT) {
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
            #echo 'SELECT * FROM view_Account ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length);
            $stmt = $this->container->pdo->prepare('SELECT * FROM ' . \DND\Objects\Account::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length));
            $stmt->execute();
            while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $result['data'][] = (array) $rec;
            }
            $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Account::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order));
            $result['iTotalDisplayRecords'] = $res->rowCount();
            $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Account::tableName . '');
            $result['iTotalRecords'] = $res->rowCount();
            return $response
                            ->withStatus(200)
                            ->withJson($result);
        } else {
            $fields = array(
                'active',
                'mail',
                'lastIp',
                'lastLogin',
                'id'
            );

            $page = !empty($request->getParam('page')) && $request->getParam('page') >= 0 ? \intval($request->getParam('page')) : 0;
            $pageSize = !empty($request->getParam('pageSize')) && $request->getParam('pageSize') >= 5 ? \intval($request->getParam('pageSize')) : 10;
            $sorted = !empty($request->getParam('sorted')) && \strlen($request->getParam('sorted')) > 0 ? \json_decode($request->getParam('sorted'), true) : [];
            $filtered = !empty($request->getParam('filtered')) && \strlen($request->getParam('filtered')) > 0 ? \json_decode($request->getParam('filtered'), true) : [];
            $result['pageSize'] = $pageSize;


            $query = 'SELECT * FROM ' . \DND\Objects\Account::tableName . ' ';

            $query_where = '';
            if (count($filtered) > 0) {
                $filter = [];
                foreach ($filtered as $x) {
                    if (!empty($x['id']) && \in_array($x['id'], $fields)) {
                        $filter[] = '(`' . $x['id'] . '` LIKE ' . $this->container->pdo->quote('%' . $x['value'] . '%') . ')';
                    }
                }
                if (count($filter) > 0) {
                    $query_where = 'WHERE ' . \implode(' AND ', $filter) . ' ';
                }
            }

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

            $recCount = $this->container->pdo->query('SELECT CEIL(count(*)/' . $pageSize . ') FROM ' . \DND\Objects\Account::tableName)->fetch(\PDO::FETCH_NUM);
            $result['pages'] = $recCount[0];

            return $response
                            ->withStatus(200)
                            ->withJson($result);
        }
    }

    function getAccount($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $value = $request->getAttribute('value');
        if (isset($id) && $id >= 0 && !isset($value)) {
            $a = $this->objectController->getAccount($id);
            $result['data'] = $a->getAjax();
        } else {
            $a = $this->objectController->listAccount((isset($value) && isset($id)) ? '`' . $id . '` = "' . $value . '" ORDER BY `name`' : ' ORDER BY `name`');
            foreach ($a as $aa) {
                $result['data'][] = $aa->getAjax();
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postAccount($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $params = $request->getParams();
        if (isset($params['password']) && !empty($params['password'])) {
            $params['password'] = \DND\Helper\CryptoHelper::Crypt($params['password'], 50, $this->container->salt);
        } elseif (isset($params['password'])) {
            unset($params['password']);
        }

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getAccount($id);
            $obj->fillFromPost($params);
            if (!$this->objectController->editAccount($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        } else {
            // Account Bearbeiten
            $obj = new \DND\Objects\Account();
            $obj->fillFromPost($params);

            if (!$this->objectController->addAccount($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function deleteAccount($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getAccount($id);
            if (!$this->objectController->delAccount($obj)) {
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
        if (!self::REACT) {
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
            $stmt = $this->container->pdo->prepare('SELECT id FROM ' . \DND\Objects\Races::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length));
            $stmt->execute();
            while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $i = $this->objectController->getRaces($rec['id']);
                $row = $i->getAjaxAll();
                $row['description'] = nl2br($row['description']);
                $row['traits'] = [];
                foreach ($this->objectController->listRacesTraits('raceId = ' . $rec['id']) as $t) {
                    $detail = $t->getAjax();
                    $tt = $this->objectController->getTraits($t->getTraitid());
                    if ($tt == null) {
                        $this->objectController->delRacesTraits($t);
                    } else {
                        $detail['trait'] = $tt->getAjax();
                        $row['traits'][] = $detail;
                    }
                }
                $result['data'][] = $row;
            }
            $res = $this->container->pdo->query('SELECT id FROM ' . \DND\Objects\Races::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, null, null));
            $result['iTotalDisplayRecords'] = $res->rowCount();
            $res = $this->container->pdo->query('SELECT id FROM ' . \DND\Objects\Races::tableName);
            $result['iTotalRecords'] = $res->rowCount();
            return $response
                            ->withStatus(200)
                            ->withJson($result);
        } else {
            $fields = array(
                'id',
                'name',
                'size',
                'speed',
                'ability',
                'proficiency',
                'id'
            );

            $page = !empty($request->getParam('page')) && $request->getParam('page') >= 0 ? \intval($request->getParam('page')) : 0;
            $pageSize = !empty($request->getParam('pageSize')) && $request->getParam('pageSize') >= 5 ? \intval($request->getParam('pageSize')) : 10;
            $sorted = !empty($request->getParam('sorted')) && \strlen($request->getParam('sorted')) > 0 ? \json_decode($request->getParam('sorted'), true) : [];
            $filtered = !empty($request->getParam('filtered')) && \strlen($request->getParam('filtered')) > 0 ? \json_decode($request->getParam('filtered'), true) : [];


            $query = 'SELECT * FROM ' . \DND\Objects\Races::tableName . ' ';

            $query_where = '';
            if (count($filtered) > 0) {
                $filter = [];
                foreach ($filtered as $x) {
                    if (!empty($x['id']) && \in_array($x['id'], $fields)) {
                        $filter[] = '(`' . $x['id'] . '` LIKE ' . $this->container->pdo->quote('%' . $x['value'] . '%') . ')';
                    }
                }
                if (count($filter) > 0) {
                    $query_where = 'WHERE ' . \implode(' AND ', $filter) . ' ';
                }
            }

            $query_order = '';
            if (count($sorted) > 0) {
                foreach ($sorted as $x) {
                    $query_order = 'ORDER BY `' . $x['id'] . '` ' . ($x['desc'] ? 'DESC' : 'ASC') . ' ';
                }
            }

            $query_limit = 'LIMIT ' . ($pageSize * ($page )) . ', ' . $pageSize;
            $stmt = $this->container->pdo->prepare($query . $query_where . $query_order . $query_limit);
            $stmt->execute();
            while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $a = (array) $rec;
                $a['description'] = ($a['description']);
                $result['data'][] = $a;
            }

            $recCount = $this->container->pdo->query('SELECT CEIL(count(*)/' . $pageSize . ') FROM ' . \DND\Objects\Races::tableName)->fetch(\PDO::FETCH_NUM);
            $result['pages'] = $recCount[0];

            return $response
                            ->withStatus(200)
                            ->withJson($result);
        }
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
            $result['data'] = $a->getAjaxAll();
        } else {
            $a = $this->objectController->listRaces((isset($value) && isset($id)) ? '`' . $id . '` = "' . $value . '" ORDER BY `name`' : ' ORDER BY `name`');
            foreach ($a as $aa) {
                $result['data'][] = $aa->getAjaxAll();
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
            $obj->fillFromPostAll($params);

            if (!$this->objectController->editRaces($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        } else {
            $obj = new \DND\Objects\Races();
            $obj->fillFromPostAll($params);

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

        if (!self::REACT) {
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
            $stmt = $this->container->pdo->prepare('SELECT id FROM ' . \DND\Objects\Classes::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length));
            $stmt->execute();
            while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $class = $this->objectController->getClasses($rec['id']);
                $row = $class->getAjaxAll();
                $row['levels'] = [];
                foreach ($this->objectController->listClassesLevel('`classId` = ' . $rec['id'] . ' ORDER BY `level` ASC,`kind` DESC') as $l) {
                    $d = $l->getAjax();
                    if ($l->getKind() == \DND\Objects\DNDConstantes::KIND_SLOT) {
                        $d['cleanKind'] = 'Slots';
                        $t = $this->objectController->getSlots($l->getKindid());
                        $d['clean'] = $t->getAjax();
                    } else if ($l->getKind() == \DND\Objects\DNDConstantes::KIND_FEATURE) {
                        $d['cleanKind'] = 'Feature';
                        $t = $this->objectController->getFeatures($l->getKindid());
                        $d['clean'] = $t->getAjax();
                    } else if ($l->getKind() == \DND\Objects\DNDConstantes::KIND_TRAIT) {
                        $d['cleanKind'] = 'Trait';
                        $t = $this->objectController->getTraits($l->getKindid());
                        $d['clean'] = $t->getAjax();
                    }
                    $row['levels'][] = $d;
                }
                $result['data'][] = $row;
            }
            $res = $this->container->pdo->query('SELECT id FROM ' . \DND\Objects\Classes::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order));
            $result['iTotalDisplayRecords'] = $res->rowCount();
            $res = $this->container->pdo->query('SELECT id FROM ' . \DND\Objects\Classes::tableName . '');
            $result['iTotalRecords'] = $res->rowCount();
            return $response
                            ->withStatus(200)
                            ->withJson($result);
        } else {
            $fields = array(
                'id',
                'name',
                'hd',
                'proficiency',
                'spellAbility',
            );

            $page = !empty($request->getParam('page')) && $request->getParam('page') >= 0 ? \intval($request->getParam('page')) : 0;
            $pageSize = !empty($request->getParam('pageSize')) && $request->getParam('pageSize') >= 5 ? \intval($request->getParam('pageSize')) : 10;
            $sorted = !empty($request->getParam('sorted')) && \strlen($request->getParam('sorted')) > 0 ? \json_decode($request->getParam('sorted'), true) : [];
            $filtered = !empty($request->getParam('filtered')) && \strlen($request->getParam('filtered')) > 0 ? \json_decode($request->getParam('filtered'), true) : [];


            $query = 'SELECT * FROM ' . \DND\Objects\Classes::tableName . ' ';

            $query_where = '';
            if (count($filtered) > 0) {
                $filter = [];
                foreach ($filtered as $x) {
                    if (!empty($x['id']) && \in_array($x['id'], $fields)) {
                        $filter[] = '(`' . $x['id'] . '` LIKE ' . $this->container->pdo->quote('%' . $x['value'] . '%') . ')';
                    }
                }
                if (count($filter) > 0) {
                    $query_where = 'WHERE ' . \implode(' AND ', $filter) . ' ';
                }
            }

            $query_order = '';
            if (count($sorted) > 0) {
                foreach ($sorted as $x) {
                    $query_order = 'ORDER BY `' . $x['id'] . '` ' . ($x['desc'] ? 'DESC' : 'ASC') . ' ';
                }
            }

            $query_limit = 'LIMIT ' . ($pageSize * ($page )) . ', ' . $pageSize;
            $stmt = $this->container->pdo->prepare($query . $query_where . $query_order . $query_limit);
            $stmt->execute();
            while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $a = (array) $rec;
                $a['description'] = ($a['description']);
                $result['data'][] = $a;
            }

            $recCount = $this->container->pdo->query('SELECT CEIL(count(*)/' . $pageSize . ') FROM ' . \DND\Objects\Classes::tableName)->fetch(\PDO::FETCH_NUM);
            $result['pages'] = $recCount[0];

            return $response
                            ->withStatus(200)
                            ->withJson($result);
        }
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
            $result['data'] = $a->getAjaxAll();
        } else {
            $search = [];
            if (isset($id) && isset($value)) {
                foreach (explode('|', $value) as $v) {
                    $search[] = '(`' . $id . '` = "' . $value . '")';
                }
            }
            $a = $this->objectController->listClasses(implode(' OR ', $search));
            foreach ($a as $aa) {
                $result['data'][] = $aa->getAjaxAll();
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
            $obj->fillFromPostAll($params);
            if (!$this->objectController->editClasses($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        } else {
            // Classes Bearbeiten
            $obj = new \DND\Objects\Classes();
            $obj->fillFromPostAll($params);

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
        if (!self::REACT) {
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
            $stmt = $this->container->pdo->prepare('SELECT id FROM ' . \DND\Objects\Backgrounds::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length));
            $stmt->execute();
            while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $background = $this->objectController->getBackgrounds($rec['id']);
                $row = $background->getAjaxAll();
                $row['traits'] = [];
                foreach ($this->objectController->listBackgroundsTraits('backgroundId = ' . $rec['id']) as $t) {
                    $detail = $t->getAjax();
                    $tt = $this->objectController->getTraits($t->getTraitid());
                    if ($tt == null) {
                        $this->objectController->delBackgroundsTraits($t);
                    } else {
                        $detail['trait'] = $tt->getAjax();
                        $row['traits'][] = $detail;
                    }
                }
                $result['data'][] = $row;
            }
            $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Backgrounds::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order));
            $result['iTotalDisplayRecords'] = $res->rowCount();
            $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Backgrounds::tableName . '');
            $result['iTotalRecords'] = $res->rowCount();
            return $response
                            ->withStatus(200)
                            ->withJson($result);
        } else {
            $fields = array(
                'id',
                'name',
                'proficiency'
            );

            $page = !empty($request->getParam('page')) && $request->getParam('page') >= 0 ? \intval($request->getParam('page')) : 0;
            $pageSize = !empty($request->getParam('pageSize')) && $request->getParam('pageSize') >= 5 ? \intval($request->getParam('pageSize')) : 10;
            $sorted = !empty($request->getParam('sorted')) && \strlen($request->getParam('sorted')) > 0 ? \json_decode($request->getParam('sorted'), true) : [];
            $filtered = !empty($request->getParam('filtered')) && \strlen($request->getParam('filtered')) > 0 ? \json_decode($request->getParam('filtered'), true) : [];
            $result['pageSize'] = $pageSize;

            $query = 'SELECT * FROM ' . \DND\Objects\Backgrounds::tableName . ' ';

            $query_where = '';
            if (count($filtered) > 0) {
                $filter = [];
                foreach ($filtered as $x) {
                    if (!empty($x['id']) && \in_array($x['id'], $fields)) {
                        $filter[] = '(`' . $x['id'] . '` LIKE ' . $this->container->pdo->quote('%' . $x['value'] . '%') . ')';
                    }
                }
                if (count($filter) > 0) {
                    $query_where = 'WHERE ' . \implode(' AND ', $filter) . ' ';
                }
            }

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
                $x['traits'] = [];
                foreach ($this->objectController->listBackgroundsTraits('`backgroundId` = ' . $rec['id']) as $bt) {
                    $a = $this->objectController->getTraits($bt->getTraitid());
                    $x['traits'][] = $a->getAjax();
                }
                $result['data'][] = $x;
            }

            $recCount = $this->container->pdo->query('SELECT CEIL(count(*)/' . $pageSize . ') FROM ' . \DND\Objects\Backgrounds::tableName)->fetch(\PDO::FETCH_NUM);
            $result['pages'] = $recCount[0];

            return $response
                            ->withStatus(200)
                            ->withJson($result);
        }
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
            $result['data'] = $a->getAjaxAll();
        } else {
            $search = [];
            if (isset($id) && isset($value)) {
                foreach (explode('|', $value) as $v) {
                    $search[] = '(`' . $id . '` = "' . $value . '")';
                }
            }
            $a = $this->objectController->listBackgrounds(implode(' OR ', $search));
            foreach ($a as $aa) {
                $result['data'][] = $aa->getAjaxAll();
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
            $obj->fillFromPostAll($params);
            if (!$this->objectController->editBackgrounds($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        } else {
            // Backgrounds Bearbeiten
            $obj = new \DND\Objects\Backgrounds();
            $obj->fillFromPostAll($params);

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

    public function datatableFeatures($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }
        if (!self::REACT) {
            $fields = array(
                'id',
                'name',
                'description',
                'modifier'
            );
            $columns = $request->getParam('columns');
            $draw = $request->getParam('draw');
            $length = $request->getParam('length');
            $order = $request->getParam('order');
            $search = $request->getParam('search');
            $start = $request->getParam('start');
            #echo 'SELECT * FROM view_Features ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length);
            $stmt = $this->container->pdo->prepare('SELECT * FROM ' . \DND\Objects\Features::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length));
            $stmt->execute();
            while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $row = (array) $rec;
                $row['description'] = nl2br($row['description']);
                $result['data'][] = $row;
            }
            $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Features::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order));
            $result['iTotalDisplayRecords'] = $res->rowCount();
            $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Features::tableName . '');
            $result['iTotalRecords'] = $res->rowCount();
            return $response
                            ->withStatus(200)
                            ->withJson($result);
        } else {

            $fields = array(
                'id',
                'name',
                'description',
                'modifier'
            );

            $page = !empty($request->getParam('page')) && $request->getParam('page') >= 0 ? \intval($request->getParam('page')) : 0;
            $pageSize = !empty($request->getParam('pageSize')) && $request->getParam('pageSize') >= 5 ? \intval($request->getParam('pageSize')) : 10;
            $sorted = !empty($request->getParam('sorted')) && \strlen($request->getParam('sorted')) > 0 ? \json_decode($request->getParam('sorted'), true) : [];
            $filtered = !empty($request->getParam('filtered')) && \strlen($request->getParam('filtered')) > 0 ? \json_decode($request->getParam('filtered'), true) : [];


            $query = 'SELECT * FROM ' . \DND\Objects\Features::tableName . ' ';

            $query_where = '';
            if (count($filtered) > 0) {
                $filter = [];
                foreach ($filtered as $x) {
                    if (!empty($x['id']) && \in_array($x['id'], $fields)) {
                        $filter[] = '(`' . $x['id'] . '` LIKE ' . $this->container->pdo->quote('%' . $x['value'] . '%') . ')';
                    }
                }
                if (count($filter) > 0) {
                    $query_where = 'WHERE ' . \implode(' AND ', $filter) . ' ';
                }
            }

            $query_order = '';
            if (count($sorted) > 0) {
                foreach ($sorted as $x) {
                    $query_order = 'ORDER BY `' . $x['id'] . '` ' . ($x['desc'] ? 'DESC' : 'ASC') . ' ';
                }
            }

            $query_limit = 'LIMIT ' . ($pageSize * ($page )) . ', ' . $pageSize;
            $stmt = $this->container->pdo->prepare($query . $query_where . $query_order . $query_limit);
            $stmt->execute();
            while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $a = (array) $rec;
                $a['description'] = ($a['description']);
                $result['data'][] = $a;
            }

            $recCount = $this->container->pdo->query('SELECT CEIL(count(*)/' . $pageSize . ') FROM ' . \DND\Objects\Features::tableName)->fetch(\PDO::FETCH_NUM);
            $result['pages'] = $recCount[0];

            return $response
                            ->withStatus(200)
                            ->withJson($result);
        }
    }

    function getFeatures($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $value = $request->getAttribute('value');
        if (isset($id) && $id >= 0 && !isset($value)) {
            $a = $this->objectController->getFeatures($id);
            $result['data'] = $a->getAjax();
        } else {
            $search = [];
            if (isset($id) && isset($value)) {
                foreach (explode('|', $value) as $v) {
                    $search[] = '(`' . $id . '` = "' . $value . '")';
                }
            }
            $a = $this->objectController->listFeatures(implode(' OR ', $search));
            foreach ($a as $aa) {
                $result['data'][] = $aa->getAjax();
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postFeatures($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $params = $request->getParams();

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getFeatures($id);
            $obj->fillFromPost($params);
            if (!$this->objectController->editFeatures($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        } else {
            // Features Bearbeiten
            $obj = new \DND\Objects\Features();
            $obj->fillFromPost($params);

            if (!$this->objectController->addFeatures($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function deleteFeatures($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getFeatures($id);
            if (!$this->objectController->delFeatures($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }
        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function datatableTraits($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        if (!self::REACT) {
            $fields = array(
                'id',
                'name',
                'description',
                'modifier'
            );
            $columns = $request->getParam('columns');
            $draw = $request->getParam('draw');
            $length = $request->getParam('length');
            $order = $request->getParam('order');
            $search = $request->getParam('search');
            $start = $request->getParam('start');
            #echo 'SELECT * FROM view_Traits ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length);
            $stmt = $this->container->pdo->prepare('SELECT * FROM ' . \DND\Objects\Traits::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length));
            $stmt->execute();
            while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $row = (array) $rec;
                $row['description'] = nl2br($row['description']);
                $result['data'][] = $row;
            }
            $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Traits::tableName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order));
            $result['iTotalDisplayRecords'] = $res->rowCount();
            $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Traits::tableName . '');
            $result['iTotalRecords'] = $res->rowCount();
            return $response
                            ->withStatus(200)
                            ->withJson($result);
        } else {

            $fields = array(
                'id',
                'name',
                'description',
                'modifier'
            );

            $page = !empty($request->getParam('page')) && $request->getParam('page') >= 0 ? \intval($request->getParam('page')) : 0;
            $pageSize = !empty($request->getParam('pageSize')) && $request->getParam('pageSize') >= 5 ? \intval($request->getParam('pageSize')) : 10;
            $sorted = !empty($request->getParam('sorted')) && \strlen($request->getParam('sorted')) > 0 ? \json_decode($request->getParam('sorted'), true) : [];
            $filtered = !empty($request->getParam('filtered')) && \strlen($request->getParam('filtered')) > 0 ? \json_decode($request->getParam('filtered'), true) : [];


            $query = 'SELECT * FROM ' . \DND\Objects\Traits::tableName . ' ';

            $query_where = '';
            if (count($filtered) > 0) {
                $filter = [];
                foreach ($filtered as $x) {
                    if (!empty($x['id']) && \in_array($x['id'], $fields)) {
                        $filter[] = '(`' . $x['id'] . '` LIKE ' . $this->container->pdo->quote('%' . $x['value'] . '%') . ')';
                    }
                }
                if (count($filter) > 0) {
                    $query_where = 'WHERE ' . \implode(' AND ', $filter) . ' ';
                }
            }

            $query_order = '';
            if (count($sorted) > 0) {
                foreach ($sorted as $x) {
                    $query_order = 'ORDER BY `' . $x['id'] . '` ' . ($x['desc'] ? 'DESC' : 'ASC') . ' ';
                }
            }

            $query_limit = 'LIMIT ' . ($pageSize * ($page )) . ', ' . $pageSize;
            $stmt = $this->container->pdo->prepare($query . $query_where . $query_order . $query_limit);
            $stmt->execute();
            while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $a = (array) $rec;
                $a['description'] = ($a['description']);
                $result['data'][] = $a;
            }

            $recCount = $this->container->pdo->query('SELECT CEIL(count(*)/' . $pageSize . ') FROM ' . \DND\Objects\Traits::tableName)->fetch(\PDO::FETCH_NUM);
            $result['pages'] = $recCount[0];

            return $response
                            ->withStatus(200)
                            ->withJson($result);
        }
    }

    function getTraits($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $value = $request->getAttribute('value');
        if (isset($id) && $id >= 0 && !isset($value)) {
            $a = $this->objectController->getTraits($id);
            $result['data'] = $a->getAjax();
        } else {
            $search = [];
            if (isset($id) && isset($value)) {
                foreach (explode('|', $value) as $v) {
                    $search[] = '(`' . $id . '` = "' . $value . '")';
                }
            }
            $a = $this->objectController->listTraits(implode(' OR ', $search));
            foreach ($a as $aa) {
                $result['data'][] = $aa->getAjax();
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postTraits($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $params = $request->getParams();

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getTraits($id);
            $obj->fillFromPost($params);
            if (!$this->objectController->editTraits($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        } else {
            // Traits Bearbeiten
            $obj = new \DND\Objects\Traits();
            $obj->fillFromPost($params);

            if (!$this->objectController->addTraits($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function deleteTraits($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getTraits($id);
            if (!$this->objectController->delTraits($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }
        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function datatableCharacter($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }
        $fields = array(
            'charname',
            'raceId',
            'class1Id'
        );
        $columns = $request->getParam('columns');
        $draw = $request->getParam('draw');
        $length = $request->getParam('length');
        $order = $request->getParam('order');
        $search = $request->getParam('search');
        $start = $request->getParam('start');
        $filter = !empty($request->getParam('active')) ? '`aactive` = 1' : NULL;

        #echo 'SELECT * FROM view_Character ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length);
        $stmt = $this->container->pdo->prepare('SELECT * FROM ' . \DND\Objects\Character::viewName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, $start, $length, $filter));
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result['data'][] = (array) $rec;
        }
        $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Character::viewName . ' ' . ApiHelper::buildDatatableLimit($fields, $columns, $search, $order, NULL, NULL, $filter));
        $result['iTotalDisplayRecords'] = $res->rowCount();
        $res = $this->container->pdo->query('SELECT * FROM ' . \DND\Objects\Character::viewName . '');
        $result['iTotalRecords'] = $res->rowCount();

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function getCharacter($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $value = $request->getAttribute('value');
        if (isset($id) && $id >= 0 && !isset($value)) {
            $a = $this->objectController->getCharacter($id);
            $result['data'] = $a->getAjax();
        } else {
            $a = $this->objectController->listCharacter((isset($value) && isset($id)) ? '`' . $id . '` = "' . $value . '" ORDER BY `name`' : ' ORDER BY `name`');
            foreach ($a as $aa) {
                $result['data'][] = $aa->getAjax();
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postCharacter($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $params = $request->getParams();

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getCharacter($id);
            $obj->fillFromPostAll($params);
            if (!$this->objectController->editCharacter($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        } else {
            // Character Bearbeiten
            $obj = new \DND\Objects\Character();
            $obj->fillFromPostAll($params);

            if (!$this->objectController->addCharacter($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function deleteCharacter($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getCharacter($id);
            if (!$this->objectController->delCharacter($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }
        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function getBackgroundsTraits($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $value = $request->getAttribute('value');
        if (isset($id) && $id >= 0 && !isset($value)) {
            $a = $this->objectController->getBackgroundsTraits($id);
            $b = $this->objectController->getTraits($a->getTraitid());
            $result['data'] = $a->getAjax();
            $result['data']['_data'] = $b->getAjax();
        } else {
            $search = [];
            if (isset($id) && isset($value)) {
                foreach (explode('|', $value) as $v) {
                    $search[] = '(`' . $id . '` = "' . $value . '")';
                }
            }
            $a = $this->objectController->listBackgroundsTraits(implode(' OR ', $search));
            foreach ($a as $aa) {
                $b = $this->objectController->getTraits($aa->getTraitid());
                $tmp = $aa->getAjax();
                $tmp['_data'] = $b->getAjax();
                $result['data'][] = $tmp;
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postBackgroundsTraits($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $params = $request->getParams();

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getBackgroundsTraits($id);
            $obj->fillFromPost($params);
            if (!$this->objectController->editBackgroundsTraits($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        } else {
            // BackgroundsTraits Bearbeiten
            $obj = new \DND\Objects\BackgroundsTraits();
            $obj->fillFromPost($params);

            if (!$this->objectController->addBackgroundsTraits($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function deleteBackgroundsTraits($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getBackgroundsTraits($id);
            if (!$this->objectController->delBackgroundsTraits($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }
        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function getRacesTraits($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $value = $request->getAttribute('value');
        if (isset($id) && $id >= 0 && !isset($value)) {
            $a = $this->objectController->getRacesTraits($id);
            $b = $this->objectController->getTraits($a->getTraitid());
            $result['data'] = $a->getAjax();
            $result['data']['_data'] = $b->getAjax();
        } else {
            $search = [];
            if (isset($id) && isset($value)) {
                foreach (explode('|', $value) as $v) {
                    $search[] = '(`' . $id . '` = "' . $value . '")';
                }
            }
            $a = $this->objectController->listRacesTraits(implode(' OR ', $search));
            foreach ($a as $aa) {
                $b = $this->objectController->getTraits($aa->getTraitid());
                $tmp = $aa->getAjax();
                $tmp['_data'] = $b->getAjax();
                $result['data'][] = $tmp;
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function postRacesTraits($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');
        $params = $request->getParams();

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getRacesTraits($id);
            $obj->fillFromPost($params);
            if (!$this->objectController->editRacesTraits($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        } else {
            // RacesTraits Bearbeiten
            $obj = new \DND\Objects\RacesTraits();
            $obj->fillFromPost($params);

            if (!$this->objectController->addRacesTraits($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    function deleteRacesTraits($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();

        if (!$this->authController->isLogin()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $id = $request->getAttribute('id');

        if (isset($id) && $id >= 0) {
            $obj = $this->objectController->getRacesTraits($id);
            if (!$this->objectController->delRacesTraits($obj)) {
                return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
            }
        }
        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function optionsAccount($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $stmt = $this->container->pdo->prepare('SELECT id,`mail` FROM ' . \DND\Objects\Account::tableName . ' WHERE `gm` = 0');
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result['data'][] = ['value' => $rec['id'], 'text' => $rec['mail']];
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function optionsClass($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $stmt = $this->container->pdo->prepare('SELECT id,`name` FROM ' . \DND\Objects\Classes::tableName . ' ');
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result['data'][] = ['value' => $rec['id'], 'text' => $rec['name']];
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function optionsRace($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $stmt = $this->container->pdo->prepare('SELECT id,`name` FROM ' . \DND\Objects\Races::tableName . ' ');
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result['data'][] = ['value' => $rec['id'], 'text' => $rec['name']];
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function optionsBackground($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $stmt = $this->container->pdo->prepare('SELECT id,`name` FROM ' . \DND\Objects\Backgrounds::tableName . ' ');
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result['data'][] = ['value' => $rec['id'], 'text' => $rec['name']];
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function optionsEnvironment($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $stmt = $this->container->pdo->prepare('SELECT id,`name` FROM ' . \DND\Objects\Environment::tableName . ' ');
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result['data'][] = ['value' => $rec['id'], 'text' => $rec['name']];
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function optionsItems($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $type = $request->getAttribute('type');

        $stmt = $this->container->pdo->prepare('SELECT id,`name` FROM ' . \DND\Objects\Item::tableName . ' WHERE  `type` = ' . ($type));
        $stmt->execute();
        while ($rec = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result['data'][] = ['value' => $rec['id'], 'text' => $rec['name']];
        }

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

    public function getFullOptions($request, $response, $args) {
        $result = ApiHelper::getResponseDummy();
        $result['data'] = [];

        if (!$this->authController->isGm()) {
            return $response->withStatus(200)->withJson(ApiHelper::getErrorMessage());
        }

        $listItem = [['value' => 0, 'text' => '-']];
        $listRing = [['value' => 0, 'text' => '-']];
        $listQuiver = [['value' => 0, 'text' => '-']];
        $listHelmet = [['value' => 0, 'text' => '-']];
        $listCape = [['value' => 0, 'text' => '-']];
        $listNecklace = [['value' => 0, 'text' => '-']];
        $listWeapon = [['value' => 0, 'text' => '-']];
        $listOffWeapon = [['value' => 0, 'text' => '-']];
        $listGloves = [['value' => 0, 'text' => '-']];
        $listArmor = [['value' => 0, 'text' => '-']];
        $listBelt = [['value' => 0, 'text' => '-']];
        $listObject = [['value' => 0, 'text' => '-']];
        $listBoots = [['value' => 0, 'text' => '-']];
        $listEnvironment = [['value' => 0, 'text' => '-']];
        $listAccount = [['value' => 0, 'text' => '-']];
        $listBackground = [['value' => 0, 'text' => '-']];
        $listRace = [['value' => 0, 'text' => '-']];
        $listClass = [['value' => 0, 'text' => '-']];

        foreach ($this->objectController->listAccount('', ' ORDER BY `mail`') as $i) {
            $listAccount[] = ['value' => $i->getId(), 'text' => $i->getMail()];
        }
        foreach ($this->objectController->listBackgrounds('', ' ORDER BY `name`') as $i) {
            $listBackground[] = ['value' => $i->getId(), 'text' => $i->getName()];
        }
        foreach ($this->objectController->listClasses('', ' ORDER BY `name`') as $i) {
            $listClass[] = ['value' => $i->getId(), 'text' => $i->getName()];
        }
        foreach ($this->objectController->listRaces('', ' ORDER BY `name`') as $i) {
            $listRace[] = ['value' => $i->getId(), 'text' => $i->getName()];
        }
        foreach ($this->objectController->listEnvironment('', ' ORDER BY `name`') as $i) {
            $listEnvironment[] = ['value' => $i->getId(), 'text' => $i->getName()];
        }
        foreach ($this->objectController->listItem('', ' ORDER BY `name`') as $i) {
            $listItem[] = ['value' => $i->getId(), 'text' => $i->getName()];
            switch ($i->getWearable()) {
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_RING:
                    $listRing[] = ['value' => $i->getId(), 'text' => $i->getName()];
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_QUIVER:
                    $listQuiver[] = ['value' => $i->getId(), 'text' => $i->getName()];
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_HELMET:
                    $listHelmet[] = ['value' => $i->getId(), 'text' => $i->getName()];
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_CAPE:
                    $listCape[] = ['value' => $i->getId(), 'text' => $i->getName()];
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_NECKLACE:
                    $listNecklace[] = ['value' => $i->getId(), 'text' => $i->getName()];
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_WEAPON:
                    $listWeapon[] = ['value' => $i->getId(), 'text' => $i->getName()];
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_OFF_WEAPON:
                    $listOffWeapon[] = ['value' => $i->getId(), 'text' => $i->getName()];
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_GLOVES:
                    $listGloves[] = ['value' => $i->getId(), 'text' => $i->getName()];
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_ARMOR:
                    $listArmor[] = ['value' => $i->getId(), 'text' => $i->getName()];
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_BELT:
                    $listBelt[] = ['value' => $i->getId(), 'text' => $i->getName()];
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_NONE:
                    $listObject[] = ['value' => $i->getId(), 'text' => $i->getName()];
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_BOOTS:
                    $listBoots[] = ['value' => $i->getId(), 'text' => $i->getName()];
                    break;
            }
        }
        $result['data']['listItem'] = $listItem;
        $result['data']['listRing'] = $listRing;
        $result['data']['listQuiver'] = $listQuiver;
        $result['data']['listHelmet'] = $listHelmet;
        $result['data']['listCape'] = $listCape;
        $result['data']['listNecklace'] = $listNecklace;
        $result['data']['listWeapon'] = $listWeapon;
        $result['data']['listOffWeapon'] = $listOffWeapon;
        $result['data']['listGloves'] = $listGloves;
        $result['data']['listArmor'] = $listArmor;
        $result['data']['listBelt'] = $listBelt;
        $result['data']['listObject'] = $listObject;
        $result['data']['listBoots'] = $listBoots;
        $result['data']['listEnvironment'] = $listEnvironment;
        $result['data']['listAccount'] = $listAccount;
        $result['data']['listBackground'] = $listBackground;
        $result['data']['listRace'] = $listRace;
        $result['data']['listClass'] = $listClass;

        return $response
                        ->withStatus(200)
                        ->withJson($result);
    }

}
