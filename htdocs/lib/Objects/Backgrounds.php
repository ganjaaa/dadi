<?php

namespace DND\Objects;


class Backgrounds implements \DND\Interfaces\Objects {

    const tableName = 'dnd_backgrounds';

    private $id;
    private $name;
    private $proficiency;
    private $proficiencyAcrobatics = 0;
    private $proficiencyAnimalHandling = 0;
    private $proficiencyArcana = 0;
    private $proficiencyAthletics = 0;
    private $proficiencyDeception = 0;
    private $proficiencyHistory = 0;
    private $proficiencyInsight = 0;
    private $proficiencyIntimidation = 0;
    private $proficiencyInvestigation = 0;
    private $proficiencyMedicine = 0;
    private $proficiencyNature = 0;
    private $proficiencyPerception = 0;
    private $proficiencyPerformance = 0;
    private $proficiencyPersuasion = 0;
    private $proficiencyReligion = 0;
    private $proficiencySleightOfHand = 0;
    private $proficiencyStealth = 0;
    private $proficiencySurvival = 0;

    public function __construct() {
    }

    public function getAjaxAll() {
        
                    $a = $this->getAjax();
                    $tmp = explode(';', $this->proficiency);
                    $a['proficiencyAcrobatics'] = (int) $tmp[ Character::IDX_SKILL_Acrobatics];
                    $a['proficiencyAnimalHandling'] = (int) $tmp[ Character::IDX_SKILL_AnimalHandling];
                    $a['proficiencyArcana'] = (int) $tmp[ Character::IDX_SKILL_Arcana];
                    $a['proficiencyAthletics'] = (int) $tmp[ Character::IDX_SKILL_Athletics];
                    $a['proficiencyDeception'] = (int) $tmp[ Character::IDX_SKILL_Deception];
                    $a['proficiencyHistory'] = (int) $tmp[ Character::IDX_SKILL_History];
                    $a['proficiencyInsight'] = (int) $tmp[ Character::IDX_SKILL_Insight];
                    $a['proficiencyIntimidation'] = (int) $tmp[ Character::IDX_SKILL_Intimidation];
                    $a['proficiencyInvestigation'] = (int) $tmp[ Character::IDX_SKILL_Investigation];
                    $a['proficiencyMedicine'] = (int) $tmp[ Character::IDX_SKILL_Medicine];
                    $a['proficiencyNature'] = (int) $tmp[ Character::IDX_SKILL_Nature];
                    $a['proficiencyPerception'] = (int) $tmp[ Character::IDX_SKILL_Perception];
                    $a['proficiencyPerformance'] = (int) $tmp[ Character::IDX_SKILL_Performance];
                    $a['proficiencyPersuasion'] = (int) $tmp[ Character::IDX_SKILL_Persuasion];
                    $a['proficiencyReligion'] = (int) $tmp[ Character::IDX_SKILL_Religion];
                    $a['proficiencySleightOfHand'] = (int) $tmp[ Character::IDX_SKILL_SleightOfHand];
                    $a['proficiencyStealth'] = (int) $tmp[ Character::IDX_SKILL_Stealth];
                    $a['proficiencySurvival'] = (int) $tmp[ Character::IDX_SKILL_Survival];
                    $a['cleanProficiency'] = [];
                    if($a['proficiencyAcrobatics'] == 1) $a['cleanProficiency'][] = 'Acrobatics'; 
                    if($a['proficiencyAnimalHandling'] == 1) $a['cleanProficiency'][] = 'AnimalHandling'; 
                    if($a['proficiencyArcana'] == 1) $a['cleanProficiency'][] = 'Arcana'; 
                    if($a['proficiencyAthletics'] == 1) $a['cleanProficiency'][] = 'Athletics'; 
                    if($a['proficiencyDeception'] == 1) $a['cleanProficiency'][] = 'Deception'; 
                    if($a['proficiencyHistory'] == 1) $a['cleanProficiency'][] = 'History'; 
                    if($a['proficiencyInsight'] == 1) $a['cleanProficiency'][] = 'Insight'; 
                    if($a['proficiencyIntimidation'] == 1) $a['cleanProficiency'][] = 'Intimidation'; 
                    if($a['proficiencyInvestigation'] == 1) $a['cleanProficiency'][] = 'Investigation'; 
                    if($a['proficiencyMedicine'] == 1) $a['cleanProficiency'][] = 'Medicine'; 
                    if($a['proficiencyNature'] == 1) $a['cleanProficiency'][] = 'Nature'; 
                    if($a['proficiencyPerception'] == 1) $a['cleanProficiency'][] = 'Perception'; 
                    if($a['proficiencyPerformance'] == 1) $a['cleanProficiency'][] = 'Performance'; 
                    if($a['proficiencyPersuasion'] == 1) $a['cleanProficiency'][] = 'Persuasion'; 
                    if($a['proficiencyReligion'] == 1) $a['cleanProficiency'][] = 'Religion'; 
                    if($a['proficiencySleightOfHand'] == 1) $a['cleanProficiency'][] = 'SleightOfHand'; 
                    if($a['proficiencyStealth'] == 1) $a['cleanProficiency'][] = 'Stealth'; 
                    if($a['proficiencySurvival'] == 1) $a['cleanProficiency'][] = 'Survival'; 
                    $a['cleanProficiency'] = implode('<br>',$a['cleanProficiency']);
                    return $a;

    }

    public function fillFromPostAll($a = NULL) {
        
                    $this->proficiency = (isset($a["acrobatics"]) ? $a["acrobatics"] : 0) . ';' . (isset($a["animalhandling"]) ? $a["animalhandling"] : 0) . ';' . (isset($a["arcana"]) ? $a["arcana"] : 0) . ';' . (isset($a["athletics"]) ? $a["athletics"] : 0) . ';' . (isset($a["deception"]) ? $a["deception"] : 0) . ';' . (isset($a["history"]) ? $a["history"] : 0) . ';' . (isset($a["insight"]) ? $a["insight"] : 0) . ';' . (isset($a["intimidation"]) ? $a["intimidation"] : 0) . ';' . (isset($a["investigation"]) ? $a["investigation"] : 0) . ';' . (isset($a["medicine"]) ? $a["medicine"] : 0) . ';' . (isset($a["nature"]) ? $a["nature"] : 0) . ';' . (isset($a["perception"]) ? $a["perception"] : 0) . ';' . (isset($a["performance"]) ? $a["performance"] : 0) . ';' . (isset($a["persuasion"]) ? $a["persuasion"] : 0) . ';' . (isset($a["religion"]) ? $a["religion"] : 0) . ';' . (isset($a["sleightofhand"]) ? $a["sleightofhand"] : 0) . ';' . (isset($a["stealth"]) ? $a["stealth"] : 0) . ';' . (isset($a["survival"]) ? $a["survival"] : 0);
                    $this->fillFromPost($a);

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

    public function getProficiency() {
        return $this->proficiency;
    }

    public function setProficiency($value) {
        $this->proficiency = $value;
        return $this;
    }

    public function getProficiencyacrobatics() {
        return $this->proficiencyAcrobatics;
    }

    public function setProficiencyacrobatics($value) {
        $this->proficiencyAcrobatics = $value;
        return $this;
    }

    public function getProficiencyanimalhandling() {
        return $this->proficiencyAnimalHandling;
    }

    public function setProficiencyanimalhandling($value) {
        $this->proficiencyAnimalHandling = $value;
        return $this;
    }

    public function getProficiencyarcana() {
        return $this->proficiencyArcana;
    }

    public function setProficiencyarcana($value) {
        $this->proficiencyArcana = $value;
        return $this;
    }

    public function getProficiencyathletics() {
        return $this->proficiencyAthletics;
    }

    public function setProficiencyathletics($value) {
        $this->proficiencyAthletics = $value;
        return $this;
    }

    public function getProficiencydeception() {
        return $this->proficiencyDeception;
    }

    public function setProficiencydeception($value) {
        $this->proficiencyDeception = $value;
        return $this;
    }

    public function getProficiencyhistory() {
        return $this->proficiencyHistory;
    }

    public function setProficiencyhistory($value) {
        $this->proficiencyHistory = $value;
        return $this;
    }

    public function getProficiencyinsight() {
        return $this->proficiencyInsight;
    }

    public function setProficiencyinsight($value) {
        $this->proficiencyInsight = $value;
        return $this;
    }

    public function getProficiencyintimidation() {
        return $this->proficiencyIntimidation;
    }

    public function setProficiencyintimidation($value) {
        $this->proficiencyIntimidation = $value;
        return $this;
    }

    public function getProficiencyinvestigation() {
        return $this->proficiencyInvestigation;
    }

    public function setProficiencyinvestigation($value) {
        $this->proficiencyInvestigation = $value;
        return $this;
    }

    public function getProficiencymedicine() {
        return $this->proficiencyMedicine;
    }

    public function setProficiencymedicine($value) {
        $this->proficiencyMedicine = $value;
        return $this;
    }

    public function getProficiencynature() {
        return $this->proficiencyNature;
    }

    public function setProficiencynature($value) {
        $this->proficiencyNature = $value;
        return $this;
    }

    public function getProficiencyperception() {
        return $this->proficiencyPerception;
    }

    public function setProficiencyperception($value) {
        $this->proficiencyPerception = $value;
        return $this;
    }

    public function getProficiencyperformance() {
        return $this->proficiencyPerformance;
    }

    public function setProficiencyperformance($value) {
        $this->proficiencyPerformance = $value;
        return $this;
    }

    public function getProficiencypersuasion() {
        return $this->proficiencyPersuasion;
    }

    public function setProficiencypersuasion($value) {
        $this->proficiencyPersuasion = $value;
        return $this;
    }

    public function getProficiencyreligion() {
        return $this->proficiencyReligion;
    }

    public function setProficiencyreligion($value) {
        $this->proficiencyReligion = $value;
        return $this;
    }

    public function getProficiencysleightofhand() {
        return $this->proficiencySleightOfHand;
    }

    public function setProficiencysleightofhand($value) {
        $this->proficiencySleightOfHand = $value;
        return $this;
    }

    public function getProficiencystealth() {
        return $this->proficiencyStealth;
    }

    public function setProficiencystealth($value) {
        $this->proficiencyStealth = $value;
        return $this;
    }

    public function getProficiencysurvival() {
        return $this->proficiencySurvival;
    }

    public function setProficiencysurvival($value) {
        $this->proficiencySurvival = $value;
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
        if(isset($array["proficiency"])){$this->proficiency = $array["proficiency"];}
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`, `name`, `proficiency` )" . " VALUES " . " (NULL , :name, :proficiency );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":proficiency", $this->proficiency);
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET `name` = :name, `proficiency` = :proficiency " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":proficiency", $this->proficiency);
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
        "proficiency" => $this->proficiency, 
        "proficiencyAcrobatics" => $this->proficiencyAcrobatics, 
        "proficiencyAnimalHandling" => $this->proficiencyAnimalHandling, 
        "proficiencyArcana" => $this->proficiencyArcana, 
        "proficiencyAthletics" => $this->proficiencyAthletics, 
        "proficiencyDeception" => $this->proficiencyDeception, 
        "proficiencyHistory" => $this->proficiencyHistory, 
        "proficiencyInsight" => $this->proficiencyInsight, 
        "proficiencyIntimidation" => $this->proficiencyIntimidation, 
        "proficiencyInvestigation" => $this->proficiencyInvestigation, 
        "proficiencyMedicine" => $this->proficiencyMedicine, 
        "proficiencyNature" => $this->proficiencyNature, 
        "proficiencyPerception" => $this->proficiencyPerception, 
        "proficiencyPerformance" => $this->proficiencyPerformance, 
        "proficiencyPersuasion" => $this->proficiencyPersuasion, 
        "proficiencyReligion" => $this->proficiencyReligion, 
        "proficiencySleightOfHand" => $this->proficiencySleightOfHand, 
        "proficiencyStealth" => $this->proficiencyStealth, 
        "proficiencySurvival" => $this->proficiencySurvival, 
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
        $this->name =  $rec["name"];
        $this->proficiency =  $rec["proficiency"];
    }

}

?>