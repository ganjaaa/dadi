<?php

namespace DND\Controller;

use DND\Objects\Account;
use DND\Objects\Character;
use DND\Objects\Demo;
use DND\Objects\Environment;
use DND\Objects\Inventory;
use DND\Objects\Item;
use DND\Objects\Spell;
use DND\Objects\Spellbook;


class ObjectController{
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

    public function getAccount($characterId, $itemId) {
        $obj = new Account();
        $obj->setId($itemId);
        $q = Account::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $obj->setFromSqlRow($s->fetch(PDO::FETCH_ASSOC));
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

    public function getCharacter($characterId, $itemId) {
        $obj = new Character();
        $obj->setId($itemId);
        $q = Character::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $obj->setFromSqlRow($s->fetch(PDO::FETCH_ASSOC));
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

    public function listDemo($filter = '', $rawfilter = '') {
        $result = array();
        $q = Demo::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new Demo();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function getDemo($characterId, $itemId) {
        $obj = new Demo();
        $obj->setId($itemId);
        $q = Demo::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $obj->setFromSqlRow($s->fetch(PDO::FETCH_ASSOC));
                return $obj;
            }
        }
        return NULL;
    }

    public function addDemo(Demo &$obj) {
        $q = Demo::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function editDemo(Demo &$obj) {
        $q = Demo::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function delDemo(Demo &$obj) {
        $q = Demo::getSQLDel();
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

    public function getEnvironment($characterId, $itemId) {
        $obj = new Environment();
        $obj->setId($itemId);
        $q = Environment::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $obj->setFromSqlRow($s->fetch(PDO::FETCH_ASSOC));
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

    public function getInventory($characterId, $itemId) {
        $obj = new Inventory();
        $obj->setId($itemId);
        $q = Inventory::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $obj->setFromSqlRow($s->fetch(PDO::FETCH_ASSOC));
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

    public function getItem($characterId, $itemId) {
        $obj = new Item();
        $obj->setId($itemId);
        $q = Item::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $obj->setFromSqlRow($s->fetch(PDO::FETCH_ASSOC));
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

    public function getSpell($characterId, $itemId) {
        $obj = new Spell();
        $obj->setId($itemId);
        $q = Spell::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $obj->setFromSqlRow($s->fetch(PDO::FETCH_ASSOC));
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

    public function getSpellbook($characterId, $itemId) {
        $obj = new Spellbook();
        $obj->setId($itemId);
        $q = Spellbook::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $obj->setFromSqlRow($s->fetch(PDO::FETCH_ASSOC));
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


}