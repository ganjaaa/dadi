<?php

namespace DND\Objects;


class MapTraits implements \DND\Interfaces\Objects {

    const tableName = 'dnd_feature';
    const CLASS_RACES = "Races";
    const CLASS_BACKGROUND = "Background";

    private $id;
    private $classname;
    private $foreignId;
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

    public function getClassname() {
        return $this->classname;
    }

    public function setClassname($value) {
        $this->classname = $value;
        return $this;
    }

    public function getForeignid() {
        return $this->foreignId;
    }

    public function setForeignid($value) {
        $this->foreignId = $value;
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
        if(isset($array["id"])){$this->id = $array["id"];}
        if(isset($array["classname"])){$this->classname = $array["classname"];}
        if(isset($array["foreignId"])){$this->foreignId = $array["foreignId"];}
        if(isset($array["traitId"])){$this->traitId = $array["traitId"];}
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`, `classname`, `foreignId`, `traitId` )" . " VALUES " . " (NULL , :classname, :foreignId, :traitId );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
        $stmt->bindParam(":classname", $this->classname);
        $stmt->bindParam(":foreignId", $this->foreignId);
        $stmt->bindParam(":traitId", $this->traitId);
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET `classname` = :classname, `foreignId` = :foreignId, `traitId` = :traitId " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":classname", $this->classname);
        $stmt->bindParam(":foreignId", $this->foreignId);
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
        "classname" => $this->classname, 
        "foreignId" => $this->foreignId, 
        "traitId" => $this->traitId, 
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
        $this->classname =  $rec["classname"];
        $this->foreignId =  $rec["foreignId"];
        $this->traitId =  $rec["traitId"];
    }

}

?>