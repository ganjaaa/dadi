<?php

namespace DND\Objects;


class Level implements \DND\Interfaces\Objects {

    const tableName = 'dnd_level';
    const TYPE_SLOTS = 0;
    const TYPE_FEATURE = 1;

    private $id;
    private $classId;
    private $level;
    private $type;
    private $name;
    private $text;
    private $slots;

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

    public function getType() {
        return $this->type;
    }

    public function setType($value) {
        $this->type = $value;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($value) {
        $this->name = $value;
        return $this;
    }

    public function getText() {
        return $this->text;
    }

    public function setText($value) {
        $this->text = $value;
        return $this;
    }

    public function getSlots() {
        return $this->slots;
    }

    public function setSlots($value) {
        $this->slots = $value;
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
        if(isset($array["classId"])){$this->classId = $array["classId"];}
        if(isset($array["level"])){$this->level = $array["level"];}
        if(isset($array["type"])){$this->type = $array["type"];}
        if(isset($array["name"])){$this->name = $array["name"];}
        if(isset($array["text"])){$this->text = $array["text"];}
        if(isset($array["slots"])){$this->slots = $array["slots"];}
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`, `classId`, `level`, `type`, `name`, `text`, `slots` )" . " VALUES " . " (NULL , :classId, :level, :type, :name, :text, :slots );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
        $stmt->bindParam(":classId", $this->classId);
        $stmt->bindParam(":level", $this->level);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":text", $this->text);
        $stmt->bindParam(":slots", $this->slots);
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET `classId` = :classId, `level` = :level, `type` = :type, `name` = :name, `text` = :text, `slots` = :slots " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":classId", $this->classId);
        $stmt->bindParam(":level", $this->level);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":text", $this->text);
        $stmt->bindParam(":slots", $this->slots);
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
        "type" => $this->type, 
        "name" => $this->name, 
        "text" => $this->text, 
        "slots" => $this->slots, 
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
        $this->classId =  $rec["classId"];
        $this->level =  $rec["level"];
        $this->type =  $rec["type"];
        $this->name =  $rec["name"];
        $this->text =  $rec["text"];
        $this->slots =  $rec["slots"];
    }

}

?>