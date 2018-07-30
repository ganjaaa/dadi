<?php

namespace DND\Controller;

use DND\Core\ObjectHandler;
use DND\Helper\ApiHelper;

class PageController extends Controller {

    const PAGE_DASHBOARD = 'content/dashboard.tpl';
    const PAGE_USERSHEET = 'content/usersheet.tpl';
    const PAGE_ACCOUNT = 'content/account.tpl';
    const PAGE_ITEM = 'content/item.tpl';
    const PAGE_SPELL = 'content/spell.tpl';
    const PAGE_ENVIRONMENT = 'content/environment.tpl';
    const PAGE_MAP = 'content/map.tpl';
    const PAGE_LOGIN = 'content/login.tpl';
    const PAGE_EQUIPMENT = 'content/equipment.tpl';
    const PAGE_BACKGROUNDS = 'content/backgrounds.tpl';
    const PAGE_CLASSES = 'content/classes.tpl';
    const PAGE_FEATURES = 'content/features.tpl';
    const PAGE_RACES = 'content/races.tpl';
    const PAGE_TRAITS = 'content/traits.tpl';

    private $authController;
    private $objectController;

    public function __construct(\Slim\Container &$container) {
        parent::__construct($container);
        $this->authController = new AuthController($container);
        $this->objectController = new ObjectHandler($container->pdo);
    }

    public function pageHome($request, $response, $args) {
        if (!$this->authController->isLogin()) {
            return $response->withRedirect('/login');
        }
        if ($this->authController->isGm()) {
            return $this->pageDashboard($request, $response, $args);
        }
        return $this->pageCharsheet($request, $response, $args);
    }

    public function pageDashboard($request, $response, $args) {
        if (!$this->authController->isGm()) {
            return $this->pageHome($request, $response, $args);
        }
        $listItem = '';
        foreach ($this->objectController->listItem('', ' ORDER BY `name`') as $i) {
            $listItem .= '<option value="' . $i->getId() . '">' . $i->getName() . '</option>' . PHP_EOL;
        }
        $this->container->smarty->assign('listItem', $listItem);
        return $this->displayTemplate($response, self::PAGE_DASHBOARD);
    }

    public function pageTraits($request, $response, $args) {
        if (!$this->authController->isGm()) {
            return $this->pageHome($request, $response, $args);
        }

        return $this->displayTemplate($response, self::PAGE_TRAITS);
    }

    public function pageRaces($request, $response, $args) {
        if (!$this->authController->isGm()) {
            return $this->pageHome($request, $response, $args);
        }

        return $this->displayTemplate($response, self::PAGE_RACES);
    }

    public function pageFeatures($request, $response, $args) {
        if (!$this->authController->isGm()) {
            return $this->pageHome($request, $response, $args);
        }

        return $this->displayTemplate($response, self::PAGE_FEATURES);
    }

    public function pageClasses($request, $response, $args) {
        if (!$this->authController->isGm()) {
            return $this->pageHome($request, $response, $args);
        }

        return $this->displayTemplate($response, self::PAGE_CLASSES);
    }

    public function pageBackgrounds($request, $response, $args) {
        if (!$this->authController->isGm()) {
            return $this->pageHome($request, $response, $args);
        }

        return $this->displayTemplate($response, self::PAGE_BACKGROUNDS);
    }

    public function pageAccount($request, $response, $args) {
        if (!$this->authController->isGm()) {
            return $this->pageHome($request, $response, $args);
        }
        $listItem = '';
        $listRing = '<option value="">-</option>';
        $listQuiver = '<option value="">-</option>';
        $listHelmet = '<option value="">-</option>';
        $listCape = '<option value="">-</option>';
        $listNecklace = '<option value="">-</option>';
        $listWeapon = '<option value="">-</option>';
        $listOffWeapon = '<option value="">-</option>';
        $listGloves = '<option value="">-</option>';
        $listArmor = '<option value="">-</option>';
        $listBelt = '<option value="">-</option>';
        $listObject = '<option value="">-</option>';
        $listBoots = '<option value="">-</option>';
        $listEnvironment = '<option value="">-</option>';
        foreach ($this->objectController->listEnvironment('', ' ORDER BY `name`') as $i) {
            $listEnvironment .= '<option value="' . $i->getId() . '">' . $i->getName() . '</option>' . PHP_EOL;
        }
        foreach ($this->objectController->listItem('', ' ORDER BY `name`') as $i) {
            $listItem .= '<option value="' . $i->getId() . '">' . $i->getName() . '</option>' . PHP_EOL;
            switch ($i->getWearable()) {
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_RING:
                    $listRing .= '<option value="' . $i->getId() . '">' . $i->getName() . '</option>' . PHP_EOL;
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_QUIVER:
                    $listQuiver .= '<option value="' . $i->getId() . '">' . $i->getName() . '</option>' . PHP_EOL;
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_HELMET:
                    $listHelmet .= '<option value="' . $i->getId() . '">' . $i->getName() . '</option>' . PHP_EOL;
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_CAPE:
                    $listCape .= '<option value="' . $i->getId() . '">' . $i->getName() . '</option>' . PHP_EOL;
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_NECKLACE:
                    $listNecklace .= '<option value="' . $i->getId() . '">' . $i->getName() . '</option>' . PHP_EOL;
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_WEAPON:
                    $listWeapon .= '<option value="' . $i->getId() . '">' . $i->getName() . '</option>' . PHP_EOL;
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_OFF_WEAPON:
                    $listOffWeapon .= '<option value="' . $i->getId() . '">' . $i->getName() . '</option>' . PHP_EOL;
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_GLOVES:
                    $listGloves .= '<option value="' . $i->getId() . '">' . $i->getName() . '</option>' . PHP_EOL;
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_ARMOR:
                    $listArmor .= '<option value="' . $i->getId() . '">' . $i->getName() . '</option>' . PHP_EOL;
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_BELT:
                    $listBelt .= '<option value="' . $i->getId() . '">' . $i->getName() . '</option>' . PHP_EOL;
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_NONE:
                    $listObject .= '<option value="' . $i->getId() . '">' . $i->getName() . '</option>' . PHP_EOL;
                    break;
                case \DND\Objects\DNDConstantes::IDX_EQUIPT_SLOT_BOOTS:
                    $listBoots .= '<option value="' . $i->getId() . '">' . $i->getName() . '</option>' . PHP_EOL;
                    break;
            }
        }
        $this->container->smarty->assign('listItem', $listItem);
        $this->container->smarty->assign('listRing', $listRing);
        $this->container->smarty->assign('listQuiver', $listQuiver);
        $this->container->smarty->assign('listHelmet', $listHelmet);
        $this->container->smarty->assign('listCape', $listCape);
        $this->container->smarty->assign('listNecklace', $listNecklace);
        $this->container->smarty->assign('listWeapon', $listWeapon);
        $this->container->smarty->assign('listOffWeapon', $listOffWeapon);
        $this->container->smarty->assign('listGloves', $listGloves);
        $this->container->smarty->assign('listArmor', $listArmor);
        $this->container->smarty->assign('listBelt', $listBelt);
        $this->container->smarty->assign('listObject', $listObject);
        $this->container->smarty->assign('listBoots', $listBoots);
        $this->container->smarty->assign('listEnvironment', $listEnvironment);

        return $this->displayTemplate($response, self::PAGE_ACCOUNT);
    }

    public function pageEquipment($request, $response, $args) {
        if (!$this->authController->isGm()) {
            return $this->pageHome($request, $response, $args);
        }
        return $this->displayTemplate($response, self::PAGE_EQUIPMENT);
    }

    public function pageItem($request, $response, $args) {
        if (!$this->authController->isGm()) {
            return $this->pageHome($request, $response, $args);
        }
        return $this->displayTemplate($response, self::PAGE_ITEM);
    }

    public function pageSpell($request, $response, $args) {
        if (!$this->authController->isGm()) {
            return $this->pageHome($request, $response, $args);
        }
        return $this->displayTemplate($response, self::PAGE_SPELL);
    }

    public function pageEnvironment($request, $response, $args) {
        if (!$this->authController->isGm()) {
            return $this->pageHome($request, $response, $args);
        }
        return $this->displayTemplate($response, self::PAGE_ENVIRONMENT);
    }

    public function pageMap($request, $response, $args) {
        if (!$this->authController->isGm()) {
            return $this->pageHome($request, $response, $args);
        }

        $env_array = [];
        foreach ($this->objectController->listEnvironment('', ' ORDER BY `name`') as $env) {
            $env_array[] = $env->getAjax();
        }
        $this->container->smarty->assign('envList', $env_array);

        return $this->displayTemplate($response, self::PAGE_MAP);
    }

    public function pageLogin($request, $response, $args) {
        if ($this->authController->isLogin()) {
            return $this->pageHome($request, $response, $args);
        }
        return $this->displayTemplate($response, self::PAGE_LOGIN);
    }

    public function pageLogout($request, $response, $args) {
        $this->authController->logout();
        return $response->withRedirect('/login');
    }

    public function pageCharsheet($request, $response, $args) {
        if (!$this->authController->isLogin()) {
            return $response->withRedirect('/login');
        }

        $user = null;
        $listUser = [];
        $listItems = [];
        $listSpells = [];

        foreach ($this->objectController->listUser('', ' ORDER BY `charname`') as $u) {
            $u->setPassword('');
            if ($u->getId() != $this->authController->getLoginId()) {
                $listUser[] = $u->getAjax();
            } else {
                $u->setMail('');
                $user = $u;
            }
        }

        foreach ($this->objectController->listSpellbook('characterId = ' . $user->getId()) as $spellbook) {
            $spell = $this->objectController->getSpell($spellbook->getSpellid());
            $spellbook->setObject($spell);
            $listSpells[] = $spellbook->getDisplayData();
        }


        foreach ($this->objectController->listInventory('characterId = ' . $user->getId()) as $inventory) {
            $listItems[$inventory->getId()] = $inventory->getAjax();
        }

        if (!empty($user->getEquipmentquiver1()) && !is_object($user->getEquipmentquiver1()))
            $user->setEquipmentquiver1($this->objectController->getItem($user->getEquipmentquiver1()));
        if (!empty($user->getEquipmentquiver2()) && !is_object($user->getEquipmentquiver2()))
            $user->setEquipmentquiver2($this->objectController->getItem($user->getEquipmentquiver2()));
        if (!empty($user->getEquipmentquiver3()) && !is_object($user->getEquipmentquiver3()))
            $user->setEquipmentquiver3($this->objectController->getItem($user->getEquipmentquiver3()));
        if (!empty($user->getEquipmenthelmet()) && !is_object($user->getEquipmenthelmet()))
            $user->setEquipmenthelmet($this->objectController->getItem($user->getEquipmenthelmet()));
        if (!empty($user->getEquipmentcape()) && !is_object($user->getEquipmentcape()))
            $user->setEquipmentcape($this->objectController->getItem($user->getEquipmentcape()));
        if (!empty($user->getEquipmentnecklace()) && !is_object($user->getEquipmentnecklace()))
            $user->setEquipmentnecklace($this->objectController->getItem($user->getEquipmentnecklace()));
        if (!empty($user->getEquipmentweapon1()) && !is_object($user->getEquipmentweapon1()))
            $user->setEquipmentweapon1($this->objectController->getItem($user->getEquipmentweapon1()));
        if (!empty($user->getEquipmentweapon2()) && !is_object($user->getEquipmentweapon2()))
            $user->setEquipmentweapon2($this->objectController->getItem($user->getEquipmentweapon2()));
        if (!empty($user->getEquipmentweapon3()) && !is_object($user->getEquipmentweapon3()))
            $user->setEquipmentweapon3($this->objectController->getItem($user->getEquipmentweapon3()));
        if (!empty($user->getEquipmentoffweapon()) && !is_object($user->getEquipmentoffweapon()))
            $user->setEquipmentoffweapon($this->objectController->getItem($user->getEquipmentoffweapon()));
        if (!empty($user->getEquipmentgloves()) && !is_object($user->getEquipmentgloves()))
            $user->setEquipmentgloves($this->objectController->getItem($user->getEquipmentgloves()));
        if (!empty($user->getEquipmentarmor()) && !is_object($user->getEquipmentarmor()))
            $user->setEquipmentarmor($this->objectController->getItem($user->getEquipmentarmor()));
        if (!empty($user->getEquipmentobject()) && !is_object($user->getEquipmentobject()))
            $user->setEquipmentobject($this->objectController->getItem($user->getEquipmentobject()));
        if (!empty($user->getEquipmentbelt()) && !is_object($user->getEquipmentbelt()))
            $user->setEquipmentbelt($this->objectController->getItem($user->getEquipmentbelt()));
        if (!empty($user->getEquipmentboots()) && !is_object($user->getEquipmentboots()))
            $user->setEquipmentboots($this->objectController->getItem($user->getEquipmentboots()));
        if (!empty($user->getEquipmentring1()) && !is_object($user->getEquipmentring1()))
            $user->setEquipmentring1($this->objectController->getItem($user->getEquipmentring1()));
        if (!empty($user->getEquipmentring2()) && !is_object($user->getEquipmentring2()))
            $user->setEquipmentring2($this->objectController->getItem($user->getEquipmentring2()));


        $env = $this->objectController->getEnvironment($user->getEnvironmentid());
        if ($env) {
            $devn = $env->getAjax();
            $devn['date'] = $env->getMoon();
            $this->container->smarty->assign('environment', $devn);
            $char = $user->getDisplayData($env);
        } else {
            $char = $user->getDisplayData();
        }

        $this->container->smarty->assign('user', $user->getAjax());
        $this->container->smarty->assign('listUser', $listUser);
        $this->container->smarty->assign('spellbook', $listSpells);
        $this->container->smarty->assign('items', $listItems);
        $this->container->smarty->assign('character', $char);
        $this->container->smarty->assign('colab', $this->container->collaboration);

        return $this->displayTemplate($response, self::PAGE_USERSHEET);
    }

    public function pageImage($request, $response, $args) {
        if (!$this->authController->isLogin()) {
            return $response->withRedirect('/login');
        }

        $id = $request->getAttribute('id');
        $dir = __DIR__ . '/../../inc/items/';
        $image = @file_get_contents($dir . (is_file($dir . $id . '.png') ? $id : "default") . ".png");
        $response->write($image);
        return $response
                        ->withHeader('Content-Type', FILEINFO_MIME_TYPE)
                        ->withHeader('Cache-Control', 'public, max-age=31536000');
    }

    private function displayTemplate($response, $page) {
        $this->container->smarty->assign('BASEURL', $this->container->baseurl);
        $this->container->smarty->display($page);
        return $response
                        ->withStatus(200)
                        ->withHeader('Content-Type', 'text/html');
        #->write($this->container->smarty->fetch($page));
    }

}
