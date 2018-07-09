<?php

namespace DND\Objects;


class RacesTraits implements \DND\Interfaces\Objects {

    const tableName = 'dnd_races_traits';

    private $id;
    private $raceId;
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

    public function getRaceid() {
        return $this->raceId;
    }

    public function setRaceid($value) {
        $this->raceId = $value;
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
        if(isset($array["raceId"])){$this->raceId = $array["raceId"];}
        if(isset($array["traitId"])){$this->traitId = $array["traitId"];}
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`, `raceId`, `traitId` )" . " VALUES " . " (NULL , :raceId, :traitId );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
        $stmt->bindParam(":raceId", $this->raceId);
        $stmt->bindParam(":traitId", $this->traitId);
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET `raceId` = :raceId, `traitId` = :traitId " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":raceId", $this->raceId);
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
        "raceId" => $this->raceId, 
        "traitId" => $this->traitId, 
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
        $this->raceId =  $rec["raceId"];
        $this->traitId =  $rec["traitId"];
    }

}

?>