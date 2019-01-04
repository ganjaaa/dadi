<?php

namespace DND\Objects;


class Environment implements \DND\Interfaces\Objects {

    const tableName = 'dnd_environment';

    private $id;
    private $name;
    private $time;
    private $day;
    private $month;
    private $year;
    private $weather;
    private $temperature;
    private $humidity;
    private $smog;
    private $modifier;
    private $globalQuests;
    private $map;
    private $mapBG;
    private $mapShadow;

    public function __construct() {
    }

    public function getMoon() {
        $cal = new \DND\Core\Calendar();
        $cal->setDay($this->day);
        $cal->setMonth($this->month);
        $cal->setYear($this->year);
        list($a, $b) = explode(':', $this->time);
        $cal->setTime($a, $b);
        return $cal->getDate();

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

    public function getTime() {
        return $this->time;
    }

    public function setTime($value) {
        $this->time = $value;
        return $this;
    }

    public function getDay() {
        return $this->day;
    }

    public function setDay($value) {
        $this->day = $value;
        return $this;
    }

    public function getMonth() {
        return $this->month;
    }

    public function setMonth($value) {
        $this->month = $value;
        return $this;
    }

    public function getYear() {
        return $this->year;
    }

    public function setYear($value) {
        $this->year = $value;
        return $this;
    }

    public function getWeather() {
        return $this->weather;
    }

    public function setWeather($value) {
        $this->weather = $value;
        return $this;
    }

    public function getTemperature() {
        return $this->temperature;
    }

    public function setTemperature($value) {
        $this->temperature = $value;
        return $this;
    }

    public function getHumidity() {
        return $this->humidity;
    }

    public function setHumidity($value) {
        $this->humidity = $value;
        return $this;
    }

    public function getSmog() {
        return $this->smog;
    }

    public function setSmog($value) {
        $this->smog = $value;
        return $this;
    }

    public function getModifier() {
        return $this->modifier;
    }

    public function setModifier($value) {
        $this->modifier = $value;
        return $this;
    }

    public function getGlobalquests() {
        return $this->globalQuests;
    }

    public function setGlobalquests($value) {
        $this->globalQuests = $value;
        return $this;
    }

    public function getMap() {
        return $this->map;
    }

    public function setMap($value) {
        $this->map = $value;
        return $this;
    }

    public function getMapbg() {
        return $this->mapBG;
    }

    public function setMapbg($value) {
        $this->mapBG = $value;
        return $this;
    }

    public function getMapshadow() {
        return $this->mapShadow;
    }

    public function setMapshadow($value) {
        $this->mapShadow = $value;
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
        if(isset($array["time"])){$this->time = $array["time"];}
        if(isset($array["day"])){$this->day = $array["day"];}
        if(isset($array["month"])){$this->month = $array["month"];}
        if(isset($array["year"])){$this->year = $array["year"];}
        if(isset($array["weather"])){$this->weather = $array["weather"];}
        if(isset($array["temperature"])){$this->temperature = $array["temperature"];}
        if(isset($array["humidity"])){$this->humidity = $array["humidity"];}
        if(isset($array["smog"])){$this->smog = $array["smog"];}
        if(isset($array["modifier"])){$this->modifier = $array["modifier"];}
        if(isset($array["globalQuests"])){$this->globalQuests = $array["globalQuests"];}
        if(isset($array["map"])){$this->map = $array["map"];}
        if(isset($array["mapBG"])){$this->mapBG = $array["mapBG"];}
        if(isset($array["mapShadow"])){$this->mapShadow = $array["mapShadow"];}
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`, `name`, `time`, `day`, `month`, `year`, `weather`, `temperature`, `humidity`, `smog`, `modifier`, `globalQuests`, `map`, `mapBG`, `mapShadow` )" . " VALUES " . " (NULL , :name, :time, :day, :month, :year, :weather, :temperature, :humidity, :smog, :modifier, :globalQuests, :map, :mapBG, :mapShadow );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":time", $this->time);
        $stmt->bindParam(":day", $this->day);
        $stmt->bindParam(":month", $this->month);
        $stmt->bindParam(":year", $this->year);
        $stmt->bindParam(":weather", $this->weather);
        $stmt->bindParam(":temperature", $this->temperature);
        $stmt->bindParam(":humidity", $this->humidity);
        $stmt->bindParam(":smog", $this->smog);
        $stmt->bindParam(":modifier", $this->modifier);
        $stmt->bindParam(":globalQuests", $this->globalQuests);
        $stmt->bindParam(":map", $this->map);
        $stmt->bindParam(":mapBG", $this->mapBG);
        $stmt->bindParam(":mapShadow", $this->mapShadow);
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET `name` = :name, `time` = :time, `day` = :day, `month` = :month, `year` = :year, `weather` = :weather, `temperature` = :temperature, `humidity` = :humidity, `smog` = :smog, `modifier` = :modifier, `globalQuests` = :globalQuests, `map` = :map, `mapBG` = :mapBG, `mapShadow` = :mapShadow " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":time", $this->time);
        $stmt->bindParam(":day", $this->day);
        $stmt->bindParam(":month", $this->month);
        $stmt->bindParam(":year", $this->year);
        $stmt->bindParam(":weather", $this->weather);
        $stmt->bindParam(":temperature", $this->temperature);
        $stmt->bindParam(":humidity", $this->humidity);
        $stmt->bindParam(":smog", $this->smog);
        $stmt->bindParam(":modifier", $this->modifier);
        $stmt->bindParam(":globalQuests", $this->globalQuests);
        $stmt->bindParam(":map", $this->map);
        $stmt->bindParam(":mapBG", $this->mapBG);
        $stmt->bindParam(":mapShadow", $this->mapShadow);
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
        "time" => $this->time, 
        "day" => $this->day, 
        "month" => $this->month, 
        "year" => $this->year, 
        "weather" => $this->weather, 
        "temperature" => $this->temperature, 
        "humidity" => $this->humidity, 
        "smog" => $this->smog, 
        "modifier" => $this->modifier, 
        "globalQuests" => $this->globalQuests, 
        "map" => $this->map, 
        "mapBG" => $this->mapBG, 
        "mapShadow" => $this->mapShadow, 
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
        $this->name =  $rec["name"];
        $this->time =  $rec["time"];
        $this->day =  $rec["day"];
        $this->month =  $rec["month"];
        $this->year =  $rec["year"];
        $this->weather =  $rec["weather"];
        $this->temperature =  $rec["temperature"];
        $this->humidity =  $rec["humidity"];
        $this->smog =  $rec["smog"];
        $this->modifier =  $rec["modifier"];
        $this->globalQuests =  $rec["globalQuests"];
        $this->map =  $rec["map"];
        $this->mapBG =  $rec["mapBG"];
        $this->mapShadow =  $rec["mapShadow"];
    }

}

?>