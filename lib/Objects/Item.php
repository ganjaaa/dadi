<?php

namespace DND\Objects;


class Item implements \DND\Interfaces\Objects {

    const tableName = 'dnd_item';
    const IDX_RARE_COMMON = 0;
    const IDX_RARE_UNCOMMON = 1;
    const IDX_RARE_RARE = 2;
    const IDX_RARE_VERY_RARE = 3;
    const IDX_RARE_EPIC = 4;
    const IDX_RARE_LEGENDARY = 5;
    const IDX_RARE_UNIQUE = 6;
    const IDX_EQUIPT_NONE = 0;
    const IDX_EQUIPT_SLOT_QUIVER = 1;
    const IDX_EQUIPT_SLOT_HELMET = 2;
    const IDX_EQUIPT_SLOT_CAPE = 3;
    const IDX_EQUIPT_SLOT_NECKLACE = 4;
    const IDX_EQUIPT_SLOT_GLOVES = 5;
    const IDX_EQUIPT_SLOT_RING = 6;
    const IDX_EQUIPT_SLOT_ARMOR = 7;
    const IDX_EQUIPT_SLOT_WEAPON = 8;
    const IDX_EQUIPT_SLOT_OFF_WEAPON = 9;
    const IDX_EQUIPT_SLOT_BELT = 10;
    const IDX_EQUIPT_SLOT_BOOTS = 11;
    const IDX_TYPE_MONEY = "$";
    const IDX_TYPE_HEAVY_ARMOR = "HA";
    const IDX_TYPE_LIGHT_ARMOR = "LA";
    const IDX_TYPE_MEDIUM_ARMOR = "MA";
    const IDX_TYPE_AMONITION = "A";
    const IDX_TYPE_GATGET = "G";
    const IDX_TYPE_WEAR = "W";
    const IDX_TYPE_SCHILD = "S";
    const IDX_TYPE_MELEE_WEAPON = "M";
    const IDX_TYPE_RANGE_WEAPON = "R";
    const IDX_TYPE_POTION = "P";
    const IDX_TYPE_ROD = "RD";
    const IDX_TYPE_RING = "RG";
    const IDX_TYPE_SCROLL = "SC";
    const IDX_TYPE_STAFF = "ST";
    const IDX_TYPE_WAND = "WD";
    const IDX_STACKABLE = 1;
    const IDX_UNSTACKABLE = 0;

    private $id;
    private $name;
    private $description;
    private $weight;
    private $priceCP;
    private $priceSP;
    private $priceEP;
    private $priceGP;
    private $pricePP;
    private $magic;
    private $type;
    private $rarity;
    private $ac;
    private $strength;
    private $stealth;
    private $modifier;
    private $roll;
    private $dmg1;
    private $dmg2;
    private $dmgType;
    private $property;
    private $range;
    private $wearable;
    private $cursed;
    private $stackable;

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

    public function getWeight() {
        return $this->weight;
    }

    public function setWeight($value) {
        $this->weight = $value;
        return $this;
    }

    public function getPricecp() {
        return $this->priceCP;
    }

    public function setPricecp($value) {
        $this->priceCP = $value;
        return $this;
    }

    public function getPricesp() {
        return $this->priceSP;
    }

    public function setPricesp($value) {
        $this->priceSP = $value;
        return $this;
    }

    public function getPriceep() {
        return $this->priceEP;
    }

    public function setPriceep($value) {
        $this->priceEP = $value;
        return $this;
    }

    public function getPricegp() {
        return $this->priceGP;
    }

    public function setPricegp($value) {
        $this->priceGP = $value;
        return $this;
    }

    public function getPricepp() {
        return $this->pricePP;
    }

    public function setPricepp($value) {
        $this->pricePP = $value;
        return $this;
    }

    public function getMagic() {
        return $this->magic;
    }

    public function setMagic($value) {
        $this->magic = $value;
        return $this;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($value) {
        $this->type = $value;
        return $this;
    }

    public function getRarity() {
        return $this->rarity;
    }

    public function setRarity($value) {
        $this->rarity = $value;
        return $this;
    }

    public function getAc() {
        return $this->ac;
    }

    public function setAc($value) {
        $this->ac = $value;
        return $this;
    }

    public function getStrength() {
        return $this->strength;
    }

    public function setStrength($value) {
        $this->strength = $value;
        return $this;
    }

    public function getStealth() {
        return $this->stealth;
    }

    public function setStealth($value) {
        $this->stealth = $value;
        return $this;
    }

    public function getModifier() {
        return $this->modifier;
    }

    public function setModifier($value) {
        $this->modifier = $value;
        return $this;
    }

    public function getRoll() {
        return $this->roll;
    }

    public function setRoll($value) {
        $this->roll = $value;
        return $this;
    }

    public function getDmg1() {
        return $this->dmg1;
    }

    public function setDmg1($value) {
        $this->dmg1 = $value;
        return $this;
    }

    public function getDmg2() {
        return $this->dmg2;
    }

    public function setDmg2($value) {
        $this->dmg2 = $value;
        return $this;
    }

    public function getDmgtype() {
        return $this->dmgType;
    }

    public function setDmgtype($value) {
        $this->dmgType = $value;
        return $this;
    }

    public function getProperty() {
        return $this->property;
    }

    public function setProperty($value) {
        $this->property = $value;
        return $this;
    }

    public function getRange() {
        return $this->range;
    }

    public function setRange($value) {
        $this->range = $value;
        return $this;
    }

    public function getWearable() {
        return $this->wearable;
    }

    public function setWearable($value) {
        $this->wearable = $value;
        return $this;
    }

    public function getCursed() {
        return $this->cursed;
    }

    public function setCursed($value) {
        $this->cursed = $value;
        return $this;
    }

    public function getStackable() {
        return $this->stackable;
    }

    public function setStackable($value) {
        $this->stackable = $value;
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
        if(isset($array["description"])){$this->description = $array["description"];}
        if(isset($array["weight"])){$this->weight = $array["weight"];}
        if(isset($array["priceCP"])){$this->priceCP = $array["priceCP"];}
        if(isset($array["priceSP"])){$this->priceSP = $array["priceSP"];}
        if(isset($array["priceEP"])){$this->priceEP = $array["priceEP"];}
        if(isset($array["priceGP"])){$this->priceGP = $array["priceGP"];}
        if(isset($array["pricePP"])){$this->pricePP = $array["pricePP"];}
        if(isset($array["magic"])){$this->magic = $array["magic"];}
        if(isset($array["type"])){$this->type = $array["type"];}
        if(isset($array["rarity"])){$this->rarity = $array["rarity"];}
        if(isset($array["ac"])){$this->ac = $array["ac"];}
        if(isset($array["strength"])){$this->strength = $array["strength"];}
        if(isset($array["stealth"])){$this->stealth = $array["stealth"];}
        if(isset($array["modifier"])){$this->modifier = $array["modifier"];}
        if(isset($array["roll"])){$this->roll = $array["roll"];}
        if(isset($array["dmg1"])){$this->dmg1 = $array["dmg1"];}
        if(isset($array["dmg2"])){$this->dmg2 = $array["dmg2"];}
        if(isset($array["dmgType"])){$this->dmgType = $array["dmgType"];}
        if(isset($array["property"])){$this->property = $array["property"];}
        if(isset($array["range"])){$this->range = $array["range"];}
        if(isset($array["wearable"])){$this->wearable = $array["wearable"];}
        if(isset($array["cursed"])){$this->cursed = $array["cursed"];}
        if(isset($array["stackable"])){$this->stackable = $array["stackable"];}
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`, `name`, `description`, `weight`, `priceCP`, `priceSP`, `priceEP`, `priceGP`, `pricePP`, `magic`, `type`, `rarity`, `ac`, `strength`, `stealth`, `modifier`, `roll`, `dmg1`, `dmg2`, `dmgType`, `property`, `range`, `wearable`, `cursed`, `stackable` )" . " VALUES " . " (NULL , :name, :description, :weight, :priceCP, :priceSP, :priceEP, :priceGP, :pricePP, :magic, :type, :rarity, :ac, :strength, :stealth, :modifier, :roll, :dmg1, :dmg2, :dmgType, :property, :range, :wearable, :cursed, :stackable );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":weight", $this->weight);
        $stmt->bindParam(":priceCP", $this->priceCP);
        $stmt->bindParam(":priceSP", $this->priceSP);
        $stmt->bindParam(":priceEP", $this->priceEP);
        $stmt->bindParam(":priceGP", $this->priceGP);
        $stmt->bindParam(":pricePP", $this->pricePP);
        $stmt->bindParam(":magic", $this->magic);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":rarity", $this->rarity);
        $stmt->bindParam(":ac", $this->ac);
        $stmt->bindParam(":strength", $this->strength);
        $stmt->bindParam(":stealth", $this->stealth);
        $stmt->bindParam(":modifier", $this->modifier);
        $stmt->bindParam(":roll", $this->roll);
        $stmt->bindParam(":dmg1", $this->dmg1);
        $stmt->bindParam(":dmg2", $this->dmg2);
        $stmt->bindParam(":dmgType", $this->dmgType);
        $stmt->bindParam(":property", $this->property);
        $stmt->bindParam(":range", $this->range);
        $stmt->bindParam(":wearable", $this->wearable);
        $stmt->bindParam(":cursed", $this->cursed);
        $stmt->bindParam(":stackable", $this->stackable);
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET `name` = :name, `description` = :description, `weight` = :weight, `priceCP` = :priceCP, `priceSP` = :priceSP, `priceEP` = :priceEP, `priceGP` = :priceGP, `pricePP` = :pricePP, `magic` = :magic, `type` = :type, `rarity` = :rarity, `ac` = :ac, `strength` = :strength, `stealth` = :stealth, `modifier` = :modifier, `roll` = :roll, `dmg1` = :dmg1, `dmg2` = :dmg2, `dmgType` = :dmgType, `property` = :property, `range` = :range, `wearable` = :wearable, `cursed` = :cursed, `stackable` = :stackable " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":weight", $this->weight);
        $stmt->bindParam(":priceCP", $this->priceCP);
        $stmt->bindParam(":priceSP", $this->priceSP);
        $stmt->bindParam(":priceEP", $this->priceEP);
        $stmt->bindParam(":priceGP", $this->priceGP);
        $stmt->bindParam(":pricePP", $this->pricePP);
        $stmt->bindParam(":magic", $this->magic);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":rarity", $this->rarity);
        $stmt->bindParam(":ac", $this->ac);
        $stmt->bindParam(":strength", $this->strength);
        $stmt->bindParam(":stealth", $this->stealth);
        $stmt->bindParam(":modifier", $this->modifier);
        $stmt->bindParam(":roll", $this->roll);
        $stmt->bindParam(":dmg1", $this->dmg1);
        $stmt->bindParam(":dmg2", $this->dmg2);
        $stmt->bindParam(":dmgType", $this->dmgType);
        $stmt->bindParam(":property", $this->property);
        $stmt->bindParam(":range", $this->range);
        $stmt->bindParam(":wearable", $this->wearable);
        $stmt->bindParam(":cursed", $this->cursed);
        $stmt->bindParam(":stackable", $this->stackable);
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
        "weight" => $this->weight, 
        "priceCP" => $this->priceCP, 
        "priceSP" => $this->priceSP, 
        "priceEP" => $this->priceEP, 
        "priceGP" => $this->priceGP, 
        "pricePP" => $this->pricePP, 
        "magic" => $this->magic, 
        "type" => $this->type, 
        "rarity" => $this->rarity, 
        "ac" => $this->ac, 
        "strength" => $this->strength, 
        "stealth" => $this->stealth, 
        "modifier" => $this->modifier, 
        "roll" => $this->roll, 
        "dmg1" => $this->dmg1, 
        "dmg2" => $this->dmg2, 
        "dmgType" => $this->dmgType, 
        "property" => $this->property, 
        "range" => $this->range, 
        "wearable" => $this->wearable, 
        "cursed" => $this->cursed, 
        "stackable" => $this->stackable, 
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
        $this->name =  $rec["name"];
        $this->description =  $rec["description"];
        $this->weight =  $rec["weight"];
        $this->priceCP =  $rec["priceCP"];
        $this->priceSP =  $rec["priceSP"];
        $this->priceEP =  $rec["priceEP"];
        $this->priceGP =  $rec["priceGP"];
        $this->pricePP =  $rec["pricePP"];
        $this->magic =  $rec["magic"];
        $this->type =  $rec["type"];
        $this->rarity =  $rec["rarity"];
        $this->ac =  $rec["ac"];
        $this->strength =  $rec["strength"];
        $this->stealth =  $rec["stealth"];
        $this->modifier =  $rec["modifier"];
        $this->roll =  $rec["roll"];
        $this->dmg1 =  $rec["dmg1"];
        $this->dmg2 =  $rec["dmg2"];
        $this->dmgType =  $rec["dmgType"];
        $this->property =  $rec["property"];
        $this->range =  $rec["range"];
        $this->wearable =  $rec["wearable"];
        $this->cursed =  $rec["cursed"];
        $this->stackable =  $rec["stackable"];
    }

}

?>