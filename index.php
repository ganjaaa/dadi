<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/_config.php';
$app = new \Slim\App($settings);
$container = $app->getContainer();

$container['baseDir'] = function ($c) {
    return __DIR__;
};

$container['salt'] = function ($c) {
    return $c['settings']['salt'];
};

$container['baseurl'] = function ($c) {
    return $c['settings']['baseurl'];
};

$container['nodeUsertoken'] = function ($c) {
    return $c['settings']['nodeUsertoken'];
};

$container['nodeDMToken'] = function ($c) {
    return $c['settings']['nodeDMToken'];
};

$container['pdo'] = function ($c) {
    $db = $c['settings']['pdo'];
    $pdo = new PDO($db['type'] . ":host=" . $db['host'] . ";dbname=" . $db['dbname'], $db['user'], $db['pass'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$container['smarty'] = function ($c) {
    $config = $c['settings']['smarty'];
    $smarty = new SmartyBC();
    $smarty->error_reporting = true;
    $smarty->setDebugging($config['debugging']);
    $smarty->setCaching($config['caching']);
    $smarty->setTemplateDir($config['templateDir']);
    $smarty->setCompileDir($config['compileDir']);
    $smarty->setCacheDir($config['cacheDir']);
    return $smarty;
};


$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        return $c['response']
                        ->withStatus(404)
                        ->withHeader('Content-Type', 'text/html')
                        ->write($c->smarty->fetch('system/404.tpl'));
    };
};

$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['response']
                        ->withStatus(404)
                        ->withHeader('Content-Type', 'text/html')
                        ->write($c->smarty->fetch('system/404.tpl'));
    };
};

# PageController
$app->get('/', '\DND\Controller\PageController:pageHome');
$app->get('/login', '\DND\Controller\PageController:pageLogin');
$app->get('/logout', '\DND\Controller\PageController:pageLogout');
$app->get('/account', '\DND\Controller\PageController:pageAccount');
$app->get('/equipment', '\DND\Controller\PageController:pageEquipment');
$app->get('/item', '\DND\Controller\PageController:pageItem');
$app->get('/spell', '\DND\Controller\PageController:pageSpell');
$app->get('/environment', '\DND\Controller\PageController:pageEnvironment');
$app->get('/map', '\DND\Controller\PageController:pageMap');
$app->get('/image/{id}', '\DND\Controller\PageController:pageImage');

# Auth Controller
$app->post('/v2/auth/login', '\DND\Controller\ApiController:postAuthLogin');

# Shortcut Controller
$app->get('/v0/dice[/{id}]', '\DND\Controller\ShortcutController:getRandom');

$app->post('/v0/diary', '\DND\Controller\ShortcutController:postDiary');
$app->post('/v0/datatable/info', '\DND\Controller\ShortcutController:datatableInfo');
$app->post('/v0/datatable/inventory', '\DND\Controller\ShortcutController:datatableInventory');
$app->post('/v0/datatable/spellbook', '\DND\Controller\ShortcutController:datatableSpellbook');

$app->post('/v0/shortcut/item[/{id}]', '\DND\Controller\ShortcutController:postShortcutItem');
$app->post('/v0/shortcut/exp[/{id}]', '\DND\Controller\ShortcutController:postShortcutExp');
$app->post('/v0/shortcut/hp[/{id}]', '\DND\Controller\ShortcutController:postShortcutHP');
$app->post('/v0/shortcut/fullhp[/{id}]', '\DND\Controller\ShortcutController:postShortcutFullHP');
$app->post('/v0/shortcut/money[/{id}]', '\DND\Controller\ShortcutController:postShortcutMoney');

$app->post('/v0/shortcut/equipt[/{id}]', '\DND\Controller\ShortcutController:postShortcutEquipt');
$app->post('/v0/shortcut/unequipt[/{id}]', '\DND\Controller\ShortcutController:postShortcutUnequipt');
$app->post('/v0/shortcut/trade[/{id}]', '\DND\Controller\ShortcutController:postShortcutTrade');
$app->post('/v0/shortcut/drop[/{id}]', '\DND\Controller\ShortcutController:postShortcutDrop');

# InfoController
$app->get('/v1/info', '\DND\Controller\InfoController:getInfo');
$app->get('/v1/data', '\DND\Controller\InfoController:getData');
$app->post('/v1/info[/{id}]', '\DND\Controller\InfoController:postInfo');

# ApiController
$app->post('/v2/datatable/user', '\DND\Controller\ApiController:datatableUser');
$app->get('/v2/user[/{id}[/{value}]]', '\DND\Controller\ApiController:getUser');
$app->post('/v2/user[/{id}]', '\DND\Controller\ApiController:postUser');
$app->delete('/v2/user/{id}', '\DND\Controller\ApiController:deleteUser');

$app->post('/v2/datatable/environment', '\DND\Controller\ApiController:datatableEnvironment');
$app->get('/v2/environment[/{id}[/{value}]]', '\DND\Controller\ApiController:getEnvironment');
$app->post('/v2/environment[/{id}]', '\DND\Controller\ApiController:postEnvironment');
$app->delete('/v2/environment/{id}', '\DND\Controller\ApiController:deleteEnvironment');

$app->post('/v2/datatable/item', '\DND\Controller\ApiController:datatableItem');
$app->get('/v2/item[/{id}[/{value}]]', '\DND\Controller\ApiController:getItem');
$app->post('/v2/item[/{id}]', '\DND\Controller\ApiController:postItem');
$app->delete('/v2/item/{id}', '\DND\Controller\ApiController:deleteItem');

$app->post('/v2/datatable/inventory', '\DND\Controller\ApiController:datatableInventory');
$app->get('/v2/inventory[/{id}[/{value}]]', '\DND\Controller\ApiController:getInventory');
$app->post('/v2/inventory[/{id}]', '\DND\Controller\ApiController:postInventory');
$app->delete('/v2/inventory/{id}', '\DND\Controller\ApiController:deleteInventory');

$app->post('/v2/datatable/spell', '\DND\Controller\ApiController:datatableSpell');
$app->get('/v2/spell[/{id}[/{value}]]', '\DND\Controller\ApiController:getSpell');
$app->post('/v2/spell[/{id}]', '\DND\Controller\ApiController:postSpell');
$app->delete('/v2/spell/{id}', '\DND\Controller\ApiController:deleteSpell');



# Start
$app->run();
