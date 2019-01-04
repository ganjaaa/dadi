<?php

namespace DND\Objects;


class DNDConstantes implements \DND\Interfaces\Objects {

    const tableName = 'dndconstantes';
    const VERSION_NUMBER = "0.2.14";
    const VERSION_TYPE = "alpha";
    const VERSION_CODENAME = "OM_DADI";
    const KIND_FEATURE = 0;
    const KIND_TRAIT = 1;
    const KIND_SLOT = 2;
    const IDX_KNOWLEDGE_UNKNOWN = 0;
    const IDX_KNOWLEDGE_KNOWN = 1;
    const IDX_KNOWLEDGE_BETTER_KNOWN = 2;
    const IDX_KNOWLEDGE_MASTERED = 3;
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
    const IDX_EQUIPT_UNWEARABLE = 0;
    const IDX_EQUIPT_WEARABLE = 1;
    const IDX_EQUIPT_UNCURSED = 0;
    const IDX_EQUIPT_CURSED = 1;
    const IDX_EQUIPT_UNSTACKABLE = 0;
    const IDX_EQUIPT_STACKABLE = 1;
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
    const IDX_SPELL_USED = 1;
    const IDX_SPELL_UNUSED = 0;
    const IDX_MONEY_CP = 0;
    const IDX_MONEY_SP = 1;
    const IDX_MONEY_EP = 2;
    const IDX_MONEY_GP = 3;
    const IDX_MONEY_PP = 4;
    const IDX_ST_STR = 0;
    const IDX_ST_DEX = 1;
    const IDX_ST_CON = 2;
    const IDX_ST_INT = 3;
    const IDX_ST_WIS = 4;
    const IDX_ST_CHA = 5;
    const IDX_SKILL_Acrobatics = 0;
    const IDX_SKILL_AnimalHandling = 1;
    const IDX_SKILL_Arcana = 2;
    const IDX_SKILL_Athletics = 3;
    const IDX_SKILL_Deception = 4;
    const IDX_SKILL_History = 5;
    const IDX_SKILL_Insight = 6;
    const IDX_SKILL_Intimidation = 7;
    const IDX_SKILL_Investigation = 8;
    const IDX_SKILL_Medicine = 9;
    const IDX_SKILL_Nature = 10;
    const IDX_SKILL_Perception = 11;
    const IDX_SKILL_Performance = 12;
    const IDX_SKILL_Persuasion = 13;
    const IDX_SKILL_Religion = 14;
    const IDX_SKILL_SleightOfHand = 15;
    const IDX_SKILL_Stealth = 16;
    const IDX_SKILL_Survival = 17;
    const IDX_HP_MAX = 0;
    const IDX_HP_CURRENT = 1;
    const IDX_HP_TEMP = 2;
    const IDX_DEATH_SUCCESS = 0;
    const IDX_DEATH_FAIL = 1;

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
        if(isset($array["id"]) && !empty($array["id"])){$this->id = $array["id"];}
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