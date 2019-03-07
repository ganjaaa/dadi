<?php

namespace DND\Objects;


class Inventory implements \DND\Interfaces\Objects {

    const tableName = 'dnd_inventory';
    const IDX_KNOWLEDGE_UNKNOWN = 0;
    const IDX_KNOWLEDGE_KNOWN = 1;
    const IDX_KNOWLEDGE_BETTER_KNOWN = 2;
    const IDX_KNOWLEDGE_MASTERED = 3;

    private $id;
    private $characterId;
    private $itemId;
    private $amount = 0;
    private $knowledge = self::IDX_KNOWLEDGE_UNKNOWN;
    private $object = 0;

    public function __construct() {
    }

    public function getDisplayData() {
        return array(
        "id" => $this->id, 
        "characterId" => $this->characterId, 
        "itemId" => $this->itemId, 
        "amount" => $this->amount, 
        "knowledge" => $this->knowledge,
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

    public function getItemid() {
        return $this->itemId;
    }

    public function setItemid($value) {
        $this->itemId = $value;
        return $this;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setAmount($value) {
        $this->amount = $value;
        return $this;
    }

    public function getKnowledge() {
        return $this->knowledge;
    }

    public function setKnowledge($value) {
        $this->knowledge = $value;
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
        if(isset($array["itemId"])){$this->itemId = $array["itemId"];}
        if(isset($array["amount"])){$this->amount = $array["amount"];}
        if(isset($array["knowledge"])){$this->knowledge = $array["knowledge"];}
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`, `characterId`, `itemId`, `amount`, `knowledge` )" . " VALUES " . " (NULL , :characterId, :itemId, :amount, :knowledge );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
        $stmt->bindParam(":characterId", $this->characterId);
        $stmt->bindParam(":itemId", $this->itemId);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":knowledge", $this->knowledge);
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET `characterId` = :characterId, `itemId` = :itemId, `amount` = :amount, `knowledge` = :knowledge " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":characterId", $this->characterId);
        $stmt->bindParam(":itemId", $this->itemId);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":knowledge", $this->knowledge);
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
        "itemId" => $this->itemId, 
        "amount" => $this->amount, 
        "knowledge" => $this->knowledge, 
        "object" => $this->object, 
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
        $this->characterId =  $rec["characterId"];
        $this->itemId =  $rec["itemId"];
        $this->amount =  $rec["amount"];
        $this->knowledge =  $rec["knowledge"];
    }

}

?>