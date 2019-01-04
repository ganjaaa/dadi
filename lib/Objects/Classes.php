<?php

namespace DND\Objects;


class Classes implements \DND\Interfaces\Objects {

    const tableName = 'dnd_classes';

    private $id;
    private $name;
    private $hd;
    private $proficiency;
    private $spellAbility;

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

    public function getHd() {
        return $this->hd;
    }

    public function setHd($value) {
        $this->hd = $value;
        return $this;
    }

    public function getProficiency() {
        return $this->proficiency;
    }

    public function setProficiency($value) {
        $this->proficiency = $value;
        return $this;
    }

    public function getSpellability() {
        return $this->spellAbility;
    }

    public function setSpellability($value) {
        $this->spellAbility = $value;
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
        if(isset($array["name"])){$this->name = $array["name"];}
        if(isset($array["hd"])){$this->hd = $array["hd"];}
        if(isset($array["proficiency"])){$this->proficiency = $array["proficiency"];}
        if(isset($array["spellAbility"])){$this->spellAbility = $array["spellAbility"];}
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`, `name`, `hd`, `proficiency`, `spellAbility` )" . " VALUES " . " (NULL , :name, :hd, :proficiency, :spellAbility );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":hd", $this->hd);
        $stmt->bindParam(":proficiency", $this->proficiency);
        $stmt->bindParam(":spellAbility", $this->spellAbility);
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET `name` = :name, `hd` = :hd, `proficiency` = :proficiency, `spellAbility` = :spellAbility " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":hd", $this->hd);
        $stmt->bindParam(":proficiency", $this->proficiency);
        $stmt->bindParam(":spellAbility", $this->spellAbility);
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
        "hd" => $this->hd, 
        "proficiency" => $this->proficiency, 
        "spellAbility" => $this->spellAbility, 
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
        $this->name =  $rec["name"];
        $this->hd =  $rec["hd"];
        $this->proficiency =  $rec["proficiency"];
        $this->spellAbility =  $rec["spellAbility"];
    }

}

?>