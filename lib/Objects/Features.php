<?php

namespace DND\Objects;


class Features implements \DND\Interfaces\Objects {

    const tableName = 'dnd_features';

    private $id;
    private $name;
    private $description;
    private $modifier;

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

    public function getModifier() {
        return $this->modifier;
    }

    public function setModifier($value) {
        $this->modifier = $value;
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
        if(isset($array["modifier"])){$this->modifier = $array["modifier"];}
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`, `name`, `description`, `modifier` )" . " VALUES " . " (NULL , :name, :description, :modifier );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":modifier", $this->modifier);
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET `name` = :name, `description` = :description, `modifier` = :modifier " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":modifier", $this->modifier);
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
        "modifier" => $this->modifier, 
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
        $this->name =  $rec["name"];
        $this->description =  $rec["description"];
        $this->modifier =  $rec["modifier"];
    }

}

?>