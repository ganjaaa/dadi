<?php

namespace DND\Objects;


class ClassesLevel implements \DND\Interfaces\Objects {

    const tableName = 'dnd_classes_level';

    private $id;
    private $classId;
    private $level;
    private $kind;
    private $kindId;

    public function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function setId($value) {
        $this->id = $value;
        return $this;
    }

    public function getClassid() {
        return $this->classId;
    }

    public function setClassid($value) {
        $this->classId = $value;
        return $this;
    }

    public function getLevel() {
        return $this->level;
    }

    public function setLevel($value) {
        $this->level = $value;
        return $this;
    }

    public function getKind() {
        return $this->kind;
    }

    public function setKind($value) {
        $this->kind = $value;
        return $this;
    }

    public function getKindid() {
        return $this->kindId;
    }

    public function setKindid($value) {
        $this->kindId = $value;
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
        if(isset($array["classId"])){$this->classId = $array["classId"];}
        if(isset($array["level"])){$this->level = $array["level"];}
        if(isset($array["kind"])){$this->kind = $array["kind"];}
        if(isset($array["kindId"])){$this->kindId = $array["kindId"];}
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`, `classId`, `level`, `kind`, `kindId` )" . " VALUES " . " (NULL , :classId, :level, :kind, :kindId );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
        $stmt->bindParam(":classId", $this->classId);
        $stmt->bindParam(":level", $this->level);
        $stmt->bindParam(":kind", $this->kind);
        $stmt->bindParam(":kindId", $this->kindId);
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET `classId` = :classId, `level` = :level, `kind` = :kind, `kindId` = :kindId " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":classId", $this->classId);
        $stmt->bindParam(":level", $this->level);
        $stmt->bindParam(":kind", $this->kind);
        $stmt->bindParam(":kindId", $this->kindId);
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
        "classId" => $this->classId, 
        "level" => $this->level, 
        "kind" => $this->kind, 
        "kindId" => $this->kindId, 
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
        $this->classId =  $rec["classId"];
        $this->level =  $rec["level"];
        $this->kind =  $rec["kind"];
        $this->kindId =  $rec["kindId"];
    }

}

?>