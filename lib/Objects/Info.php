<?php

namespace DND\Objects;


class Info implements \DND\Interfaces\Objects {

    const tableName = 'dnd_info';

    private $id;
    private $userId;
    private $date;
    private $message;
    private $command;
    private $read;

    public function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function setId($value) {
        $this->id = $value;
        return $this;
    }

    public function getUserid() {
        return $this->userId;
    }

    public function setUserid($value) {
        $this->userId = $value;
        return $this;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($value) {
        $this->date = $value;
        return $this;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($value) {
        $this->message = $value;
        return $this;
    }

    public function getCommand() {
        return $this->command;
    }

    public function setCommand($value) {
        $this->command = $value;
        return $this;
    }

    public function getRead() {
        return $this->read;
    }

    public function setRead($value) {
        $this->read = $value;
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
        if(isset($array["userId"])){$this->userId = $array["userId"];}
        if(isset($array["date"])){$this->date = $array["date"];}
        if(isset($array["message"])){$this->message = $array["message"];}
        if(isset($array["command"])){$this->command = $array["command"];}
        if(isset($array["read"])){$this->read = $array["read"];}
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`, `userId`, `date`, `message`, `command`, `read` )" . " VALUES " . " (NULL , :userId, :date, :message, :command, :read );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":message", $this->message);
        $stmt->bindParam(":command", $this->command);
        $stmt->bindParam(":read", $this->read);
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET `userId` = :userId, `date` = :date, `message` = :message, `command` = :command, `read` = :read " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":message", $this->message);
        $stmt->bindParam(":command", $this->command);
        $stmt->bindParam(":read", $this->read);
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
        "userId" => $this->userId, 
        "date" => $this->date, 
        "message" => $this->message, 
        "command" => $this->command, 
        "read" => $this->read, 
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
        $this->userId =  $rec["userId"];
        $this->date =  $rec["date"];
        $this->message =  $rec["message"];
        $this->command =  $rec["command"];
        $this->read =  $rec["read"];
    }

}

?>