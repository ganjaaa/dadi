<?php

namespace DND\Objects;


class BackgroundsTraits implements \DND\Interfaces\Objects {

    const tableName = 'dnd_backgrounds_traits';

    private $id;
    private $backgroundId;
    private $traitId;

    public function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function setId($value) {
        $this->id = $value;
        return $this;
    }

    public function getBackgroundid() {
        return $this->backgroundId;
    }

    public function setBackgroundid($value) {
        $this->backgroundId = $value;
        return $this;
    }

    public function getTraitid() {
        return $this->traitId;
    }

    public function setTraitid($value) {
        $this->traitId = $value;
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
        if(isset($array["backgroundId"])){$this->backgroundId = $array["backgroundId"];}
        if(isset($array["traitId"])){$this->traitId = $array["traitId"];}
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`, `backgroundId`, `traitId` )" . " VALUES " . " (NULL , :backgroundId, :traitId );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
        $stmt->bindParam(":backgroundId", $this->backgroundId);
        $stmt->bindParam(":traitId", $this->traitId);
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET `backgroundId` = :backgroundId, `traitId` = :traitId " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":backgroundId", $this->backgroundId);
        $stmt->bindParam(":traitId", $this->traitId);
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
        "backgroundId" => $this->backgroundId, 
        "traitId" => $this->traitId, 
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
        $this->backgroundId =  $rec["backgroundId"];
        $this->traitId =  $rec["traitId"];
    }

}

?>