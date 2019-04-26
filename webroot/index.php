<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../_config.php';
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

$container['nodeAccounttoken'] = function ($c) {
    return $c['settings']['nodeAccounttoken'];
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

$container['collaboration'] = function ($c) { // Eigentlich überflüssig aber ich mag es definiert
    return $c['settings']['collaboration'];
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
/*
  if (!defined('DEBUG') || DEBUG === false) {
  $container['errorHandler'] = function ($c) {
  return function ($request, $response, $exception) use ($c) {
  return $c['response']
  ->withStatus(404)
  ->withHeader('Content-Type', 'text/html')
  ->write($c->smarty->fetch('1_404.tpl'));
  };
  };

  $container['notFoundHandler'] = function ($c) {
  return function ($request, $response) use ($c) {
  return $c['response']
  ->withStatus(404)
  ->withHeader('Content-Type', 'text/html')
  ->write($c->smarty->fetch('1_404.tpl'));
  };
  };
  } */

# PageController
$app->get('/', '\DND\Controller\PageController:pageHome');
$app->get('/dashboard', '\DND\Controller\PageController:pageHome');
$app->get('/login', '\DND\Controller\PageController:pageLogin');
$app->get('/logout', '\DND\Controller\PageController:pageLogout');
$app->get('/account', '\DND\Controller\PageController:pageAccount');
$app->get('/character', '\DND\Controller\PageController:pageCharacter');
$app->get('/equipment', '\DND\Controller\PageController:pageEquipment');
$app->get('/item', '\DND\Controller\PageController:pageItem');
$app->get('/spell', '\DND\Controller\PageController:pageSpell');
$app->get('/environment', '\DND\Controller\PageController:pageEnvironment');
$app->get('/map', '\DND\Controller\PageController:pageMap');
$app->get('/board', '\DND\Controller\PageController:pageBoard');

$app->get('/backgrounds', '\DND\Controller\PageController:pageBackgrounds');
$app->get('/classes', '\DND\Controller\PageController:pageClasses');
$app->get('/features', '\DND\Controller\PageController:pageFeatures');
$app->get('/races', '\DND\Controller\PageController:pageRaces');
$app->get('/traits', '\DND\Controller\PageController:pageTraits');
#$app->get('/relations', '\DND\Controller\PageController:pageRelations');

$app->get('/image/{id}', '\DND\Controller\PageController:pageImage');

# Auth Controller
$app->get('/v2/auth/check', '\DND\Controller\ApiController:getAuthCheck');
$app->get('/v2/auth/logout', '\DND\Controller\ApiController:getAuthLogout');
$app->post('/v2/auth/login', '\DND\Controller\ApiController:postAuthLogin');

# Shortcut Controller
$app->group('/v0', function() use ($app) {
    $app->get('/dice[/{id}]', '\DND\Controller\ShortcutController:getRandom');

    $app->post('/diary', '\DND\Controller\ShortcutController:postDiary');
    $app->group('/datatable', function() use ($app) {
        $app->post('/info', '\DND\Controller\ShortcutController:datatableInfo');
        $app->post('/inventory', '\DND\Controller\ShortcutController:datatableInventory');
        $app->post('/spellbook', '\DND\Controller\ShortcutController:datatableSpellbook');
    });
    $app->group('/shortcut', function() use ($app) {
        $app->post('/item[/{id}]', '\DND\Controller\ShortcutController:postShortcutItem');
        $app->post('/exp[/{id}]', '\DND\Controller\ShortcutController:postShortcutExp');
        $app->post('/hp[/{id}]', '\DND\Controller\ShortcutController:postShortcutHP');
        $app->post('/fullhp[/{id}]', '\DND\Controller\ShortcutController:postShortcutFullHP');
        $app->post('/money[/{id}]', '\DND\Controller\ShortcutController:postShortcutMoney');

        $app->post('/equipt[/{id}]', '\DND\Controller\ShortcutController:postShortcutEquipt');
        $app->post('/unequipt[/{id}]', '\DND\Controller\ShortcutController:postShortcutUnequipt');
        $app->post('/trade[/{id}]', '\DND\Controller\ShortcutController:postShortcutTrade');
        $app->post('/drop[/{id}]', '\DND\Controller\ShortcutController:postShortcutDrop');
    });
});
# InfoController
$app->group('/v1', function() use ($app) {
    $app->get('/info', '\DND\Controller\InfoController:getInfo');
    $app->get('/data', '\DND\Controller\InfoController:getData');

    $app->get('/charsheet', '\DND\Controller\InfoController:getCharsheet');
    $app->post('/info[/{id}]', '\DND\Controller\InfoController:postInfo');
});
# ApiController
$app->group('/v2', function() use ($app) {
    $app->get('/account[/{id}[/{value}]]', '\DND\Controller\ApiController:getAccount');
    $app->post('/account[/{id}]', '\DND\Controller\ApiController:postAccount');
    $app->delete('/account/{id}', '\DND\Controller\ApiController:deleteAccount');

    $app->get('/character[/{id}[/{value}]]', '\DND\Controller\ApiController:getCharacter');
    $app->post('/character[/{id}]', '\DND\Controller\ApiController:postCharacter');
    $app->delete('/character/{id}', '\DND\Controller\ApiController:deleteCharacter');

    $app->get('/environment[/{id}[/{value}]]', '\DND\Controller\ApiController:getEnvironment');
    $app->post('/environment[/{id}]', '\DND\Controller\ApiController:postEnvironment');
    $app->delete('/environment/{id}', '\DND\Controller\ApiController:deleteEnvironment');

    $app->get('/item[/{id}[/{value}]]', '\DND\Controller\ApiController:getItem');
    $app->post('/item[/{id}]', '\DND\Controller\ApiController:postItem');
    $app->delete('/item/{id}', '\DND\Controller\ApiController:deleteItem');

    $app->get('/inventory[/{id}[/{value}]]', '\DND\Controller\ApiController:getInventory');
    $app->post('/inventory[/{id}]', '\DND\Controller\ApiController:postInventory');
    $app->delete('/inventory/{id}', '\DND\Controller\ApiController:deleteInventory');

    $app->get('/spell[/{id}[/{value}]]', '\DND\Controller\ApiController:getSpell');
    $app->post('/spell[/{id}]', '\DND\Controller\ApiController:postSpell');
    $app->delete('/spell/{id}', '\DND\Controller\ApiController:deleteSpell');

    $app->get('/races[/{id}[/{value}]]', '\DND\Controller\ApiController:getRaces');
    $app->post('/races[/{id}]', '\DND\Controller\ApiController:postRaces');
    $app->delete('/races/{id}', '\DND\Controller\ApiController:deleteRaces');

    $app->get('/racestraits[/{id}[/{value}]]', '\DND\Controller\ApiController:getRacesTraits');
    $app->post('/racestraits[/{id}]', '\DND\Controller\ApiController:postRacesTraits');
    $app->delete('/racestraits/{id}', '\DND\Controller\ApiController:deleteRacesTraits');

    $app->get('/classes[/{id}[/{value}]]', '\DND\Controller\ApiController:getClasses');
    $app->post('/classes[/{id}]', '\DND\Controller\ApiController:postClasses');
    $app->delete('/classes/{id}', '\DND\Controller\ApiController:deleteClasses');

    $app->get('/backgrounds[/{id}[/{value}]]', '\DND\Controller\ApiController:getBackgrounds');
    $app->post('/backgrounds[/{id}]', '\DND\Controller\ApiController:postBackgrounds');
    $app->delete('/backgrounds/{id}', '\DND\Controller\ApiController:deleteBackgrounds');

    $app->get('/backgroundstraits[/{id}[/{value}]]', '\DND\Controller\ApiController:getBackgroundsTraits');
    $app->post('/backgroundstraits[/{id}]', '\DND\Controller\ApiController:postBackgroundsTraits');
    $app->delete('/backgroundstraits/{id}', '\DND\Controller\ApiController:deleteBackgroundsTraits');

    $app->get('/features[/{id}[/{value}]]', '\DND\Controller\ApiController:getFeatures');
    $app->post('/features[/{id}]', '\DND\Controller\ApiController:postFeatures');
    $app->delete('/features/{id}', '\DND\Controller\ApiController:deleteFeatures');

    $app->get('/traits[/{id}[/{value}]]', '\DND\Controller\ApiController:getTraits');
    $app->post('/traits[/{id}]', '\DND\Controller\ApiController:postTraits');
    $app->delete('/traits/{id}', '\DND\Controller\ApiController:deleteTraits');

    $app->group('/datatable', function() use ($app) {
        $app->post('/account', '\DND\Controller\ApiController:datatableAccount');
        $app->post('/character', '\DND\Controller\ApiController:datatableCharacter');
        $app->post('/environment', '\DND\Controller\ApiController:datatableEnvironment');
        $app->post('/item', '\DND\Controller\ApiController:datatableItem');
        $app->post('/inventory', '\DND\Controller\ApiController:datatableInventory');
        $app->post('/spell', '\DND\Controller\ApiController:datatableSpell');
        $app->post('/races', '\DND\Controller\ApiController:datatableRaces');
        $app->post('/classes', '\DND\Controller\ApiController:datatableClasses');
        $app->post('/backgrounds', '\DND\Controller\ApiController:datatableBackgrounds');
        $app->post('/features', '\DND\Controller\ApiController:datatableFeatures');
        $app->post('/traits', '\DND\Controller\ApiController:datatableTraits');
    });
    $app->group('/options', function() use ($app) {
        $app->post('/full', '\DND\Controller\ApiController:getFullOptions');
        $app->post('/account', '\DND\Controller\ApiController:optionsAccount');
        $app->post('/items[/{type}]', '\DND\Controller\ApiController:optionsItems');
        $app->post('/class', '\DND\Controller\ApiController:optionsClass');
        $app->post('/race', '\DND\Controller\ApiController:optionsRace');
        $app->post('/alignment', '\DND\Controller\ApiController:optionsAlignment');
        $app->post('/background', '\DND\Controller\ApiController:optionsBackground');
        $app->post('/environment', '\DND\Controller\ApiController:optionsEnvironment');
    });
});

$app->group('/api', function() use ($app) {
    $app->group('/v0', function() use ($app) {
        $app->get('/check', '\DND\Controller\ApiController:getAuthCheck');
        $app->get('/logout', '\DND\Controller\ApiController:getAuthLogout');
        $app->post('/login', '\DND\Controller\ApiController:postAuthLogin');
    });
    $app->group('/v1', function() use ($app) {
        $app->group('/info', function() use ($app) {
            //$app->get('/environment', '\DND\Controller\ReactController:user_infoEnvironment');
            $app->get('/charsheet', '\DND\Controller\ReactController:user_infoCharsheet');
            $app->get('/traits', '\DND\Controller\ReactController:user_infoTraits');
            $app->get('/poll', '\DND\Controller\ReactController:user_infoPoll');
            $app->get('/map', '\DND\Controller\ReactController:user_infoMap');
        });
        $app->group('/inventory', function() use ($app) {
            $app->post('/equipt/{itemId}', '\DND\Controller\ReactController:user_inventoryEquipt');
            $app->post('/unequipt/{itemId}', '\DND\Controller\ReactController:user_inventoryUnequipt');
            $app->post('/drop/{itemId}', '\DND\Controller\ReactController:user_inventoryDrop');
            $app->post('/give/{itemId}/{charId}', '\DND\Controller\ReactController:user_inventoryGive');
        });
        $app->group('/spell', function() use ($app) {
            $app->post('/equipt/{spellId}', '\DND\Controller\ReactController:user_spellEquipt');
            $app->post('/unequipt/{spellId}', '\DND\Controller\ReactController:user_spellUnequipt');
            $app->post('/use/{itemId}', '\DND\Controller\ReactController:user_spellUse');
        });
        $app->group('/datatable', function() use ($app) {
            $app->post('/inventory', '\DND\Controller\ReactController:user_tableInventory');
            $app->post('/spell', '\DND\Controller\ReactController:user_tableSpell');
            $app->post('/log', '\DND\Controller\ReactController:user_tableLog');
        });
    });
    $app->group('/v2', function() use ($app) {
        $app->group('/dashboard', function() use ($app) {
            $app->get('/character', '\DND\Controller\ReactController:dm_dashboardCharacter');
            $app->get('/environment', '\DND\Controller\ReactController:dm_dashboardEnvironment');
            $app->post('/exp[/{charId}]', '\DND\Controller\ReactController:dm_dashboardExp');
            $app->post('/hp[/{charId}]', '\DND\Controller\ReactController:dm_dashboardHP');
            $app->post('/msg[/{charId}]', '\DND\Controller\ReactController:dm_dashboardMsg');
            $app->post('/reload[/{charId}]', '\DND\Controller\ReactController:dm_dashboardReload');
            $app->post('/rest[/{charId}]', '\DND\Controller\ReactController:dm_dashboardRest');
            $app->post('/money[/{charId}]', '\DND\Controller\ReactController:dm_dashboardMoney');
            $app->post('/dice/{sides}', '\DND\Controller\ReactController:dm_dashboardDice');
        });

        $app->get('/environment[/{id}[/{value}]]', '\DND\Controller\ReactController:getEnvironment');
        $app->post('/environment[/{id}]', '\DND\Controller\ReactController:postEnvironment');
        $app->delete('/environment/{id}', '\DND\Controller\ReactController:deleteEnvironment');
        
    });
});


# Start
$app->run();
