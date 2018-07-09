<?php

namespace DND\Objects;


class DNDConstantes implements \DND\Interfaces\Objects {

    const tableName = 'dndconstantes';
    const KIND_FEATURE = 0;
    const KIND_TRAIT = 1;
    const KIND_SLOT = 2;

    private $id;

    public function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function setId($value) {
        $this->id = $value;
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
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`,  )" . " VALUES " . " (NULL ,  );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET  " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
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
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
    }

}

?>