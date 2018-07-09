<?php

namespace DND\Objects;


class Slots implements \DND\Interfaces\Objects {

    const tableName = 'dnd_slots';

    private $id;
    private $s0;
    private $s1;
    private $s2;
    private $s3;
    private $s4;
    private $s5;
    private $s6;
    private $s7;
    private $s8;
    private $s9;
    private $s10;

    public function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function setId($value) {
        $this->id = $value;
        return $this;
    }

    public function getS0() {
        return $this->s0;
    }

    public function setS0($value) {
        $this->s0 = $value;
        return $this;
    }

    public function getS1() {
        return $this->s1;
    }

    public function setS1($value) {
        $this->s1 = $value;
        return $this;
    }

    public function getS2() {
        return $this->s2;
    }

    public function setS2($value) {
        $this->s2 = $value;
        return $this;
    }

    public function getS3() {
        return $this->s3;
    }

    public function setS3($value) {
        $this->s3 = $value;
        return $this;
    }

    public function getS4() {
        return $this->s4;
    }

    public function setS4($value) {
        $this->s4 = $value;
        return $this;
    }

    public function getS5() {
        return $this->s5;
    }

    public function setS5($value) {
        $this->s5 = $value;
        return $this;
    }

    public function getS6() {
        return $this->s6;
    }

    public function setS6($value) {
        $this->s6 = $value;
        return $this;
    }

    public function getS7() {
        return $this->s7;
    }

    public function setS7($value) {
        $this->s7 = $value;
        return $this;
    }

    public function getS8() {
        return $this->s8;
    }

    public function setS8($value) {
        $this->s8 = $value;
        return $this;
    }

    public function getS9() {
        return $this->s9;
    }

    public function setS9($value) {
        $this->s9 = $value;
        return $this;
    }

    public function getS10() {
        return $this->s10;
    }

    public function setS10($value) {
        $this->s10 = $value;
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
        if(isset($array["s0"])){$this->s0 = $array["s0"];}
        if(isset($array["s1"])){$this->s1 = $array["s1"];}
        if(isset($array["s2"])){$this->s2 = $array["s2"];}
        if(isset($array["s3"])){$this->s3 = $array["s3"];}
        if(isset($array["s4"])){$this->s4 = $array["s4"];}
        if(isset($array["s5"])){$this->s5 = $array["s5"];}
        if(isset($array["s6"])){$this->s6 = $array["s6"];}
        if(isset($array["s7"])){$this->s7 = $array["s7"];}
        if(isset($array["s8"])){$this->s8 = $array["s8"];}
        if(isset($array["s9"])){$this->s9 = $array["s9"];}
        if(isset($array["s10"])){$this->s10 = $array["s10"];}
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`, `s0`, `s1`, `s2`, `s3`, `s4`, `s5`, `s6`, `s7`, `s8`, `s9`, `s10` )" . " VALUES " . " (NULL , :s0, :s1, :s2, :s3, :s4, :s5, :s6, :s7, :s8, :s9, :s10 );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
        $stmt->bindParam(":s0", $this->s0);
        $stmt->bindParam(":s1", $this->s1);
        $stmt->bindParam(":s2", $this->s2);
        $stmt->bindParam(":s3", $this->s3);
        $stmt->bindParam(":s4", $this->s4);
        $stmt->bindParam(":s5", $this->s5);
        $stmt->bindParam(":s6", $this->s6);
        $stmt->bindParam(":s7", $this->s7);
        $stmt->bindParam(":s8", $this->s8);
        $stmt->bindParam(":s9", $this->s9);
        $stmt->bindParam(":s10", $this->s10);
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET `s0` = :s0, `s1` = :s1, `s2` = :s2, `s3` = :s3, `s4` = :s4, `s5` = :s5, `s6` = :s6, `s7` = :s7, `s8` = :s8, `s9` = :s9, `s10` = :s10 " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":s0", $this->s0);
        $stmt->bindParam(":s1", $this->s1);
        $stmt->bindParam(":s2", $this->s2);
        $stmt->bindParam(":s3", $this->s3);
        $stmt->bindParam(":s4", $this->s4);
        $stmt->bindParam(":s5", $this->s5);
        $stmt->bindParam(":s6", $this->s6);
        $stmt->bindParam(":s7", $this->s7);
        $stmt->bindParam(":s8", $this->s8);
        $stmt->bindParam(":s9", $this->s9);
        $stmt->bindParam(":s10", $this->s10);
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
        "s0" => $this->s0, 
        "s1" => $this->s1, 
        "s2" => $this->s2, 
        "s3" => $this->s3, 
        "s4" => $this->s4, 
        "s5" => $this->s5, 
        "s6" => $this->s6, 
        "s7" => $this->s7, 
        "s8" => $this->s8, 
        "s9" => $this->s9, 
        "s10" => $this->s10, 
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
        $this->s0 =  $rec["s0"];
        $this->s1 =  $rec["s1"];
        $this->s2 =  $rec["s2"];
        $this->s3 =  $rec["s3"];
        $this->s4 =  $rec["s4"];
        $this->s5 =  $rec["s5"];
        $this->s6 =  $rec["s6"];
        $this->s7 =  $rec["s7"];
        $this->s8 =  $rec["s8"];
        $this->s9 =  $rec["s9"];
        $this->s10 =  $rec["s10"];
    }

}

?>