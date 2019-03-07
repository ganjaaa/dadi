<?php

namespace DND\Objects;

use \DND\Core\Rules;

class Account implements \DND\Interfaces\Objects {

    const tableName = 'dnd_account';

    private $id;
    private $active;
    private $mail;
    private $password;
    private $token;
    private $secToken;
    private $lastLogin;
    private $lastIp;
    private $gm;

    public function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function setId($value) {
        $this->id = $value;
        return $this;
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive($value) {
        $this->active = $value;
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

    public function setPassword($value) {
        $this->password = $value;
        return $this;
    }

    public function getToken() {
        return $this->token;
    }

    public function setToken($value) {
        $this->token = $value;
        return $this;
    }

    public function getSectoken() {
        return $this->secToken;
    }

    public function setSectoken($value) {
        $this->secToken = $value;
        return $this;
    }

    public function getLastlogin() {
        return $this->lastLogin;
    }

    public function setLastlogin($value) {
        $this->lastLogin = $value;
        return $this;
    }

    public function getLastip() {
        return $this->lastIp;
    }

    public function setLastip($value) {
        $this->lastIp = $value;
        return $this;
    }

    public function getGm() {
        return $this->gm;
    }

    public function setGm($value) {
        $this->gm = $value;
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
        if(isset($array["active"])){$this->active = $array["active"];}
        if(isset($array["mail"])){$this->mail = $array["mail"];}
        if(isset($array["password"])){$this->password = $array["password"];}
        if(isset($array["token"])){$this->token = $array["token"];}
        if(isset($array["secToken"])){$this->secToken = $array["secToken"];}
        if(isset($array["lastLogin"])){$this->lastLogin = $array["lastLogin"];}
        if(isset($array["lastIp"])){$this->lastIp = $array["lastIp"];}
        if(isset($array["gm"])){$this->gm = $array["gm"];}
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`, `active`, `mail`, `password`, `token`, `secToken`, `lastLogin`, `lastIp`, `gm` )" . " VALUES " . " (NULL , :active, :mail, :password, :token, :secToken, :lastLogin, :lastIp, :gm );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
        $stmt->bindParam(":active", $this->active);
        $stmt->bindParam(":mail", $this->mail);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":token", $this->token);
        $stmt->bindParam(":secToken", $this->secToken);
        $stmt->bindParam(":lastLogin", $this->lastLogin);
        $stmt->bindParam(":lastIp", $this->lastIp);
        $stmt->bindParam(":gm", $this->gm);
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET `active` = :active, `mail` = :mail, `password` = :password, `token` = :token, `secToken` = :secToken, `lastLogin` = :lastLogin, `lastIp` = :lastIp, `gm` = :gm " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":active", $this->active);
        $stmt->bindParam(":mail", $this->mail);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":token", $this->token);
        $stmt->bindParam(":secToken", $this->secToken);
        $stmt->bindParam(":lastLogin", $this->lastLogin);
        $stmt->bindParam(":lastIp", $this->lastIp);
        $stmt->bindParam(":gm", $this->gm);
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
        "active" => $this->active, 
        "mail" => $this->mail, 
        "password" => $this->password, 
        "token" => $this->token, 
        "secToken" => $this->secToken, 
        "lastLogin" => $this->lastLogin, 
        "lastIp" => $this->lastIp, 
        "gm" => $this->gm, 
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
        $this->active =  $rec["active"];
        $this->mail =  $rec["mail"];
        $this->password =  $rec["password"];
        $this->token =  $rec["token"];
        $this->secToken =  $rec["secToken"];
        $this->lastLogin =  $rec["lastLogin"];
        $this->lastIp =  $rec["lastIp"];
        $this->gm =  $rec["gm"];
    }

}

?>