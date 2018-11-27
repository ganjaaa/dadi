<?php

namespace DND\Core;

use DND\Objects\Account;
use DND\Objects\Backgrounds;
use DND\Objects\BackgroundsTraits;
use DND\Objects\Character;
use DND\Objects\Classes;
use DND\Objects\ClassesLevel;
use DND\Objects\DNDConstantes;
use DND\Objects\Environment;
use DND\Objects\Features;
use DND\Objects\Info;
use DND\Objects\Inventory;
use DND\Objects\Item;
use DND\Objects\Level;
use DND\Objects\MapTraits;
use DND\Objects\Races;
use DND\Objects\RacesTraits;
use DND\Objects\Slots;
use DND\Objects\Spell;
use DND\Objects\Spellbook;
use DND\Objects\Traits;

use \PDO;

class ObjectHandler{
    private $pdo;

    public function __construct(\PDO &$pdo) {
        $this->pdo = $pdo;
    }

        public function listAccount($filter = '', $rawfilter = '') {
        $result = array();
        $q = Account::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new Account();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getAccount($id) {
        $obj = new Account();
        $obj->setId($id);
        $q = Account::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function addAccount(Account &$obj) {
        $q = Account::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editAccount(Account &$obj) {
        $q = Account::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delAccount(Account &$obj) {
        $q = Account::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }

    public function listBackgrounds($filter = '', $rawfilter = '') {
        $result = array();
        $q = Backgrounds::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new Backgrounds();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getBackgrounds($id) {
        $obj = new Backgrounds();
        $obj->setId($id);
        $q = Backgrounds::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function addBackgrounds(Backgrounds &$obj) {
        $q = Backgrounds::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editBackgrounds(Backgrounds &$obj) {
        $q = Backgrounds::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delBackgrounds(Backgrounds &$obj) {
        $q = Backgrounds::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }

    public function listBackgroundsTraits($filter = '', $rawfilter = '') {
        $result = array();
        $q = BackgroundsTraits::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new BackgroundsTraits();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getBackgroundsTraits($id) {
        $obj = new BackgroundsTraits();
        $obj->setId($id);
        $q = BackgroundsTraits::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function addBackgroundsTraits(BackgroundsTraits &$obj) {
        $q = BackgroundsTraits::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editBackgroundsTraits(BackgroundsTraits &$obj) {
        $q = BackgroundsTraits::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delBackgroundsTraits(BackgroundsTraits &$obj) {
        $q = BackgroundsTraits::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }

    public function listCharacter($filter = '', $rawfilter = '') {
        $result = array();
        $q = Character::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new Character();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getCharacter($id) {
        $obj = new Character();
        $obj->setId($id);
        $q = Character::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function addCharacter(Character &$obj) {
        $q = Character::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editCharacter(Character &$obj) {
        $q = Character::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delCharacter(Character &$obj) {
        $q = Character::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }

    public function listClasses($filter = '', $rawfilter = '') {
        $result = array();
        $q = Classes::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new Classes();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getClasses($id) {
        $obj = new Classes();
        $obj->setId($id);
        $q = Classes::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function addClasses(Classes &$obj) {
        $q = Classes::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editClasses(Classes &$obj) {
        $q = Classes::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delClasses(Classes &$obj) {
        $q = Classes::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }

    public function listClassesLevel($filter = '', $rawfilter = '') {
        $result = array();
        $q = ClassesLevel::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new ClassesLevel();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getClassesLevel($id) {
        $obj = new ClassesLevel();
        $obj->setId($id);
        $q = ClassesLevel::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function addClassesLevel(ClassesLevel &$obj) {
        $q = ClassesLevel::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editClassesLevel(ClassesLevel &$obj) {
        $q = ClassesLevel::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delClassesLevel(ClassesLevel &$obj) {
        $q = ClassesLevel::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }

    public function listDNDConstantes($filter = '', $rawfilter = '') {
        $result = array();
        $q = DNDConstantes::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new DNDConstantes();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getDNDConstantes($id) {
        $obj = new DNDConstantes();
        $obj->setId($id);
        $q = DNDConstantes::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function addDNDConstantes(DNDConstantes &$obj) {
        $q = DNDConstantes::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editDNDConstantes(DNDConstantes &$obj) {
        $q = DNDConstantes::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delDNDConstantes(DNDConstantes &$obj) {
        $q = DNDConstantes::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }

    public function listEnvironment($filter = '', $rawfilter = '') {
        $result = array();
        $q = Environment::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new Environment();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getEnvironment($id) {
        $obj = new Environment();
        $obj->setId($id);
        $q = Environment::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function addEnvironment(Environment &$obj) {
        $q = Environment::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editEnvironment(Environment &$obj) {
        $q = Environment::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delEnvironment(Environment &$obj) {
        $q = Environment::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }

    public function listFeatures($filter = '', $rawfilter = '') {
        $result = array();
        $q = Features::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new Features();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getFeatures($id) {
        $obj = new Features();
        $obj->setId($id);
        $q = Features::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function addFeatures(Features &$obj) {
        $q = Features::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editFeatures(Features &$obj) {
        $q = Features::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delFeatures(Features &$obj) {
        $q = Features::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }

    public function listInfo($filter = '', $rawfilter = '') {
        $result = array();
        $q = Info::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new Info();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getInfo($id) {
        $obj = new Info();
        $obj->setId($id);
        $q = Info::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function addInfo(Info &$obj) {
        $q = Info::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editInfo(Info &$obj) {
        $q = Info::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delInfo(Info &$obj) {
        $q = Info::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }

    public function listInventory($filter = '', $rawfilter = '') {
        $result = array();
        $q = Inventory::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new Inventory();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getInventory($id) {
        $obj = new Inventory();
        $obj->setId($id);
        $q = Inventory::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function addInventory(Inventory &$obj) {
        $q = Inventory::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editInventory(Inventory &$obj) {
        $q = Inventory::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delInventory(Inventory &$obj) {
        $q = Inventory::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }

    public function listItem($filter = '', $rawfilter = '') {
        $result = array();
        $q = Item::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new Item();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getItem($id) {
        $obj = new Item();
        $obj->setId($id);
        $q = Item::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function addItem(Item &$obj) {
        $q = Item::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editItem(Item &$obj) {
        $q = Item::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delItem(Item &$obj) {
        $q = Item::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }

    public function listLevel($filter = '', $rawfilter = '') {
        $result = array();
        $q = Level::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new Level();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getLevel($id) {
        $obj = new Level();
        $obj->setId($id);
        $q = Level::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function addLevel(Level &$obj) {
        $q = Level::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editLevel(Level &$obj) {
        $q = Level::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delLevel(Level &$obj) {
        $q = Level::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }

    public function listMapTraits($filter = '', $rawfilter = '') {
        $result = array();
        $q = MapTraits::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new MapTraits();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getMapTraits($id) {
        $obj = new MapTraits();
        $obj->setId($id);
        $q = MapTraits::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function addMapTraits(MapTraits &$obj) {
        $q = MapTraits::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editMapTraits(MapTraits &$obj) {
        $q = MapTraits::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delMapTraits(MapTraits &$obj) {
        $q = MapTraits::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }

    public function listRaces($filter = '', $rawfilter = '') {
        $result = array();
        $q = Races::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new Races();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getRaces($id) {
        $obj = new Races();
        $obj->setId($id);
        $q = Races::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function addRaces(Races &$obj) {
        $q = Races::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editRaces(Races &$obj) {
        $q = Races::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delRaces(Races &$obj) {
        $q = Races::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }

    public function listRacesTraits($filter = '', $rawfilter = '') {
        $result = array();
        $q = RacesTraits::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new RacesTraits();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getRacesTraits($id) {
        $obj = new RacesTraits();
        $obj->setId($id);
        $q = RacesTraits::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function addRacesTraits(RacesTraits &$obj) {
        $q = RacesTraits::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editRacesTraits(RacesTraits &$obj) {
        $q = RacesTraits::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delRacesTraits(RacesTraits &$obj) {
        $q = RacesTraits::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }

    public function listSlots($filter = '', $rawfilter = '') {
        $result = array();
        $q = Slots::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new Slots();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getSlots($id) {
        $obj = new Slots();
        $obj->setId($id);
        $q = Slots::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function addSlots(Slots &$obj) {
        $q = Slots::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editSlots(Slots &$obj) {
        $q = Slots::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delSlots(Slots &$obj) {
        $q = Slots::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }

    public function listSpell($filter = '', $rawfilter = '') {
        $result = array();
        $q = Spell::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new Spell();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getSpell($id) {
        $obj = new Spell();
        $obj->setId($id);
        $q = Spell::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function addSpell(Spell &$obj) {
        $q = Spell::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editSpell(Spell &$obj) {
        $q = Spell::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delSpell(Spell &$obj) {
        $q = Spell::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }

    public function listSpellbook($filter = '', $rawfilter = '') {
        $result = array();
        $q = Spellbook::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new Spellbook();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getSpellbook($id) {
        $obj = new Spellbook();
        $obj->setId($id);
        $q = Spellbook::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function addSpellbook(Spellbook &$obj) {
        $q = Spellbook::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editSpellbook(Spellbook &$obj) {
        $q = Spellbook::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delSpellbook(Spellbook &$obj) {
        $q = Spellbook::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }

    public function listTraits($filter = '', $rawfilter = '') {
        $result = array();
        $q = Traits::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new Traits();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getTraits($id) {
        $obj = new Traits();
        $obj->setId($id);
        $q = Traits::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function addTraits(Traits &$obj) {
        $q = Traits::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editTraits(Traits &$obj) {
        $q = Traits::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delTraits(Traits &$obj) {
        $q = Traits::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }


}