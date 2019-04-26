<?php

namespace DND\Objects;


class Spellbook implements \DND\Interfaces\Objects {

    const tableName = 'dnd_spellbook';
    const IDX_SPELL_USED = 1;
    const IDX_SPELL_UNUSED = 0;

    private $id;
    private $characterId;
    private $spellId;
    private $slot;
    private $used;
    private $object = 0;

    public function __construct() {
    }

    public function getDisplayData() {
        return array(
        "id" => $this->id, 
        "characterId" => $this->characterId, 
        "spellId" => $this->spellId, 
        "slot" => $this->slot, 
        "used" => $this->used, 
        "object" => is_object($this->object)? $this->object->getAjax() : null
        );
    }

    public function getId() {
        return $this->id;
    }

    public function setId($value) {
        $this->id = $value;
        return $this;
    }

    public function getCharacterid() {
        return $this->characterId;
    }

    public function setCharacterid($value) {
        $this->characterId = $value;
        return $this;
    }

    public function getSpellid() {
        return $this->spellId;
    }

    public function setSpellid($value) {
        $this->spellId = $value;
        return $this;
    }

    public function getSlot() {
        return $this->slot;
    }

    public function setSlot($value) {
        $this->slot = $value;
        return $this;
    }

    public function getUsed() {
        return $this->used;
    }

    public function setUsed($value) {
        $this->used = $value;
        return $this;
    }

    public function getObject() {
        return $this->object;
    }

    public function setObject($value) {
        $this->object = $value;
        return $this;
    }

    public static function getSQLList($filter = "", $rawfilter = "") {
        return "SELECT * FROM `" . self::tableName . "`" . ($filter != "" ? " WHERE " . $filter : "") . " " . $rawfilter;
    }

    public function bindSQLList(\PDOStatement &$stmt) {
    }

    public static function getSQLGet() {
        return "SELECT * FROM `" . self::tableName . "` WHERE `id`=:id;";
    }

    public function bindSQLGet(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
    }

    public function fillFromPost($array=array()) {
        if(isset($array["id"]) && !empty($array["id"])){$this->id = $array["id"];}
        if(isset($array["characterId"])){$this->characterId = $array["characterId"];}
        if(isset($array["spellId"])){$this->spellId = $array["spellId"];}
        if(isset($array["slot"])){$this->slot = $array["slot"];}
        if(isset($array["used"])){$this->used = $array["used"];}
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`, `characterId`, `spellId`, `slot`, `used` )" . " VALUES " . " (NULL , :characterId, :spellId, :slot, :used );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
        $stmt->bindParam(":characterId", $this->characterId);
        $stmt->bindParam(":spellId", $this->spellId);
        $stmt->bindParam(":slot", $this->slot);
        $stmt->bindParam(":used", $this->used);
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET `characterId` = :characterId, `spellId` = :spellId, `slot` = :slot, `used` = :used " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":characterId", $this->characterId);
        $stmt->bindParam(":spellId", $this->spellId);
        $stmt->bindParam(":slot", $this->slot);
        $stmt->bindParam(":used", $this->used);
    }

    public static function getSQLDel() {
        return "DELETE FROM " . self::tableName . " WHERE id=:id;";
    }

    public function bindSQLDel(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
    }

    public function getAjax() {
        return array(
        "id" => $this->id, 
        "characterId" => $this->characterId, 
        "spellId" => $this->spellId, 
        "slot" => $this->slot, 
        "used" => $this->used, 
        "object" => $this->object, 
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
        $this->characterId =  $rec["characterId"];
        $this->spellId =  $rec["spellId"];
        $this->slot =  $rec["slot"];
        $this->used =  $rec["used"];
    }

}

?>