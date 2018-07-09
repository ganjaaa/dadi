<?php

namespace DND\Objects;


class Equipment implements \DND\Interfaces\Objects {

    const tableName = 'dnd_equipment';
    const IDX_MAX_SLOT_QUIVER = 3;
    const IDX_MAX_SLOT_HELMET = 1;
    const IDX_MAX_SLOT_CAPE = 1;
    const IDX_MAX_SLOT_NECKLACE = 1;
    const IDX_MAX_SLOT_GLOVES = 1;
    const IDX_MAX_SLOT_RING = 10;
    const IDX_MAX_SLOT_ARMOR = 1;
    const IDX_MAX_SLOT_WEAPON = 3;
    const IDX_MAX_SLOT_OFF_WEAPON = 1;
    const IDX_MAX_SLOT_BELT = 1;
    const IDX_MAX_SLOT_BOOTS = 1;

    private $id;
    private $userId;
    private $itemId;
    private $slot;

    public function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function setId($value) {
        $this->id = $value;
        return $this;
    }

    public function getUserid() {
        return $this->userId;
    }

    public function setUserid($value) {
        $this->userId = $value;
        return $this;
    }

    public function getItemid() {
        return $this->itemId;
    }

    public function setItemid($value) {
        $this->itemId = $value;
        return $this;
    }

    public function getSlot() {
        return $this->slot;
    }

    public function setSlot($value) {
        $this->slot = $value;
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
        if(isset($array["id"])){$this->id = $array["id"];}
        if(isset($array["userId"]) && !empty($array["userId"])){$this->userId = $array["userId"];}
        if(isset($array["itemId"]) && !empty($array["itemId"])){$this->itemId = $array["itemId"];}
        if(isset($array["slot"]) ){$this->slot = $array["slot"];}
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`, `userId`, `itemId`, `slot` )" . " VALUES " . " (NULL , :userId, :itemId, :slot );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":itemId", $this->itemId);
        $stmt->bindParam(":slot", $this->slot);
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET `userId` = :userId, `itemId` = :itemId, `slot` = :slot " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":itemId", $this->itemId);
        $stmt->bindParam(":slot", $this->slot);
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
        "userId" => $this->userId, 
        "itemId" => $this->itemId, 
        "slot" => $this->slot, 
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
        $this->userId =  $rec["userId"];
        $this->itemId =  $rec["itemId"];
        $this->slot =  $rec["slot"];
    }

}

?>