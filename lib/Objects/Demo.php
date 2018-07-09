<?php

namespace DND\Objects;


class Demo implements \DND\Interfaces\Objects {

    const tableName = 'demo';
    const IDX_MONEY_CP = 0;
    const IDX_MONEY_SP = 1;

    private $id;
    private $mail;
    private $password;
    private $accountId;
    private $environmentId;
    private $charname;
    private $strength = 0;
    private $dexterity = 0;

    public function __construct() {
    }

    public function hashPassword($a = NULL) {
        return md5($a);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($value) {
        $this->id = $value;
        return $this;
    }

    public function getMail() {
        return $this->mail;
    }

    public function setMail($value) {
        $this->mail = $value;
        return $this;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($a) {
        $this->password = $this->hashPassword($a);
return $this;
    }

    public function getAccountid() {
        return $this->accountId;
    }

    public function setAccountid($value) {
        $this->accountId = $value;
        return $this;
    }

    public function getEnvironmentid() {
        return $this->environmentId;
    }

    public function setEnvironmentid($value) {
        $this->environmentId = $value;
        return $this;
    }

    public function getCharname() {
        return $this->charname;
    }

    public function setCharname($value) {
        $this->charname = $value;
        return $this;
    }

    public function getStrength() {
        return $this->strength;
    }

    public function setStrength($value) {
        $this->strength = $value;
        return $this;
    }

    public function getDexterity() {
        return $this->dexterity;
    }

    public function setDexterity($value) {
        $this->dexterity = $value;
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
        if(isset($array["mail"]) ){$this->mail = $array["mail"];}
        if(isset($array["password"]) ){$this->password = $array["password"];}
        if(isset($array["accountId"]) && !empty($array["accountId"])){$this->accountId = $array["accountId"];}
        if(isset($array["environmentId"]) && !empty($array["environmentId"])){$this->environmentId = $array["environmentId"];}
        if(isset($array["charname"]) ){$this->charname = $array["charname"];}
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`, `mail`, `password`, `accountId`, `environmentId`, `charname` )" . " VALUES " . " (NULL , :mail, :password, :accountId, :environmentId, :charname );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
        $stmt->bindParam(":mail", $this->mail);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":accountId", $this->accountId);
        $stmt->bindParam(":environmentId", $this->environmentId);
        $stmt->bindParam(":charname", $this->charname);
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET `mail` = :mail, `password` = :password, `accountId` = :accountId, `environmentId` = :environmentId, `charname` = :charname " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":mail", $this->mail);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":accountId", $this->accountId);
        $stmt->bindParam(":environmentId", $this->environmentId);
        $stmt->bindParam(":charname", $this->charname);
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
        "mail" => $this->mail, 
        "password" => $this->password, 
        "accountId" => $this->accountId, 
        "environmentId" => $this->environmentId, 
        "charname" => $this->charname, 
        "strength" => $this->strength, 
        "dexterity" => $this->dexterity, 
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
        $this->mail =  $rec["mail"];
        $this->password =  $rec["password"];
        $this->accountId =  $rec["accountId"];
        $this->environmentId =  $rec["environmentId"];
        $this->charname =  $rec["charname"];
    }

}

?>