<?php

namespace DND\Objects;


class Classes implements \DND\Interfaces\Objects {

    const tableName = 'dnd_classes';

    private $id;
    private $name;
    private $hd;
    private $proficiency;
    private $spellAbility;
    private $proficiencyStrength = 0;
    private $proficiencyDexterity = 0;
    private $proficiencyConstitution = 0;
    private $proficiencyIntelligence = 0;
    private $proficiencyWisdom = 0;
    private $proficiencyCharisma = 0;

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

    public function getProficiencystrength() {
        return $this->proficiencyStrength;
    }

    public function setProficiencystrength($value) {
        $this->proficiencyStrength = $value;
        return $this;
    }

    public function getProficiencydexterity() {
        return $this->proficiencyDexterity;
    }

    public function setProficiencydexterity($value) {
        $this->proficiencyDexterity = $value;
        return $this;
    }

    public function getProficiencyconstitution() {
        return $this->proficiencyConstitution;
    }

    public function setProficiencyconstitution($value) {
        $this->proficiencyConstitution = $value;
        return $this;
    }

    public function getProficiencyintelligence() {
        return $this->proficiencyIntelligence;
    }

    public function setProficiencyintelligence($value) {
        $this->proficiencyIntelligence = $value;
        return $this;
    }

    public function getProficiencywisdom() {
        return $this->proficiencyWisdom;
    }

    public function setProficiencywisdom($value) {
        $this->proficiencyWisdom = $value;
        return $this;
    }

    public function getProficiencycharisma() {
        return $this->proficiencyCharisma;
    }

    public function setProficiencycharisma($value) {
        $this->proficiencyCharisma = $value;
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
        "proficiencyStrength" => $this->proficiencyStrength, 
        "proficiencyDexterity" => $this->proficiencyDexterity, 
        "proficiencyConstitution" => $this->proficiencyConstitution, 
        "proficiencyIntelligence" => $this->proficiencyIntelligence, 
        "proficiencyWisdom" => $this->proficiencyWisdom, 
        "proficiencyCharisma" => $this->proficiencyCharisma, 
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