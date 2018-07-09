<?php

namespace DND\Objects;


class Spell implements \DND\Interfaces\Objects {

    const tableName = 'dnd_spell';

    private $id;
    private $name;
    private $description;
    private $level;
    private $school;
    private $time;
    private $range;
    private $components;
    private $duration;
    private $classes;
    private $roll;
    private $ritual;

    public function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function setId($value) {
        $this->id = $value;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($value) {
        $this->name = $value;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($value) {
        $this->description = $value;
        return $this;
    }

    public function getLevel() {
        return $this->level;
    }

    public function setLevel($value) {
        $this->level = $value;
        return $this;
    }

    public function getSchool() {
        return $this->school;
    }

    public function setSchool($value) {
        $this->school = $value;
        return $this;
    }

    public function getTime() {
        return $this->time;
    }

    public function setTime($value) {
        $this->time = $value;
        return $this;
    }

    public function getRange() {
        return $this->range;
    }

    public function setRange($value) {
        $this->range = $value;
        return $this;
    }

    public function getComponents() {
        return $this->components;
    }

    public function setComponents($value) {
        $this->components = $value;
        return $this;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function setDuration($value) {
        $this->duration = $value;
        return $this;
    }

    public function getClasses() {
        return $this->classes;
    }

    public function setClasses($value) {
        $this->classes = $value;
        return $this;
    }

    public function getRoll() {
        return $this->roll;
    }

    public function setRoll($value) {
        $this->roll = $value;
        return $this;
    }

    public function getRitual() {
        return $this->ritual;
    }

    public function setRitual($value) {
        $this->ritual = $value;
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
        if(isset($array["name"])){$this->name = $array["name"];}
        if(isset($array["description"])){$this->description = $array["description"];}
        if(isset($array["level"])){$this->level = $array["level"];}
        if(isset($array["school"])){$this->school = $array["school"];}
        if(isset($array["time"])){$this->time = $array["time"];}
        if(isset($array["range"])){$this->range = $array["range"];}
        if(isset($array["components"])){$this->components = $array["components"];}
        if(isset($array["duration"])){$this->duration = $array["duration"];}
        if(isset($array["classes"])){$this->classes = $array["classes"];}
        if(isset($array["roll"])){$this->roll = $array["roll"];}
        if(isset($array["ritual"])){$this->ritual = $array["ritual"];}
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`, `name`, `description`, `level`, `school`, `time`, `range`, `components`, `duration`, `classes`, `roll`, `ritual` )" . " VALUES " . " (NULL , :name, :description, :level, :school, :time, :range, :components, :duration, :classes, :roll, :ritual );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":level", $this->level);
        $stmt->bindParam(":school", $this->school);
        $stmt->bindParam(":time", $this->time);
        $stmt->bindParam(":range", $this->range);
        $stmt->bindParam(":components", $this->components);
        $stmt->bindParam(":duration", $this->duration);
        $stmt->bindParam(":classes", $this->classes);
        $stmt->bindParam(":roll", $this->roll);
        $stmt->bindParam(":ritual", $this->ritual);
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET `name` = :name, `description` = :description, `level` = :level, `school` = :school, `time` = :time, `range` = :range, `components` = :components, `duration` = :duration, `classes` = :classes, `roll` = :roll, `ritual` = :ritual " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":level", $this->level);
        $stmt->bindParam(":school", $this->school);
        $stmt->bindParam(":time", $this->time);
        $stmt->bindParam(":range", $this->range);
        $stmt->bindParam(":components", $this->components);
        $stmt->bindParam(":duration", $this->duration);
        $stmt->bindParam(":classes", $this->classes);
        $stmt->bindParam(":roll", $this->roll);
        $stmt->bindParam(":ritual", $this->ritual);
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
        "name" => $this->name, 
        "description" => $this->description, 
        "level" => $this->level, 
        "school" => $this->school, 
        "time" => $this->time, 
        "range" => $this->range, 
        "components" => $this->components, 
        "duration" => $this->duration, 
        "classes" => $this->classes, 
        "roll" => $this->roll, 
        "ritual" => $this->ritual, 
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
        $this->name =  $rec["name"];
        $this->description =  $rec["description"];
        $this->level =  $rec["level"];
        $this->school =  $rec["school"];
        $this->time =  $rec["time"];
        $this->range =  $rec["range"];
        $this->components =  $rec["components"];
        $this->duration =  $rec["duration"];
        $this->classes =  $rec["classes"];
        $this->roll =  $rec["roll"];
        $this->ritual =  $rec["ritual"];
    }

}

?>