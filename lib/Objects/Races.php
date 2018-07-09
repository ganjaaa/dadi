<?php

namespace DND\Objects;


class Races implements \DND\Interfaces\Objects {

    const tableName = 'dnd_races';

    private $id;
    private $name;
    private $size;
    private $speed;
    private $ability;
    private $proficiency;

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

    public function getSize() {
        return $this->size;
    }

    public function setSize($value) {
        $this->size = $value;
        return $this;
    }

    public function getSpeed() {
        return $this->speed;
    }

    public function setSpeed($value) {
        $this->speed = $value;
        return $this;
    }

    public function getAbility() {
        return $this->ability;
    }

    public function setAbility($value) {
        $this->ability = $value;
        return $this;
    }

    public function getProficiency() {
        return $this->proficiency;
    }

    public function setProficiency($value) {
        $this->proficiency = $value;
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
        if(isset($array["size"])){$this->size = $array["size"];}
        if(isset($array["speed"])){$this->speed = $array["speed"];}
        if(isset($array["ability"])){$this->ability = $array["ability"];}
        if(isset($array["proficiency"])){$this->proficiency = $array["proficiency"];}
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`, `name`, `size`, `speed`, `ability`, `proficiency` )" . " VALUES " . " (NULL , :name, :size, :speed, :ability, :proficiency );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":size", $this->size);
        $stmt->bindParam(":speed", $this->speed);
        $stmt->bindParam(":ability", $this->ability);
        $stmt->bindParam(":proficiency", $this->proficiency);
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET `name` = :name, `size` = :size, `speed` = :speed, `ability` = :ability, `proficiency` = :proficiency " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":size", $this->size);
        $stmt->bindParam(":speed", $this->speed);
        $stmt->bindParam(":ability", $this->ability);
        $stmt->bindParam(":proficiency", $this->proficiency);
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
        "size" => $this->size, 
        "speed" => $this->speed, 
        "ability" => $this->ability, 
        "proficiency" => $this->proficiency, 
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
        $this->name =  $rec["name"];
        $this->size =  $rec["size"];
        $this->speed =  $rec["speed"];
        $this->ability =  $rec["ability"];
        $this->proficiency =  $rec["proficiency"];
    }

}

?>