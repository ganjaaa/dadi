<?php

namespace DND\Core;

use \DND\Objects\DNDConstantes;
use DND\Core\Rules;
use DND\Objects\Item;

class CharsheetHelper {

    public static function combineModefier() {
        $m = [];
        foreach (func_get_args() as $param) {

            if (!empty($param)) {
                if (is_array($param)) {
                    $param = implode(';', $param);
                }

                $param = str_replace(',', ';', $param);
                foreach (explode(';', $param) as $v) {
                    $v = trim($v);
                    if (!empty($v)) {
                        $m[] = $v;
                    }
                }
            }
        }
        return implode(';', $m);
    }

    public static function parseCheetData($cheetArray, $inventory = array(), $spells = array(), $modifier = '') {
        $result = self::getDemoResult();
        $result['Debug']['Modifier'] = $modifier;

        if (!isset($cheetArray['speed']) || empty($cheetArray['speed']))
            $cheetArray['speed'] = 30;


        // Allgemeiner Foo
        $result['Charsheet']['charname'] = $cheetArray['charname'];
        $result['Charsheet']['race'] = $cheetArray['races_name'];
        $result['Charsheet']['class'] = $cheetArray['classes1_name'];
        $result['Charsheet']['background'] = $cheetArray['backgrounds_name'];
        $result['Charsheet']['alignment'] = Rules::getAligment($cheetArray['alignment']);
        // HP
        $hp = explode(';', $cheetArray['hp']);
        $result['Charsheet']['hp']['max'] = (isset($hp[DNDConstantes::IDX_HP_MAX]) ? $hp[DNDConstantes::IDX_HP_MAX] : 0) + Rules::extractAbility($modifier, 'maxhp', $hp[DNDConstantes::IDX_HP_MAX]);
        $result['Charsheet']['hp']['now'] = isset($hp[DNDConstantes::IDX_HP_CURRENT]) ? $hp[DNDConstantes::IDX_HP_CURRENT] : 0;
        $result['Charsheet']['hp']['tmp'] = isset($hp[DNDConstantes::IDX_HP_TEMP]) ? $hp[DNDConstantes::IDX_HP_TEMP] : 0;
        //
        $saves = explode(';', $cheetArray['death']);
        $result['Charsheet']['deathSaves']['success'] = isset($saves[DNDConstantes::IDX_DEATH_SUCCESS]) ? $saves[DNDConstantes::IDX_DEATH_SUCCESS] : 0;
        $result['Charsheet']['deathSaves']['failture'] = isset($saves[DNDConstantes::IDX_DEATH_FAIL]) ? $saves[DNDConstantes::IDX_DEATH_FAIL] : 0;
        // Level und Erfahrung
        $result['Charsheet']['level']['level'] = $cheetArray['class1Level'] + $cheetArray['class2Level'] + $cheetArray['class3Level'] + $cheetArray['class4Level'];
        $result['Charsheet']['level']['exp'] = $cheetArray['exp'];
        $result['Charsheet']['level']['expCap'] = Rules::getLevelCap(1);
        $result['Charsheet']['level']['levelup'] = Rules::gotLevelup($result['Charsheet']['level']['level'], $cheetArray['exp']);
        // Geld
        $money = explode(';', $cheetArray['money']);
        $result['Charsheet']['money']['copper'] = isset($money[DNDConstantes::IDX_MONEY_CP]) ? $money[DNDConstantes::IDX_MONEY_CP] : 0;
        $result['Charsheet']['money']['silver'] = isset($money[DNDConstantes::IDX_MONEY_SP]) ? $money[DNDConstantes::IDX_MONEY_SP] : 0;
        $result['Charsheet']['money']['electrum'] = isset($money[DNDConstantes::IDX_MONEY_EP]) ? $money[DNDConstantes::IDX_MONEY_EP] : 0;
        $result['Charsheet']['money']['gold'] = isset($money[DNDConstantes::IDX_MONEY_GP]) ? $money[DNDConstantes::IDX_MONEY_GP] : 0;
        $result['Charsheet']['money']['platinum'] = isset($money[DNDConstantes::IDX_MONEY_PP]) ? $money[DNDConstantes::IDX_MONEY_PP] : 0;
        // Werte wie gewürfelt
        $throws = explode(';', $cheetArray['savingThrows']);
        $result['Charsheet']['savingThrows']['strength']['_value'] = isset($throws[DNDConstantes::IDX_ST_STR]) ? $throws[DNDConstantes::IDX_ST_STR] : 0;
        $result['Charsheet']['savingThrows']['dexterity']['_value'] = isset($throws[DNDConstantes::IDX_ST_DEX]) ? $throws[DNDConstantes::IDX_ST_DEX] : 0;
        $result['Charsheet']['savingThrows']['constitution']['_value'] = isset($throws[DNDConstantes::IDX_ST_CON]) ? $throws[DNDConstantes::IDX_ST_CON] : 0;
        $result['Charsheet']['savingThrows']['intelligence']['_value'] = isset($throws[DNDConstantes::IDX_ST_INT]) ? $throws[DNDConstantes::IDX_ST_INT] : 0;
        $result['Charsheet']['savingThrows']['wisdom']['_value'] = isset($throws[DNDConstantes::IDX_ST_WIS]) ? $throws[DNDConstantes::IDX_ST_WIS] : 0;
        $result['Charsheet']['savingThrows']['charisma']['_value'] = isset($throws[DNDConstantes::IDX_ST_CHA]) ? $throws[DNDConstantes::IDX_ST_CHA] : 0;
        // Werte wie gewürfelt + Manipulator
        $result['Charsheet']['savingThrows']['strength']['_valueBonus'] = Rules::extractAbility($modifier, DNDConstantes::IDX_STR, $result['Charsheet']['savingThrows']['strength']['_value']);
        $result['Charsheet']['savingThrows']['dexterity']['_valueBonus'] = Rules::extractAbility($modifier, DNDConstantes::IDX_DEX, $result['Charsheet']['savingThrows']['dexterity']['_value']);
        $result['Charsheet']['savingThrows']['constitution']['_valueBonus'] = Rules::extractAbility($modifier, DNDConstantes::IDX_CON, $result['Charsheet']['savingThrows']['constitution']['_value']);
        $result['Charsheet']['savingThrows']['intelligence']['_valueBonus'] = Rules::extractAbility($modifier, DNDConstantes::IDX_INT, $result['Charsheet']['savingThrows']['intelligence']['_value']);
        $result['Charsheet']['savingThrows']['wisdom']['_valueBonus'] = Rules::extractAbility($modifier, DNDConstantes::IDX_WIS, $result['Charsheet']['savingThrows']['wisdom']['_value']);
        $result['Charsheet']['savingThrows']['charisma']['_valueBonus'] = Rules::extractAbility($modifier, DNDConstantes::IDX_CHA, $result['Charsheet']['savingThrows']['charisma']['_value']);
        // Modifier
        $result['Charsheet']['savingThrows']['strength']['_mod'] = Rules::getModifier($result['Charsheet']['savingThrows']['strength']['_value'] + $result['Charsheet']['savingThrows']['strength']['_valueBonus']);
        $result['Charsheet']['savingThrows']['dexterity']['_mod'] = Rules::getModifier($result['Charsheet']['savingThrows']['dexterity']['_value'] + $result['Charsheet']['savingThrows']['dexterity']['_valueBonus']);
        $result['Charsheet']['savingThrows']['constitution']['_mod'] = Rules::getModifier($result['Charsheet']['savingThrows']['constitution']['_value'] + $result['Charsheet']['savingThrows']['constitution']['_valueBonus']);
        $result['Charsheet']['savingThrows']['intelligence']['_mod'] = Rules::getModifier($result['Charsheet']['savingThrows']['intelligence']['_value'] + $result['Charsheet']['savingThrows']['intelligence']['_valueBonus']);
        $result['Charsheet']['savingThrows']['wisdom']['_mod'] = Rules::getModifier($result['Charsheet']['savingThrows']['wisdom']['_value'] + $result['Charsheet']['savingThrows']['wisdom']['_valueBonus']);
        $result['Charsheet']['savingThrows']['charisma']['_mod'] = Rules::getModifier($result['Charsheet']['savingThrows']['charisma']['_value'] + $result['Charsheet']['savingThrows']['charisma']['_valueBonus']);
        // Modifier + Bonus
        $result['Charsheet']['savingThrows']['strength']['_modBonus'] = Rules::extractAbility($modifier, 'm' . DNDConstantes::IDX_STR, $result['Charsheet']['savingThrows']['strength']['_mod']);
        $result['Charsheet']['savingThrows']['dexterity']['_modBonus'] = Rules::extractAbility($modifier, 'm' . DNDConstantes::IDX_DEX, $result['Charsheet']['savingThrows']['dexterity']['_mod']);
        $result['Charsheet']['savingThrows']['constitution']['_modBonus'] = Rules::extractAbility($modifier, 'm' . DNDConstantes::IDX_CON, $result['Charsheet']['savingThrows']['constitution']['_mod']);
        $result['Charsheet']['savingThrows']['intelligence']['_modBonus'] = Rules::extractAbility($modifier, 'm' . DNDConstantes::IDX_INT, $result['Charsheet']['savingThrows']['intelligence']['_mod']);
        $result['Charsheet']['savingThrows']['wisdom']['_modBonus'] = Rules::extractAbility($modifier, 'm' . DNDConstantes::IDX_WIS, $result['Charsheet']['savingThrows']['wisdom']['_mod']);
        $result['Charsheet']['savingThrows']['charisma']['_modBonus'] = Rules::extractAbility($modifier, 'm' . DNDConstantes::IDX_CHA, $result['Charsheet']['savingThrows']['charisma']['_mod']);
        // Proficiency
        $prof1 = explode(';', $cheetArray['classes1_proficiency']);
        $result['Charsheet']['savingThrows']['strength']['proficiency'] = isset($prof1[DNDConstantes::IDX_ST_STR]) ? $prof1[DNDConstantes::IDX_ST_STR] : 0;
        $result['Charsheet']['savingThrows']['dexterity']['proficiency'] = isset($prof1[DNDConstantes::IDX_ST_DEX]) ? $prof1[DNDConstantes::IDX_ST_DEX] : 0;
        $result['Charsheet']['savingThrows']['constitution']['proficiency'] = isset($prof1[DNDConstantes::IDX_ST_CON]) ? $prof1[DNDConstantes::IDX_ST_CON] : 0;
        $result['Charsheet']['savingThrows']['intelligence']['proficiency'] = isset($prof1[DNDConstantes::IDX_ST_INT]) ? $prof1[DNDConstantes::IDX_ST_INT] : 0;
        $result['Charsheet']['savingThrows']['wisdom']['proficiency'] = isset($prof1[DNDConstantes::IDX_ST_WIS]) ? $prof1[DNDConstantes::IDX_ST_WIS] : 0;
        $result['Charsheet']['savingThrows']['charisma']['proficiency'] = isset($prof1[DNDConstantes::IDX_ST_CHA]) ? $prof1[DNDConstantes::IDX_ST_CHA] : 0;
        // Skills
        $result['Charsheet']['skills']['acrobatics']['_value'] = $result['Charsheet']['savingThrows']['dexterity']['_mod'] + $result['Charsheet']['savingThrows']['dexterity']['_modBonus'];
        $result['Charsheet']['skills']['animalHandling']['_value'] = $result['Charsheet']['savingThrows']['wisdom']['_mod'] + $result['Charsheet']['savingThrows']['wisdom']['_modBonus'];
        $result['Charsheet']['skills']['arcana']['_value'] = $result['Charsheet']['savingThrows']['intelligence']['_mod'] + $result['Charsheet']['savingThrows']['intelligence']['_modBonus'];
        $result['Charsheet']['skills']['athletics']['_value'] = $result['Charsheet']['savingThrows']['strength']['_mod'] + $result['Charsheet']['savingThrows']['strength']['_modBonus'];
        $result['Charsheet']['skills']['deception']['_value'] = $result['Charsheet']['savingThrows']['charisma']['_mod'] + $result['Charsheet']['savingThrows']['charisma']['_modBonus'];
        $result['Charsheet']['skills']['history']['_value'] = $result['Charsheet']['savingThrows']['intelligence']['_mod'] + $result['Charsheet']['savingThrows']['intelligence']['_modBonus'];
        $result['Charsheet']['skills']['insight']['_value'] = $result['Charsheet']['savingThrows']['wisdom']['_mod'] + $result['Charsheet']['savingThrows']['wisdom']['_modBonus'];
        $result['Charsheet']['skills']['intimidation']['_value'] = $result['Charsheet']['savingThrows']['charisma']['_mod'] + $result['Charsheet']['savingThrows']['charisma']['_modBonus'];
        $result['Charsheet']['skills']['investigation']['_value'] = $result['Charsheet']['savingThrows']['intelligence']['_mod'] + $result['Charsheet']['savingThrows']['intelligence']['_modBonus'];
        $result['Charsheet']['skills']['medicine']['_value'] = $result['Charsheet']['savingThrows']['wisdom']['_mod'] + $result['Charsheet']['savingThrows']['wisdom']['_modBonus'];
        $result['Charsheet']['skills']['nature']['_value'] = $result['Charsheet']['savingThrows']['intelligence']['_mod'] + $result['Charsheet']['savingThrows']['intelligence']['_modBonus'];
        $result['Charsheet']['skills']['perception']['_value'] = $result['Charsheet']['savingThrows']['wisdom']['_mod'] + $result['Charsheet']['savingThrows']['wisdom']['_modBonus'];
        $result['Charsheet']['skills']['performance']['_value'] = $result['Charsheet']['savingThrows']['charisma']['_mod'] + $result['Charsheet']['savingThrows']['charisma']['_modBonus'];
        $result['Charsheet']['skills']['persuasion']['_value'] = $result['Charsheet']['savingThrows']['charisma']['_mod'] + $result['Charsheet']['savingThrows']['charisma']['_modBonus'];
        $result['Charsheet']['skills']['religion']['_value'] = $result['Charsheet']['savingThrows']['intelligence']['_mod'] + $result['Charsheet']['savingThrows']['intelligence']['_modBonus'];
        $result['Charsheet']['skills']['sleightOfHand']['_value'] = $result['Charsheet']['savingThrows']['dexterity']['_mod'] + $result['Charsheet']['savingThrows']['dexterity']['_modBonus'];
        $result['Charsheet']['skills']['stealth']['_value'] = $result['Charsheet']['savingThrows']['dexterity']['_mod'] + $result['Charsheet']['savingThrows']['dexterity']['_modBonus'];
        $result['Charsheet']['skills']['survival']['_value'] = $result['Charsheet']['savingThrows']['wisdom']['_mod'] + $result['Charsheet']['savingThrows']['wisdom']['_modBonus'];
        // Skills Boni
        $result['Charsheet']['skills']['acrobatics']['_valueBonus'] = Rules::extractAbility($modifier, 'acro', $result['Charsheet']['skills']['acrobatics']['_value']);
        $result['Charsheet']['skills']['animalHandling']['_valueBonus'] = Rules::extractAbility($modifier, 'anim', $result['Charsheet']['skills']['animalHandling']['_value']);
        $result['Charsheet']['skills']['arcana']['_valueBonus'] = Rules::extractAbility($modifier, 'arca', $result['Charsheet']['skills']['arcana']['_value']);
        $result['Charsheet']['skills']['athletics']['_valueBonus'] = Rules::extractAbility($modifier, 'athl', $result['Charsheet']['skills']['athletics']['_value']);
        $result['Charsheet']['skills']['deception']['_valueBonus'] = Rules::extractAbility($modifier, 'dece', $result['Charsheet']['skills']['deception']['_value']);
        $result['Charsheet']['skills']['history']['_valueBonus'] = Rules::extractAbility($modifier, 'hist', $result['Charsheet']['skills']['history']['_value']);
        $result['Charsheet']['skills']['insight']['_valueBonus'] = Rules::extractAbility($modifier, 'insi', $result['Charsheet']['skills']['insight']['_value']);
        $result['Charsheet']['skills']['intimidation']['_valueBonus'] = Rules::extractAbility($modifier, 'inti', $result['Charsheet']['skills']['intimidation']['_value']);
        $result['Charsheet']['skills']['investigation']['_valueBonus'] = Rules::extractAbility($modifier, 'inve', $result['Charsheet']['skills']['investigation']['_value']);
        $result['Charsheet']['skills']['medicine']['_valueBonus'] = Rules::extractAbility($modifier, 'medi', $result['Charsheet']['skills']['medicine']['_value']);
        $result['Charsheet']['skills']['nature']['_valueBonus'] = Rules::extractAbility($modifier, 'natu', $result['Charsheet']['skills']['nature']['_value']);
        $result['Charsheet']['skills']['perception']['_valueBonus'] = Rules::extractAbility($modifier, 'perc', $result['Charsheet']['skills']['perception']['_value']);
        $result['Charsheet']['skills']['performance']['_valueBonus'] = Rules::extractAbility($modifier, 'perf', $result['Charsheet']['skills']['performance']['_value']);
        $result['Charsheet']['skills']['persuasion']['_valueBonus'] = Rules::extractAbility($modifier, 'pers', $result['Charsheet']['skills']['persuasion']['_value']);
        $result['Charsheet']['skills']['religion']['_valueBonus'] = Rules::extractAbility($modifier, 'perf', $result['Charsheet']['skills']['religion']['_value']);
        $result['Charsheet']['skills']['sleightOfHand']['_valueBonus'] = Rules::extractAbility($modifier, 'slei', $result['Charsheet']['skills']['sleightOfHand']['_value']);
        $result['Charsheet']['skills']['stealth']['_valueBonus'] = Rules::extractAbility($modifier, 'stea', $result['Charsheet']['skills']['stealth']['_value']);
        $result['Charsheet']['skills']['survival']['_valueBonus'] = Rules::extractAbility($modifier, 'surv', $result['Charsheet']['skills']['survival']['_value']);
        // Skills proficiency
        $prof_a = self::orExplodeStrings($cheetArray['proficiency'], $cheetArray['races_proficiency']);
        $prof_b = self::orExplodeStrings($prof_a, $cheetArray['backgrounds_proficiency']);
        $prof = explode(';', $prof_b);
        $result['Charsheet']['skills']['acrobatics']['proficiency'] = isset($prof[DNDConstantes::IDX_SKILL_Acrobatics]) ? $prof[DNDConstantes::IDX_SKILL_Acrobatics] : 0;
        $result['Charsheet']['skills']['animalHandling']['proficiency'] = isset($prof[DNDConstantes::IDX_SKILL_AnimalHandling]) ? $prof[DNDConstantes::IDX_SKILL_AnimalHandling] : 0;
        $result['Charsheet']['skills']['arcana']['proficiency'] = isset($prof[DNDConstantes::IDX_SKILL_Arcana]) ? $prof[DNDConstantes::IDX_SKILL_Arcana] : 0;
        $result['Charsheet']['skills']['athletics']['proficiency'] = isset($prof[DNDConstantes::IDX_SKILL_Athletics]) ? $prof[DNDConstantes::IDX_SKILL_Athletics] : 0;
        $result['Charsheet']['skills']['deception']['proficiency'] = isset($prof[DNDConstantes::IDX_SKILL_Deception]) ? $prof[DNDConstantes::IDX_SKILL_Deception] : 0;
        $result['Charsheet']['skills']['history']['proficiency'] = isset($prof[DNDConstantes::IDX_SKILL_History]) ? $prof[DNDConstantes::IDX_SKILL_History] : 0;
        $result['Charsheet']['skills']['insight']['proficiency'] = isset($prof[DNDConstantes::IDX_SKILL_Insight]) ? $prof[DNDConstantes::IDX_SKILL_Insight] : 0;
        $result['Charsheet']['skills']['intimidation']['proficiency'] = isset($prof[DNDConstantes::IDX_SKILL_Intimidation]) ? $prof[DNDConstantes::IDX_SKILL_Intimidation] : 0;
        $result['Charsheet']['skills']['investigation']['proficiency'] = isset($prof[DNDConstantes::IDX_SKILL_Investigation]) ? $prof[DNDConstantes::IDX_SKILL_Investigation] : 0;
        $result['Charsheet']['skills']['medicine']['proficiency'] = isset($prof[DNDConstantes::IDX_SKILL_Medicine]) ? $prof[DNDConstantes::IDX_SKILL_Medicine] : 0;
        $result['Charsheet']['skills']['nature']['proficiency'] = isset($prof[DNDConstantes::IDX_SKILL_Nature]) ? $prof[DNDConstantes::IDX_SKILL_Nature] : 0;
        $result['Charsheet']['skills']['perception']['proficiency'] = isset($prof[DNDConstantes::IDX_SKILL_Perception]) ? $prof[DNDConstantes::IDX_SKILL_Perception] : 0;
        $result['Charsheet']['skills']['performance']['proficiency'] = isset($prof[DNDConstantes::IDX_SKILL_Performance]) ? $prof[DNDConstantes::IDX_SKILL_Performance] : 0;
        $result['Charsheet']['skills']['persuasion']['proficiency'] = isset($prof[DNDConstantes::IDX_SKILL_Persuasion]) ? $prof[DNDConstantes::IDX_SKILL_Persuasion] : 0;
        $result['Charsheet']['skills']['religion']['proficiency'] = isset($prof[DNDConstantes::IDX_SKILL_Religion]) ? $prof[DNDConstantes::IDX_SKILL_Religion] : 0;
        $result['Charsheet']['skills']['sleightOfHand']['proficiency'] = isset($prof[DNDConstantes::IDX_SKILL_SleightOfHand]) ? $prof[DNDConstantes::IDX_SKILL_SleightOfHand] : 0;
        $result['Charsheet']['skills']['stealth']['proficiency'] = isset($prof[DNDConstantes::IDX_SKILL_Stealth]) ? $prof[DNDConstantes::IDX_SKILL_Stealth] : 0;
        $result['Charsheet']['skills']['survival']['proficiency'] = isset($prof[DNDConstantes::IDX_SKILL_Survival]) ? $prof[DNDConstantes::IDX_SKILL_Survival] : 0;
        // Paar andere Werte
        $result['Charsheet']['proficiency'] = Rules::getProficiency($result['Charsheet']['level']['level']) + Rules::extractAbility($modifier, 'prof');
        $result['Charsheet']['inspiration'] = $cheetArray['inspiration'] + Rules::extractAbility($modifier, 'insp', $cheetArray['inspiration']);
        $result['Charsheet']['initiative'] = $cheetArray['initiative'] + Rules::extractAbility($modifier, 'init', $cheetArray['initiative']);
        $result['Charsheet']['speed'] = $cheetArray['speed'] + Rules::extractAbility($modifier, 'speed', $cheetArray['speed']);
        $result['Charsheet']['ac'] = $cheetArray['ac'] + Rules::extractAbility($modifier, 'ac', $cheetArray['ac']);
        // Anzeige Werte
        $result['Charsheet']['savingThrows']['strength']['value'] = $result['Charsheet']['savingThrows']['strength']['_value'] + $result['Charsheet']['savingThrows']['strength']['_valueBonus'];
        $result['Charsheet']['savingThrows']['dexterity']['value'] = $result['Charsheet']['savingThrows']['dexterity']['_value'] + $result['Charsheet']['savingThrows']['dexterity']['_valueBonus'];
        $result['Charsheet']['savingThrows']['constitution']['value'] = $result['Charsheet']['savingThrows']['constitution']['_value'] + $result['Charsheet']['savingThrows']['constitution']['_valueBonus'];
        $result['Charsheet']['savingThrows']['intelligence']['value'] = $result['Charsheet']['savingThrows']['intelligence']['_value'] + $result['Charsheet']['savingThrows']['intelligence']['_valueBonus'];
        $result['Charsheet']['savingThrows']['wisdom']['value'] = $result['Charsheet']['savingThrows']['wisdom']['_value'] + $result['Charsheet']['savingThrows']['wisdom']['_valueBonus'];
        $result['Charsheet']['savingThrows']['charisma']['value'] = $result['Charsheet']['savingThrows']['charisma']['_value'] + $result['Charsheet']['savingThrows']['charisma']['_valueBonus'];

        $result['Charsheet']['savingThrows']['strength']['modifier'] = $result['Charsheet']['savingThrows']['strength']['_mod'] + $result['Charsheet']['savingThrows']['strength']['_modBonus'] + ($result['Charsheet']['savingThrows']['strength']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['savingThrows']['dexterity']['modifier'] = $result['Charsheet']['savingThrows']['dexterity']['_mod'] + $result['Charsheet']['savingThrows']['dexterity']['_modBonus'] + ($result['Charsheet']['savingThrows']['dexterity']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['savingThrows']['constitution']['modifier'] = $result['Charsheet']['savingThrows']['constitution']['_mod'] + $result['Charsheet']['savingThrows']['constitution']['_modBonus'] + ($result['Charsheet']['savingThrows']['constitution']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['savingThrows']['intelligence']['modifier'] = $result['Charsheet']['savingThrows']['intelligence']['_mod'] + $result['Charsheet']['savingThrows']['intelligence']['_modBonus'] + ($result['Charsheet']['savingThrows']['intelligence']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['savingThrows']['wisdom']['modifier'] = $result['Charsheet']['savingThrows']['wisdom']['_mod'] + $result['Charsheet']['savingThrows']['wisdom']['_modBonus'] + ($result['Charsheet']['savingThrows']['wisdom']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['savingThrows']['charisma']['modifier'] = $result['Charsheet']['savingThrows']['charisma']['_mod'] + $result['Charsheet']['savingThrows']['charisma']['_modBonus'] + ($result['Charsheet']['savingThrows']['charisma']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );

        $result['Charsheet']['savingThrows']['strength']['modifier_raw'] = $result['Charsheet']['savingThrows']['strength']['_mod'] + $result['Charsheet']['savingThrows']['strength']['_modBonus'];
        $result['Charsheet']['savingThrows']['dexterity']['modifier_raw'] = $result['Charsheet']['savingThrows']['dexterity']['_mod'] + $result['Charsheet']['savingThrows']['dexterity']['_modBonus'];
        $result['Charsheet']['savingThrows']['constitution']['modifier_raw'] = $result['Charsheet']['savingThrows']['constitution']['_mod'] + $result['Charsheet']['savingThrows']['constitution']['_modBonus'];
        $result['Charsheet']['savingThrows']['intelligence']['modifier_raw'] = $result['Charsheet']['savingThrows']['intelligence']['_mod'] + $result['Charsheet']['savingThrows']['intelligence']['_modBonus'];
        $result['Charsheet']['savingThrows']['wisdom']['modifier_raw'] = $result['Charsheet']['savingThrows']['wisdom']['_mod'] + $result['Charsheet']['savingThrows']['wisdom']['_modBonus'];
        $result['Charsheet']['savingThrows']['charisma']['modifier_raw'] = $result['Charsheet']['savingThrows']['charisma']['_mod'] + $result['Charsheet']['savingThrows']['charisma']['_modBonus'];

        $result['Charsheet']['skills']['acrobatics']['value'] = $result['Charsheet']['skills']['acrobatics']['_value'] + $result['Charsheet']['skills']['acrobatics']['_valueBonus'] + ($result['Charsheet']['skills']['acrobatics']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['skills']['animalHandling']['value'] = $result['Charsheet']['skills']['animalHandling']['_value'] + $result['Charsheet']['skills']['animalHandling']['_valueBonus'] + ($result['Charsheet']['skills']['animalHandling']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['skills']['arcana']['value'] = $result['Charsheet']['skills']['arcana']['_value'] + $result['Charsheet']['skills']['arcana']['_valueBonus'] + ($result['Charsheet']['skills']['arcana']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['skills']['athletics']['value'] = $result['Charsheet']['skills']['athletics']['_value'] + $result['Charsheet']['skills']['athletics']['_valueBonus'] + ($result['Charsheet']['skills']['athletics']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['skills']['deception']['value'] = $result['Charsheet']['skills']['deception']['_value'] + $result['Charsheet']['skills']['deception']['_valueBonus'] + ($result['Charsheet']['skills']['deception']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['skills']['history']['value'] = $result['Charsheet']['skills']['history']['_value'] + $result['Charsheet']['skills']['history']['_valueBonus'] + ($result['Charsheet']['skills']['history']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['skills']['insight']['value'] = $result['Charsheet']['skills']['insight']['_value'] + $result['Charsheet']['skills']['insight']['_valueBonus'] + ($result['Charsheet']['skills']['insight']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['skills']['intimidation']['value'] = $result['Charsheet']['skills']['intimidation']['_value'] + $result['Charsheet']['skills']['intimidation']['_valueBonus'] + ($result['Charsheet']['skills']['intimidation']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['skills']['investigation']['value'] = $result['Charsheet']['skills']['investigation']['_value'] + $result['Charsheet']['skills']['investigation']['_valueBonus'] + ($result['Charsheet']['skills']['investigation']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['skills']['medicine']['value'] = $result['Charsheet']['skills']['medicine']['_value'] + $result['Charsheet']['skills']['medicine']['_valueBonus'] + ($result['Charsheet']['skills']['medicine']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['skills']['nature']['value'] = $result['Charsheet']['skills']['nature']['_value'] + $result['Charsheet']['skills']['nature']['_valueBonus'] + ($result['Charsheet']['skills']['nature']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['skills']['perception']['value'] = $result['Charsheet']['skills']['perception']['_value'] + $result['Charsheet']['skills']['perception']['_valueBonus'] + ($result['Charsheet']['skills']['perception']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['skills']['performance']['value'] = $result['Charsheet']['skills']['performance']['_value'] + $result['Charsheet']['skills']['performance']['_valueBonus'] + ($result['Charsheet']['skills']['performance']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['skills']['persuasion']['value'] = $result['Charsheet']['skills']['persuasion']['_value'] + $result['Charsheet']['skills']['persuasion']['_valueBonus'] + ($result['Charsheet']['skills']['persuasion']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['skills']['religion']['value'] = $result['Charsheet']['skills']['religion']['_value'] + $result['Charsheet']['skills']['religion']['_valueBonus'] + ($result['Charsheet']['skills']['religion']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['skills']['sleightOfHand']['value'] = $result['Charsheet']['skills']['sleightOfHand']['_value'] + $result['Charsheet']['skills']['sleightOfHand']['_valueBonus'] + ($result['Charsheet']['skills']['sleightOfHand']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['skills']['stealth']['value'] = $result['Charsheet']['skills']['stealth']['_value'] + $result['Charsheet']['skills']['stealth']['_valueBonus'] + ($result['Charsheet']['skills']['stealth']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );
        $result['Charsheet']['skills']['survival']['value'] = $result['Charsheet']['skills']['survival']['_value'] + $result['Charsheet']['skills']['survival']['_valueBonus'] + ($result['Charsheet']['skills']['survival']['proficiency'] > 0 ? $result['Charsheet']['proficiency'] : 0 );

        $eqp = ["equipmentQuiver1", "equipmentQuiver2", "equipmentQuiver3", "equipmentHelmet", "equipmentCape", "equipmentNecklace", "equipmentWeapon1", "equipmentWeapon2", "equipmentWeapon3", "equipmentOffWeapon", "equipmentGloves", "equipmentArmor", "equipmentObject", "equipmentBelt", "equipmentBoots", "equipmentRing1", "equipmentRing2"];
        foreach ($eqp as $e) {
            if (!empty($cheetArray[$e]) && $cheetArray[$e] > 0) {
                $result['Charsheet']['equipment'][str_replace('equipment', '', strtolower($e))] = $cheetArray[$e];
            }
        }


        // Umwelt
        $result['Enviroment']['day'] = $cheetArray['environment_day'];
        $result['Enviroment']['month'] = $cheetArray['environment_month'];
        $result['Enviroment']['year'] = $cheetArray['environment_year'];
        $result['Enviroment']['time'] = $cheetArray['environment_time'];
        $result['Enviroment']['weather'] = $cheetArray['environment_weather'];
        $result['Enviroment']['temperature'] = $cheetArray['environment_temperature'];
        $result['Enviroment']['humidity'] = $cheetArray['environment_humidity'];
        $result['Enviroment']['smog'] = $cheetArray['environment_smog'];
        $cal = new \DND\Core\Calendar();
        $cal->setDay($result['Enviroment']['day']);
        $cal->setMonth($result['Enviroment']['month']);
        $cal->setYear($result['Enviroment']['year']);
        list($a, $b) = explode(':', $result['Enviroment']['time']);
        $cal->setTime($a, $b);
        $result['Enviroment']['date'] = $cal->getDate();

        for ($i = 1; $i <= 4; $i++) {
            $result['Magic'][$i] = [];
            $result['Magic'][$i]['modifier'] = $cheetArray['classes' . ($i) . '_spellAbility'];
            $result['Magic'][$i]['slots'] = explode(';', $cheetArray['class' . ($i) . '_slots']);
        }
        $result['Magic']['List'] = $spells;




        // Tagebuch
        $result['Diary'] = $cheetArray['diary'];
        $result['Map'] = $cheetArray['environment_map'];
        return $result;
    }

    private static function orExplodeStrings($a, $b) {
        $a = explode(';', $a);
        $b = explode(';', $b);
        $r = [];
        for ($i = 0; $i < max(count($a), count($b)); $i++) {
            $t = intval(isset($a[$i]) ? $a[$i] : 0) + intval(isset($b[$i]) ? $b[$i] : 0);
            $r[] = $t > 0 ? 1 : 0;
        }
        return implode(';', $r);
    }

    private static function getDemoResult() {
        return [
            'Charsheet' => [
                "charname" => 'Placeholder',
                "race" => 0,
                "class" => 0,
                "background" => 0,
                "alignment" => Rules::getAligment(4),
                "inspiration" => 0,
                "proficiency" => 0,
                "initiative" => 0,
                "speed" => 0,
                "ac" => 0,
                "hp" => [
                    "max" => 0,
                    "now" => 0,
                    "tmp" => 0,
                ],
                "deathSaves" => [
                    "success" => 0,
                    "failture" => 0,
                ],
                "level" => [
                    "level" => 1,
                    "exp" => 0,
                    "expCap" => Rules::getLevelCap(1),
                    "levelup" => 0,
                ],
                "money" => [
                    "copper" => 0,
                    "silver" => 0,
                    "electrum" => 0,
                    "gold" => 0,
                    "platinum" => 0,
                ],
                "savingThrows" => [
                    "strength" => self::_getDetailsSavingThrows(),
                    "dexterity" => self::_getDetailsSavingThrows(),
                    "constitution" => self::_getDetailsSavingThrows(),
                    "intelligence" => self::_getDetailsSavingThrows(),
                    "wisdom" => self::_getDetailsSavingThrows(),
                    "charisma" => self::_getDetailsSavingThrows(),
                ],
                "skills" => [
                    "acrobatics" => self::_getDetailsSkills(),
                    "animalHandling" => self::_getDetailsSkills(),
                    "arcana" => self::_getDetailsSkills(),
                    "athletics" => self::_getDetailsSkills(),
                    "deception" => self::_getDetailsSkills(),
                    "history" => self::_getDetailsSkills(),
                    "insight" => self::_getDetailsSkills(),
                    "intimidation" => self::_getDetailsSkills(),
                    "investigation" => self::_getDetailsSkills(),
                    "medicine" => self::_getDetailsSkills(),
                    "nature" => self::_getDetailsSkills(),
                    "perception" => self::_getDetailsSkills(),
                    "performance" => self::_getDetailsSkills(),
                    "persuasion" => self::_getDetailsSkills(),
                    "religion" => self::_getDetailsSkills(),
                    "sleightOfHand" => self::_getDetailsSkills(),
                    "stealth" => self::_getDetailsSkills(),
                    "survival" => self::_getDetailsSkills(),
                ],
                "equipment" => [
                    "quiver1" => self::_getDetailsEquipment(),
                    "quiver2" => self::_getDetailsEquipment(),
                    "quiver3" => self::_getDetailsEquipment(),
                    "helmet" => self::_getDetailsEquipment(),
                    "cape" => self::_getDetailsEquipment(),
                    "necklace" => self::_getDetailsEquipment(),
                    "weapon1" => self::_getDetailsEquipment(),
                    "weapon2" => self::_getDetailsEquipment(),
                    "weapon3" => self::_getDetailsEquipment(),
                    "offweapon" => self::_getDetailsEquipment(),
                    "gloves" => self::_getDetailsEquipment(),
                    "armor" => self::_getDetailsEquipment(),
                    "object" => self::_getDetailsEquipment(),
                    "belt" => self::_getDetailsEquipment(),
                    "boots" => self::_getDetailsEquipment(),
                    "ring1" => self::_getDetailsEquipment(),
                    "ring2" => self::_getDetailsEquipment(),
                ],
            ],
            "Enviroment" => [],
            'Magic' => [],
            'Traits' => [],
            'QuestLog' => [],
            'Diary' => [],
            'Map' => [],
            'Logbuch' => [],
            'Debug' => []
        ];
    }

    private static function _getDetailsEquipment() {
        $i = new Item();
        return 0; #$i->getAjax();
    }

    private static function _getDetailsSavingThrows() {
        return [
            "value" => 1,
            "modifier" => Rules::getModifier(1),
            "modifier_raw" => Rules::getModifier(1),
            "_value" => 0,
            "_valueBonus" => 0,
            "_mod" => 0,
            "_modBonus" => 0,
            "proficiency" => 0,
        ];
    }

    private static function _getDetailsSkills() {
        return [
            "value" => 0,
            "_value" => 0,
            "_valueBonus" => 0,
            "proficiency" => 0,
        ];
    }

    private static function parseSavingThrows($savingThrows) {
        
    }

    private static function parseSkills($skills) {
        
    }

}
