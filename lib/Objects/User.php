<?php

namespace DND\Objects;

use \DND\Core\Rules;

class User implements \DND\Interfaces\Objects {

    const tableName = 'dnd_user';
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
    private $mail;
    private $password;
    private $lastLogin;
    private $lastIp;
    private $token;
    private $secToken;
    private $active;
    private $gm;
    private $environmentId;
    private $lastChange;
    private $charname;
    private $race;
    private $class;
    private $background;
    private $alignment;
    private $level;
    private $exp;
    private $inspiration;
    private $proficiency;
    private $initiative;
    private $money;
    private $savingThrows;
    private $skills;
    private $bonusModifier;
    private $hp;
    private $ac;
    private $death;
    private $obj;
    private $diary;
    private $lastActivity;
    private $hpMax = 0;
    private $hpCurrent = 0;
    private $hpTemporary = 0;
    private $deathSucces  = 0;
    private $deathFail = 0;
    private $myRace = 0;
    private $myClass = 0;
    private $myBackground = 0;
    private $myAlignment = 0;
    private $myModifier = 0;
    private $strength = 0;
    private $dexterity = 0;
    private $constitution = 0;
    private $intelligence = 0;
    private $wisdom = 0;
    private $charisma = 0;
    private $bonusStrength = 0;
    private $bonusDexterity = 0;
    private $bonusConstitution = 0;
    private $bonusIntelligence = 0;
    private $bonusWisdom = 0;
    private $bonusCharisma = 0;
    private $modStrength = 0;
    private $modDexterity = 0;
    private $modConstitution = 0;
    private $modIntelligence = 0;
    private $modWisdom = 0;
    private $modCharisma = 0;
    private $bonusModStrength = 0;
    private $bonusModDexterity = 0;
    private $bonusModConstitution = 0;
    private $bonusModIntelligence = 0;
    private $bonusModWisdom = 0;
    private $bonusModCharisma = 0;
    private $bonusAcrobatics = 0;
    private $bonusAnimalHandling = 0;
    private $bonusArcana = 0;
    private $bonusAthletics = 0;
    private $bonusDeception = 0;
    private $bonusHistory = 0;
    private $bonusInsight = 0;
    private $bonusIntimidation = 0;
    private $bonusInvestigation = 0;
    private $bonusMedicine = 0;
    private $bonusNature = 0;
    private $bonusPerception = 0;
    private $bonusPerformance = 0;
    private $bonusPersuasion = 0;
    private $bonusReligion = 0;
    private $bonusSleightOfHand = 0;
    private $bonusStealth = 0;
    private $bonusSurvival = 0;
    private $proficiencyStrength = 0;
    private $proficiencyDexterity = 0;
    private $proficiencyConstitution = 0;
    private $proficiencyIntelligence = 0;
    private $proficiencyWisdom = 0;
    private $proficiencyCharisma = 0;
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
    private $moneyCopper = 0;
    private $moneySilver = 0;
    private $moneyElectrum = 0;
    private $moneyGold = 0;
    private $moneyPlatinum = 0;
    private $equipmentQuiver1 = NULL;
    private $equipmentQuiver2 = NULL;
    private $equipmentQuiver3 = NULL;
    private $equipmentHelmet = NULL;
    private $equipmentCape = NULL;
    private $equipmentNecklace = NULL;
    private $equipmentWeapon1 = NULL;
    private $equipmentWeapon2 = NULL;
    private $equipmentWeapon3 = NULL;
    private $equipmentOffWeapon = NULL;
    private $equipmentGloves = NULL;
    private $equipmentArmor = NULL;
    private $equipmentObject = NULL;
    private $equipmentBelt = NULL;
    private $equipmentBoots = NULL;
    private $equipmentRing1 = NULL;
    private $equipmentRing2 = NULL;

    public function __construct() {
    }

    public function subExtractFromItems($a = NULL) {
        $modifier = [];
        if (!empty($this->myModifier))
            $modifier[] = $this->myModifier;
        if (is_object($a)) {
                if (!empty($a->getModifier()))
                    $modifier[] = $a->getModifier();
        }
        $this->myModifier = implode(';', $modifier);

    }

    public function recalculate() {
        $race = Rules::getRace();
        $class = Rules::getClass();
        $aligment = Rules::getAligment();
        $background = Rules::getBackground();

        $this->id;
        $this->mail;
        $this->password;
        $this->lastLogin;
        $this->lastIp;
        $this->token;
        $this->secToken;
        $this->active;
        $this->gm;
        $this->environmentId;
        $this->charname;
        $this->race;
        $this->class;
        $this->background;
        $this->alignment;
        $this->level;
        $this->exp;
        $this->inspiration;
        $this->proficiency;
        $this->initiative;
        $this->money;
        $this->savingThrows;
        $this->skills;
        $this->bonusModifier;
        $this->obj;

        $this->myRace = $race[$this->race];
        $this->myClass = $class[$this->class];
        $this->myAlignment = $aligment[$this->alignment];
        $this->myBackground = $background[$this->background];
        $mods = [];
        foreach (explode(array(',', ';'), $this->bonusModifier) as $a) {
            $mods[] = $a;
        }
        foreach (explode(array(',', ';'), $this->myRace['ability']) as $a) {
            $mods[] = $a;
        }
        foreach (explode(array(',', ';'), $this->myBackground['ability']) as $a) {
            $mods[] = $a;
        }
        foreach (explode(array(',', ';'), $this->myClass['ability']) as $a) {
            $mods[] = $a;
        }

        $this->myModifier = implode(';', $mods);

        $tmp = explode(';', $this->savingThrows);
        $this->strength = $tmp[self::IDX_ST_STR];
        $this->dexterity = $tmp[self::IDX_ST_DEX];
        $this->constitution = $tmp[self::IDX_ST_CON];
        $this->intelligence = $tmp[self::IDX_ST_INT];
        $this->wisdom = $tmp[self::IDX_ST_WIS];
        $this->charisma = $tmp[self::IDX_ST_CHA];

        $this->bonusStrength = Rules::extractAbility($this->myModifier, 'str', $this->strength);
        $this->bonusDexterity = Rules::extractAbility($this->myModifier, 'dex', $this->dexterity);
        $this->bonusConstitution = Rules::extractAbility($this->myModifier, 'con', $this->constitution);
        $this->bonusIntelligence = Rules::extractAbility($this->myModifier, 'int', $this->intelligence);
        $this->bonusWisdom = Rules::extractAbility($this->myModifier, 'wis', $this->wisdom);
        $this->bonusCharisma = Rules::extractAbility($this->myModifier, 'cha', $this->charisma);

        $this->modStrength = Rules::getModifier($this->strength + $this->bonusStrength);
        $this->modDexterity = Rules::getModifier($this->dexterity + $this->bonusDexterity);
        $this->modConstitution = Rules::getModifier($this->constitution + $this->bonusConstitution);
        $this->modIntelligence = Rules::getModifier($this->intelligence + $this->bonusIntelligence);
        $this->modWisdom = Rules::getModifier($this->wisdom + $this->bonusWisdom);
        $this->modCharisma = Rules::getModifier($this->charisma + $this->bonusCharisma);

        $this->bonusModStrength = Rules::extractAbility($this->myModifier, 'mstr', $this->modStrength);
        $this->bonusModDexterity = Rules::extractAbility($this->myModifier, 'mdex', $this->modDexterity);
        $this->bonusModConstitution = Rules::extractAbility($this->myModifier, 'mcon', $this->modConstitution);
        $this->bonusModIntelligence = Rules::extractAbility($this->myModifier, 'mint', $this->modIntelligence);
        $this->bonusModWisdom = Rules::extractAbility($this->myModifier, 'mwis', $this->modWisdom);
        $this->bonusModCharisma = Rules::extractAbility($this->myModifier, 'mcha', $this->modCharisma);

        $this->bonusAcrobatics = 0;
        $this->bonusAnimalHandling = 0;
        $this->bonusArcana = 0;
        $this->bonusAthletics = 0;
        $this->bonusDeception = 0;
        $this->bonusHistory = 0;
        $this->bonusInsight = 0;
        $this->bonusIntimidation = 0;
        $this->bonusInvestigation = 0;
        $this->bonusMedicine = 0;
        $this->bonusNature = 0;
        $this->bonusPerception = 0;
        $this->bonusPerformance = 0;
        $this->bonusPersuasion = 0;
        $this->bonusReligion = 0;
        $this->bonusSleightOfHand = 0;
        $this->bonusStealth = 0;
        $this->bonusSurvival = 0;

        $this->acrobatics = $this->modDexterity + $this->bonusModDexterity;
        $this->animalHandling = $this->modWisdom + $this->bonusModWisdom;
        $this->arcana = $this->modIntelligence + $this->bonusModIntelligence;
        $this->athletics = $this->modStrength + $this->bonusModStrength;
        $this->deception = $this->modCharisma + $this->bonusModCharisma;
        $this->history = $this->modIntelligence + $this->bonusModIntelligence;
        $this->insight = $this->modWisdom + $this->bonusModWisdom;
        $this->intimidation = $this->modCharisma + $this->bonusModCharisma;
        $this->investigation = $this->modIntelligence + $this->bonusModIntelligence;
        $this->medicine = $this->modWisdom + $this->bonusModWisdom;
        $this->nature = $this->modIntelligence + $this->bonusModIntelligence;
        $this->perception = $this->modWisdom + $this->bonusModWisdom;
        $this->performance = $this->modCharisma + $this->bonusModCharisma;
        $this->persuasion = $this->modCharisma + $this->bonusModCharisma;
        $this->religion = $this->modIntelligence + $this->bonusModIntelligence;
        $this->sleightOfHand = $this->modDexterity + $this->bonusModDexterity;
        $this->stealth = $this->modDexterity + $this->bonusModDexterity;
        $this->survival = $this->modWisdom + $this->bonusModWisdom;

        $tmp = explode(';', $this->skills);
        $this->proficiencyAcrobatics = $tmp[self::IDX_SKILL_Acrobatics];
        $this->proficiencyAnimalHandling = $tmp[self::IDX_SKILL_AnimalHandling];
        $this->proficiencyArcana = $tmp[self::IDX_SKILL_Arcana];
        $this->proficiencyAthletics = $tmp[self::IDX_SKILL_Athletics];
        $this->proficiencyDeception = $tmp[self::IDX_SKILL_Deception];
        $this->proficiencyHistory = $tmp[self::IDX_SKILL_History];
        $this->proficiencyInsight = $tmp[self::IDX_SKILL_Insight];
        $this->proficiencyIntimidation = $tmp[self::IDX_SKILL_Intimidation];
        $this->proficiencyInvestigation = $tmp[self::IDX_SKILL_Investigation];
        $this->proficiencyMedicine = $tmp[self::IDX_SKILL_Medicine];
        $this->proficiencyNature = $tmp[self::IDX_SKILL_Nature];
        $this->proficiencyPerception = $tmp[self::IDX_SKILL_Perception];
        $this->proficiencyPerformance = $tmp[self::IDX_SKILL_Performance];
        $this->proficiencyPersuasion = $tmp[self::IDX_SKILL_Persuasion];
        $this->proficiencyReligion = $tmp[self::IDX_SKILL_Religion];
        $this->proficiencySleightOfHand = $tmp[self::IDX_SKILL_SleightOfHand];
        $this->proficiencyStealth = $tmp[self::IDX_SKILL_Stealth];
        $this->proficiencySurvival = $tmp[self::IDX_SKILL_Survival];


        $tmp = explode(';', $this->money);
        $this->moneyCopper = $tmp[self::IDX_MONEY_CP];
        $this->moneySilver = $tmp[self::IDX_MONEY_SP];
        $this->moneyElectrum = $tmp[self::IDX_MONEY_EP];
        $this->moneyGold = $tmp[self::IDX_MONEY_GP];
        $this->moneyPlatinum = $tmp[self::IDX_MONEY_PP];
        /*
        $this->equipmentQuiver1 = NULL;
        $this->equipmentQuiver2 = NULL;
        $this->equipmentQuiver3 = NULL;
        $this->equipmentHelmet = NULL;
        $this->equipmentCape = NULL;
        $this->equipmentNecklace = NULL;
        $this->equipmentWeapons = NULL;
        $this->equipmentWeapon2 = NULL;
        $this->equipmentWeapon3 = NULL;
        $this->equipmentOffWeapon = NULL;
        $this->equipmentGloves = NULL;
        $this->equipmentArmor = NULL;
        $this->equipmentObject = NULL;
        $this->equipmentBelt = NULL;
        $this->equipmentBoots = NULL;
        $this->equipmentRing1 = NULL;
        $this->equipmentRing2 = NULL;
        */

    }

    public function getDisplayData($a = NULL) {
        $race = Rules::getRace();
        $class = Rules::getClass();
        $aligment = Rules::getAligment();
        $background = Rules::getBackground();

        $this->myRace = $race[$this->race];
        $this->myClass = $class[$this->class];
        $this->myAlignment = $aligment[$this->alignment];
        $this->myBackground = $background[$this->background];

        if (isset($this->myRace['ability']) && !empty($this->myRace['ability'])) {
            $this->myModifier = $this->myModifier . (!empty($this->myModifier) ? ';' : '') . $this->myRace['ability'];
        }
        if ($a !== NULL && is_object($a)) {
            $tmod = $a->getModifier();
            if (!empty($tmod)) {
                $this->myModifier = $this->myModifier . (!empty($this->myModifier) ? ';' : '') . $tmod;
            }
        }

        $tmp = explode(';', $this->hp);
        $this->hpMax  = (int) $tmp[self::IDX_HP_MAX];
	$this->hpCurrent  = (int) $tmp[self::IDX_HP_CURRENT];
	$this->hpTemporary = (int) $tmp[self::IDX_HP_TEMP];

	$tmp = explode(';', $this->death);
        $this->deathSucces = (int) $tmp[self::IDX_DEATH_SUCCESS];
	$this->deathFail = (int) $tmp[self::IDX_DEATH_FAIL];

        $tmp = explode(';', $this->savingThrows);
        $this->strength = (int) $tmp[self::IDX_ST_STR];
        $this->dexterity = (int) $tmp[self::IDX_ST_DEX];
        $this->constitution = (int) $tmp[self::IDX_ST_CON];
        $this->intelligence = (int) $tmp[self::IDX_ST_INT];
        $this->wisdom = (int) $tmp[self::IDX_ST_WIS];
        $this->charisma = (int) $tmp[self::IDX_ST_CHA];

        $this->subExtractFromItems($this->equipmentQuiver1);
        $this->subExtractFromItems($this->equipmentQuiver2);
        $this->subExtractFromItems($this->equipmentQuiver3);
        $this->subExtractFromItems($this->equipmentHelmet);
        $this->subExtractFromItems($this->equipmentCape);
        $this->subExtractFromItems($this->equipmentNecklace);
        $this->subExtractFromItems($this->equipmentWeapon1);
        $this->subExtractFromItems($this->equipmentWeapon2);
        $this->subExtractFromItems($this->equipmentWeapon3);
        $this->subExtractFromItems($this->equipmentGloves);
        $this->subExtractFromItems($this->equipmentArmor);
        $this->subExtractFromItems($this->equipmentObject);
        $this->subExtractFromItems($this->equipmentBelt);
        $this->subExtractFromItems($this->equipmentBoots);
        $this->subExtractFromItems($this->equipmentRing1);
        $this->subExtractFromItems($this->equipmentRing2);

        $this->bonusStrength = Rules::extractAbility($this->myModifier, 'str', $this->strength);
        $this->bonusDexterity = Rules::extractAbility($this->myModifier, 'dex', $this->dexterity);
        $this->bonusConstitution = Rules::extractAbility($this->myModifier, 'con', $this->constitution);
        $this->bonusIntelligence = Rules::extractAbility($this->myModifier, 'int', $this->intelligence);
        $this->bonusWisdom = Rules::extractAbility($this->myModifier, 'wis', $this->wisdom);
        $this->bonusCharisma = Rules::extractAbility($this->myModifier, 'cha', $this->charisma);

        $this->modStrength = Rules::getModifier($this->strength + $this->bonusStrength);
        $this->modDexterity = Rules::getModifier($this->dexterity + $this->bonusDexterity);
        $this->modConstitution = Rules::getModifier($this->constitution + $this->bonusConstitution);
        $this->modIntelligence = Rules::getModifier($this->intelligence + $this->bonusIntelligence);
        $this->modWisdom = Rules::getModifier($this->wisdom + $this->bonusWisdom);
        $this->modCharisma = Rules::getModifier($this->charisma + $this->bonusCharisma);

        $this->bonusModStrength = Rules::extractAbility($this->myModifier, 'mstr', $this->modStrength);
        $this->bonusModDexterity = Rules::extractAbility($this->myModifier, 'mdex', $this->modDexterity);
        $this->bonusModConstitution = Rules::extractAbility($this->myModifier, 'mcon', $this->modConstitution);
        $this->bonusModIntelligence = Rules::extractAbility($this->myModifier, 'mint', $this->modIntelligence);
        $this->bonusModWisdom = Rules::extractAbility($this->myModifier, 'mwis', $this->modWisdom);
        $this->bonusModCharisma = Rules::extractAbility($this->myModifier, 'mcha', $this->modCharisma);

        $this->proficiencyStrength = 0;
        $this->proficiencyDexterity = 0;
        $this->proficiencyConstitution = 0;
        $this->proficiencyIntelligence = 0;
        $this->proficiencyWisdom = 0;
        $this->proficiencyCharisma = 0;
        foreach ($class[$this->class]['proficiency'] as $p) {
            if ($p == 'Strength')
                $this->proficiencyStrength = 1;
            if ($p == 'Dexterity')
                $this->proficiencyDexterity = 1;
            if ($p == 'Constitution')
                $this->proficiencyConstitution = 1;
            if ($p == 'Intelligence')
                $this->proficiencyIntelligence = 1;
            if ($p == 'Wisdom')
                $this->proficiencyWisdom = 1;
            if ($p == 'Charisma')
                $this->proficiencyCharisma = 1;
        }

        $this->acrobatics = $this->modDexterity + $this->bonusModDexterity;
        $this->animalHandling = $this->modWisdom + $this->bonusModWisdom;
        $this->arcana = $this->modIntelligence + $this->bonusModIntelligence;
        $this->athletics = $this->modStrength + $this->bonusModStrength;
        $this->deception = $this->modCharisma + $this->bonusModCharisma;
        $this->history = $this->modIntelligence + $this->bonusModIntelligence;
        $this->insight = $this->modWisdom + $this->bonusModWisdom;
        $this->intimidation = $this->modCharisma + $this->bonusModCharisma;
        $this->investigation = $this->modIntelligence + $this->bonusModIntelligence;
        $this->medicine = $this->modWisdom + $this->bonusModWisdom;
        $this->nature = $this->modIntelligence + $this->bonusModIntelligence;
        $this->perception = $this->modWisdom + $this->bonusModWisdom;
        $this->performance = $this->modCharisma + $this->bonusModCharisma;
        $this->persuasion = $this->modCharisma + $this->bonusModCharisma;
        $this->religion = $this->modIntelligence + $this->bonusModIntelligence;
        $this->sleightOfHand = $this->modDexterity + $this->bonusModDexterity;
        $this->stealth = $this->modDexterity + $this->bonusModDexterity;
        $this->survival = $this->modWisdom + $this->bonusModWisdom;

        $this->bonusAcrobatics = Rules::extractAbility($this->myModifier, 'acro', $this->acrobatics);
        $this->bonusAnimalHandling = Rules::extractAbility($this->myModifier, 'anim', $this->animalHandling);
        $this->bonusArcana = Rules::extractAbility($this->myModifier, 'arca', $this->arcana);
        $this->bonusAthletics = Rules::extractAbility($this->myModifier, 'athl', $this->athletics);
        $this->bonusDeception = Rules::extractAbility($this->myModifier, 'dece', $this->deception);
        $this->bonusHistory = Rules::extractAbility($this->myModifier, 'hist', $this->history);
        $this->bonusInsight = Rules::extractAbility($this->myModifier, 'insi', $this->insight);
        $this->bonusIntimidation = Rules::extractAbility($this->myModifier, 'inti', $this->intimidation);
        $this->bonusInvestigation = Rules::extractAbility($this->myModifier, 'inve', $this->investigation);
        $this->bonusMedicine = Rules::extractAbility($this->myModifier, 'medi', $this->medicine);
        $this->bonusNature = Rules::extractAbility($this->myModifier, 'natu', $this->nature);
        $this->bonusPerception = Rules::extractAbility($this->myModifier, 'perc', $this->perception);
        $this->bonusPerformance = Rules::extractAbility($this->myModifier, 'perf', $this->performance);
        $this->bonusPersuasion = Rules::extractAbility($this->myModifier, 'pers', $this->persuasion);
        $this->bonusReligion = Rules::extractAbility($this->myModifier, 'reli', $this->religion);
        $this->bonusSleightOfHand = Rules::extractAbility($this->myModifier, 'slei', $this->sleightOfHand);
        $this->bonusStealth = Rules::extractAbility($this->myModifier, 'stea', $this->stealth);
        $this->bonusSurvival = Rules::extractAbility($this->myModifier, 'surv', $this->survival);

        $tmp = explode(';', $this->skills);
        $this->proficiencyAcrobatics = (int) $tmp[self::IDX_SKILL_Acrobatics];
        $this->proficiencyAnimalHandling = (int) $tmp[self::IDX_SKILL_AnimalHandling];
        $this->proficiencyArcana = (int) $tmp[self::IDX_SKILL_Arcana];
        $this->proficiencyAthletics = (int) $tmp[self::IDX_SKILL_Athletics];
        $this->proficiencyDeception = (int) $tmp[self::IDX_SKILL_Deception];
        $this->proficiencyHistory = (int) $tmp[self::IDX_SKILL_History];
        $this->proficiencyInsight = (int) $tmp[self::IDX_SKILL_Insight];
        $this->proficiencyIntimidation = (int) $tmp[self::IDX_SKILL_Intimidation];
        $this->proficiencyInvestigation = (int) $tmp[self::IDX_SKILL_Investigation];
        $this->proficiencyMedicine = (int) $tmp[self::IDX_SKILL_Medicine];
        $this->proficiencyNature = (int) $tmp[self::IDX_SKILL_Nature];
        $this->proficiencyPerception = (int) $tmp[self::IDX_SKILL_Perception];
        $this->proficiencyPerformance = (int) $tmp[self::IDX_SKILL_Performance];
        $this->proficiencyPersuasion = (int) $tmp[self::IDX_SKILL_Persuasion];
        $this->proficiencyReligion = (int) $tmp[self::IDX_SKILL_Religion];
        $this->proficiencySleightOfHand = (int) $tmp[self::IDX_SKILL_SleightOfHand];
        $this->proficiencyStealth = (int) $tmp[self::IDX_SKILL_Stealth];
        $this->proficiencySurvival = (int) $tmp[self::IDX_SKILL_Survival];

        foreach ($this->myBackground['proficiency'] as $bg) {
            if ($bg == 'Acrobatics')
                $this->proficiencyAcrobatics = 1;
            if ($bg == 'AnimalHandling')
                $this->proficiencyAnimalHandling = 1;
            if ($bg == 'Arcana')
                $this->proficiencyArcana = 1;
            if ($bg == 'Athletics')
                $this->proficiencyAthletics = 1;
            if ($bg == 'Deception')
                $this->proficiencyDeception = 1;
            if ($bg == 'History')
                $this->proficiencyHistory = 1;
            if ($bg == 'Insight')
                $this->proficiencyInsight = 1;
            if ($bg == 'Intimidation')
                $this->proficiencyIntimidation = 1;
            if ($bg == 'Investigation')
                $this->proficiencyInvestigation = 1;
            if ($bg == 'Medicine')
                $this->proficiencyMedicine = 1;
            if ($bg == 'Nature')
                $this->proficiencyNature = 1;
            if ($bg == 'Perception')
                $this->proficiencyPerception = 1;
            if ($bg == 'Performance')
                $this->proficiencyPerformance = 1;
            if ($bg == 'Persuasion')
                $this->proficiencyPersuasion = 1;
            if ($bg == 'Religion')
                $this->proficiencyReligion = 1;
            if ($bg == 'SleightOfHand')
                $this->proficiencySleightOfHand = 1;
            if ($bg == 'Stealth')
                $this->proficiencyStealth = 1;
            if ($bg == 'Survival')
                $this->proficiencySurvival = 1;
        }

        $tmp = explode(';', $this->money);
        $this->moneyCopper = (int) $tmp[self::IDX_MONEY_CP];
        $this->moneySilver = (int) $tmp[self::IDX_MONEY_SP];
        $this->moneyElectrum = (int) $tmp[self::IDX_MONEY_EP];
        $this->moneyGold = (int) $tmp[self::IDX_MONEY_GP];
        $this->moneyPlatinum = (int) $tmp[self::IDX_MONEY_PP];

        $proficiency = Rules::getProficiency($this->level) + Rules::extractAbility($this->myModifier, 'prof');
        return array(
            "debug" => $this->myModifier,
            "charname" => $this->charname,
            "race" => $race[$this->race],
            "class" => $class[$this->class],
            "background" => $background[$this->background],
            "alignment" => $aligment[$this->alignment],
            "inspiration" => $this->inspiration + Rules::extractAbility($this->myModifier, 'insp'),
            "proficiency" => $proficiency,
            "initiative" => $this->initiative + Rules::extractAbility($this->myModifier, 'init'),
            "speed" => $race[$this->race]['speed'] + Rules::extractAbility($this->myModifier, 'speed'),
            "ac" => $this->ac + Rules::extractAbility($this->myModifier, 'ac'),
            "diary" => $this->diary,
            "hp" => array(
                "max" => $this->hpMax + Rules::extractAbility($this->myModifier, 'maxhp'),
                "now" => $this->hpCurrent,
                "tmp" => $this->hpTemporary,
            ),
            "deathSaves" => array(
                "success" => $this->deathSucces,
                "failture" => $this->deathFail
            ),
            "level" => array(
                "level" => $this->level,
                "exp" => $this->exp,
                "expCap" => Rules::getLevelCap($this->level),
                "levelup" => Rules::gotLevelup($this->level, $this->exp),
            ),
            "savingThrows" => array(
                "strength" => array(
                    "value" => $this->strength + $this->bonusStrength,
                    "modifier" => $this->modStrength + $this->bonusModStrength + ($this->proficiencyStrength>0 ? $proficiency : 0),
                    "modifier_raw" => $this->modStrength + $this->bonusModStrength,
                    "_value" => $this->strength,
                    "_valueBonus" => $this->bonusStrength,
                    "_mod" => $this->modStrength,
                    "_modBonus" => $this->bonusModStrength,
                    "proficiency" => $this->proficiencyStrength
                ),
                "dexterity" => array(
                    "value" => $this->dexterity + $this->bonusDexterity,
                    "modifier" => $this->modDexterity + $this->bonusModDexterity + ($this->proficiencyDexterity>0 ? $proficiency : 0),
                    "modifier_raw" => $this->modDexterity + $this->bonusModDexterity,
                    "_value" => $this->dexterity,
                    "_valueBonus" => $this->bonusDexterity,
                    "_mod" => $this->modDexterity,
                    "_modBonus" => $this->bonusModDexterity,
                    "proficiency" => $this->proficiencyDexterity
                ),
                "constitution" => array(
                    "value" => $this->constitution + $this->bonusConstitution,
                    "modifier" => $this->modConstitution + $this->bonusModConstitution + ($this->proficiencyConstitution>0 ? $proficiency : 0),
                    "modifier_raw" => $this->modConstitution + $this->bonusModConstitution,
                    "_value" => $this->constitution,
                    "_valueBonus" => $this->bonusConstitution,
                    "_mod" => $this->modConstitution,
                    "_modBonus" => $this->bonusModConstitution,
                    "proficiency" => $this->proficiencyConstitution
                ),
                "intelligence" => array(
                    "value" => $this->intelligence + $this->bonusIntelligence,
                    "modifier" => $this->modIntelligence + $this->bonusModIntelligence + ($this->proficiencyIntelligence>0 ? $proficiency : 0),
                    "modifier_raw" => $this->modIntelligence + $this->bonusModIntelligence,
                    "_value" => $this->intelligence,
                    "_valueBonus" => $this->bonusIntelligence,
                    "_mod" => $this->modIntelligence,
                    "_modBonus" => $this->bonusModIntelligence,
                    "proficiency" => $this->proficiencyIntelligence
                ),
                "wisdom" => array(
                    "value" => $this->wisdom + $this->bonusWisdom,
                    "modifier" => $this->modWisdom + $this->bonusModWisdom + ($this->proficiencyWisdom>0 ? $proficiency : 0),
                    "modifier_raw" => $this->modWisdom + $this->bonusModWisdom,
                    "_value" => $this->wisdom,
                    "_valueBonus" => $this->bonusWisdom,
                    "_mod" => $this->modWisdom,
                    "_modBonus" => $this->bonusModWisdom,
                    "proficiency" => $this->proficiencyWisdom
                ),
                "charisma" => array(
                    "value" => $this->charisma + $this->bonusCharisma,
                    "modifier" => $this->modCharisma + $this->bonusModCharisma + ($this->proficiencyCharisma>0 ? $proficiency : 0),
                    "modifier_raw" => $this->modCharisma + $this->bonusModCharisma,
                    "_value" => $this->charisma,
                    "_valueBonus" => $this->bonusCharisma,
                    "_mod" => $this->modCharisma,
                    "_modBonus" => $this->bonusModCharisma,
                    "proficiency" => $this->proficiencyCharisma
                ),
            ),
            "skills" => array(
                "acrobatics" => array(
                    "value" => $this->acrobatics + $this->bonusAcrobatics + ($this->proficiencyAcrobatics > 0 ? $proficiency : 0),
                    "_value" => $this->acrobatics,
                    "_valueBonus" => $this->bonusAcrobatics,
                    "proficiency" => $this->proficiencyAcrobatics,
                ),
                "animalHandling" => array(
                    "value" => $this->animalHandling + $this->bonusAnimalHandling + ($this->proficiencyAnimalHandling > 0 ? $proficiency : 0),
                    "_value" => $this->animalHandling,
                    "bonus" => $this->bonusAnimalHandling,
                    "proficiency" => $this->proficiencyAnimalHandling,
                ),
                "arcana" => array(
                    "value" => $this->arcana + $this->bonusArcana + ($this->proficiencyArcana > 0 ? $proficiency : 0),
                    "_value" => $this->arcana,
                    "_valueBonus" => $this->bonusArcana,
                    "proficiency" => $this->proficiencyArcana,
                ),
                "athletics" => array(
                    "value" => $this->athletics + $this->bonusAthletics + ($this->proficiencyAthletics > 0 ? $proficiency : 0),
                    "_value" => $this->athletics,
                    "_valueBonus" => $this->bonusAthletics,
                    "proficiency" => $this->proficiencyAthletics,
                ),
                "deception" => array(
                    "value" => $this->deception + $this->bonusDeception + ($this->proficiencyDeception > 0 ? $proficiency : 0),
                    "_value" => $this->deception,
                    "_valueBonus" => $this->bonusDeception,
                    "proficiency" => $this->proficiencyDeception,
                ),
                "history" => array(
                    "value" => $this->history + $this->bonusHistory + ($this->proficiencyHistory > 0 ? $proficiency : 0),
                    "_value" => $this->history,
                    "_valueBonus" => $this->bonusHistory,
                    "proficiency" => $this->proficiencyHistory,
                ),
                "insight" => array(
                    "value" => $this->insight + $this->bonusInsight + ($this->proficiencyInsight > 0 ? $proficiency : 0),
                    "_value" => $this->insight,
                    "_valueBonus" => $this->bonusInsight,
                    "proficiency" => $this->proficiencyInsight,
                ),
                "intimidation" => array(
                    "value" => $this->intimidation + $this->bonusIntimidation + ($this->proficiencyIntimidation > 0 ? $proficiency : 0),
                    "_value" => $this->intimidation,
                    "_valueBonus" => $this->bonusIntimidation,
                    "proficiency" => $this->proficiencyIntimidation,
                ),
                "investigation" => array(
                    "value" => $this->investigation + $this->bonusInvestigation + ($this->proficiencyInvestigation > 0 ? $proficiency : 0),
                    "_value" => $this->investigation,
                    "_valueBonus" => $this->bonusInvestigation,
                    "proficiency" => $this->proficiencyInvestigation
                ),
                "medicine" => array(
                    "value" => $this->medicine + $this->bonusMedicine + ($this->proficiencyMedicine > 0 ? $proficiency : 0),
                    "_value" => $this->medicine,
                    "_valueBonus" => $this->bonusMedicine,
                    "proficiency" => $this->proficiencyMedicine
                ),
                "nature" => array(
                    "value" => $this->nature + $this->bonusNature + ($this->proficiencyNature > 0 ? $proficiency : 0),
                    "_value" => $this->nature,
                    "_valueBonus" => $this->bonusNature,
                    "proficiency" => $this->proficiencyNature
                ),
                "perception" => array(
                    "value" => $this->perception + $this->bonusPerception + ($this->proficiencyPerception > 0 ? $proficiency : 0),
                    "_value" => $this->perception,
                    "_valueBonus" => $this->bonusPerception,
                    "proficiency" => $this->proficiencyPerception
                ),
                "performance" => array(
                    "value" => $this->performance + $this->bonusPerformance + ($this->proficiencyPerformance > 0 ? $proficiency : 0),
                    "_value" => $this->performance,
                    "_valueBonus" => $this->bonusPerformance,
                    "proficiency" => $this->proficiencyPerformance
                ),
                "persuasion" => array(
                    "value" => $this->persuasion + $this->bonusPersuasion + ($this->proficiencyPersuasion > 0 ? $proficiency : 0),
                    "_value" => $this->persuasion,
                    "_valueBonus" => $this->bonusPersuasion,
                    "proficiency" => $this->proficiencyPersuasion,
                ),
                "religion" => array(
                    "value" => $this->religion + $this->bonusReligion + ($this->proficiencyReligion > 0 ? $proficiency : 0),
                    "_value" => $this->religion,
                    "_valueBonus" => $this->bonusReligion,
                    "proficiency" => $this->proficiencyReligion,
                ),
                "sleightOfHand" => array(
                    "value" => $this->sleightOfHand + $this->bonusSleightOfHand + ($this->proficiencySleightOfHand > 0 ? $proficiency : 0),
                    "_value" => $this->sleightOfHand,
                    "_valueBonus" => $this->bonusSleightOfHand,
                    "proficiency" => $this->proficiencySleightOfHand,
                ),
                "stealth" => array(
                    "value" => $this->stealth + $this->bonusStealth + ($this->proficiencyStealth > 0 ? $proficiency : 0),
                    "_value" => $this->stealth,
                    "_valueBonus" => $this->bonusStealth,
                    "proficiency" => $this->proficiencyStealth,
                ),
                "survival" => array(
                    "value" => $this->survival + $this->bonusSurvival + ($this->proficiencySurvival > 0 ? $proficiency : 0),
                    "_value" => $this->survival,
                    "_valueBonus" => $this->bonusSurvival,
                    "proficiency" => $this->proficiencySurvival,
                ),
            ),
            "equipment" => array(
                "quiver1" => is_object($this->equipmentQuiver1)? $this->equipmentQuiver1->getAjax() : null,
                "quiver2" => is_object($this->equipmentQuiver2)? $this->equipmentQuiver2->getAjax() : null,
                "quiver3" => is_object($this->equipmentQuiver3)? $this->equipmentQuiver3->getAjax() : null,
                "helmet" =>  is_object($this->equipmentHelmet)? $this->equipmentHelmet->getAjax() : null,
                "cape" =>    is_object($this->equipmentCape)? $this->equipmentCape->getAjax() : null,
                "necklace" =>is_object($this->equipmentNecklace)? $this->equipmentNecklace->getAjax() : null,
                "weapon1" => is_object($this->equipmentWeapon1)? $this->equipmentWeapon1->getAjax() : null,
                "weapon2" => is_object($this->equipmentWeapon2)? $this->equipmentWeapon2->getAjax() : null,
                "weapon3" => is_object($this->equipmentWeapon3)? $this->equipmentWeapon3->getAjax() : null,
                "offweapon" => is_object($this->equipmentOffWeapon)? $this->equipmentOffWeapon->getAjax() : null,
                "gloves" =>is_object($this->equipmentGloves)? $this->equipmentGloves->getAjax() : null,
                "armor" => is_object($this->equipmentArmor)? $this->equipmentArmor->getAjax() : null,
                "object" =>is_object($this->equipmentObject)? $this->equipmentObject->getAjax() : null,
                "belt" =>  is_object($this->equipmentBelt)? $this->equipmentBelt->getAjax() : null,
                "boots" => is_object($this->equipmentBoots)? $this->equipmentBoots->getAjax() : null,
                "ring1" => is_object($this->equipmentRing1)? $this->equipmentRing1->getAjax() : null,
                "ring2" => is_object($this->equipmentRing2)? $this->equipmentRing2->getAjax() : null,
            ),
            "money" => array(
                "copper" => $this->moneyCopper,
                "silver" => $this->moneySilver,
                "electrum" => $this->moneyElectrum,
                "gold" => $this->moneyGold,
                "platinum" => $this->moneyPlatinum,
            ),
        );

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

    public function setPassword($value) {
        $this->password = $value;
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

    public function getActive() {
        return $this->active;
    }

    public function setActive($value) {
        $this->active = $value;
        return $this;
    }

    public function getGm() {
        return $this->gm;
    }

    public function setGm($value) {
        $this->gm = $value;
        return $this;
    }

    public function getEnvironmentid() {
        return $this->environmentId;
    }

    public function setEnvironmentid($value) {
        $this->environmentId = $value;
        return $this;
    }

    public function getLastchange() {
        return $this->lastChange;
    }

    public function setLastchange($value) {
        $this->lastChange = $value;
        return $this;
    }

    public function getCharname() {
        return $this->charname;
    }

    public function setCharname($value) {
        $this->charname = $value;
        return $this;
    }

    public function getRace() {
        return $this->race;
    }

    public function setRace($value) {
        $this->race = $value;
        return $this;
    }

    public function getClass() {
        return $this->class;
    }

    public function setClass($value) {
        $this->class = $value;
        return $this;
    }

    public function getBackground() {
        return $this->background;
    }

    public function setBackground($value) {
        $this->background = $value;
        return $this;
    }

    public function getAlignment() {
        return $this->alignment;
    }

    public function setAlignment($value) {
        $this->alignment = $value;
        return $this;
    }

    public function getLevel() {
        return $this->level;
    }

    public function setLevel($value) {
        $this->level = $value;
        return $this;
    }

    public function getExp() {
        return $this->exp;
    }

    public function setExp($value) {
        $this->exp = $value;
        return $this;
    }

    public function getInspiration() {
        return $this->inspiration;
    }

    public function setInspiration($value) {
        $this->inspiration = $value;
        return $this;
    }

    public function getProficiency() {
        return $this->proficiency;
    }

    public function setProficiency($value) {
        $this->proficiency = $value;
        return $this;
    }

    public function getInitiative() {
        return $this->initiative;
    }

    public function setInitiative($value) {
        $this->initiative = $value;
        return $this;
    }

    public function getMoney() {
        return $this->money;
    }

    public function setMoney($value) {
        $this->money = $value;
        return $this;
    }

    public function getSavingthrows() {
        return $this->savingThrows;
    }

    public function setSavingthrows($value) {
        $this->savingThrows = $value;
        return $this;
    }

    public function getSkills() {
        return $this->skills;
    }

    public function setSkills($value) {
        $this->skills = $value;
        return $this;
    }

    public function getBonusmodifier() {
        return $this->bonusModifier;
    }

    public function setBonusmodifier($value) {
        $this->bonusModifier = $value;
        return $this;
    }

    public function getHp() {
        return $this->hp;
    }

    public function setHp($value) {
        $this->hp = $value;
        return $this;
    }

    public function getAc() {
        return $this->ac;
    }

    public function setAc($value) {
        $this->ac = $value;
        return $this;
    }

    public function getDeath() {
        return $this->death;
    }

    public function setDeath($value) {
        $this->death = $value;
        return $this;
    }

    public function getObj() {
        return $this->obj;
    }

    public function setObj($value) {
        $this->obj = $value;
        return $this;
    }

    public function getDiary() {
        return $this->diary;
    }

    public function setDiary($value) {
        $this->diary = $value;
        return $this;
    }

    public function getLastactivity() {
        return $this->lastActivity;
    }

    public function setLastactivity($value) {
        $this->lastActivity = $value;
        return $this;
    }

    public function getHpmax() {
        return $this->hpMax;
    }

    public function setHpmax($value) {
        $this->hpMax = $value;
        return $this;
    }

    public function getHpcurrent() {
        return $this->hpCurrent;
    }

    public function setHpcurrent($value) {
        $this->hpCurrent = $value;
        return $this;
    }

    public function getHptemporary() {
        return $this->hpTemporary;
    }

    public function setHptemporary($value) {
        $this->hpTemporary = $value;
        return $this;
    }

    public function getDeathsucces () {
        return $this->deathSucces ;
    }

    public function setDeathsucces ($value) {
        $this->deathSucces  = $value;
        return $this;
    }

    public function getDeathfail() {
        return $this->deathFail;
    }

    public function setDeathfail($value) {
        $this->deathFail = $value;
        return $this;
    }

    public function getMyrace() {
        return $this->myRace;
    }

    public function setMyrace($value) {
        $this->myRace = $value;
        return $this;
    }

    public function getMyclass() {
        return $this->myClass;
    }

    public function setMyclass($value) {
        $this->myClass = $value;
        return $this;
    }

    public function getMybackground() {
        return $this->myBackground;
    }

    public function setMybackground($value) {
        $this->myBackground = $value;
        return $this;
    }

    public function getMyalignment() {
        return $this->myAlignment;
    }

    public function setMyalignment($value) {
        $this->myAlignment = $value;
        return $this;
    }

    public function getMymodifier() {
        return $this->myModifier;
    }

    public function setMymodifier($value) {
        $this->myModifier = $value;
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

    public function getConstitution() {
        return $this->constitution;
    }

    public function setConstitution($value) {
        $this->constitution = $value;
        return $this;
    }

    public function getIntelligence() {
        return $this->intelligence;
    }

    public function setIntelligence($value) {
        $this->intelligence = $value;
        return $this;
    }

    public function getWisdom() {
        return $this->wisdom;
    }

    public function setWisdom($value) {
        $this->wisdom = $value;
        return $this;
    }

    public function getCharisma() {
        return $this->charisma;
    }

    public function setCharisma($value) {
        $this->charisma = $value;
        return $this;
    }

    public function getBonusstrength() {
        return $this->bonusStrength;
    }

    public function setBonusstrength($value) {
        $this->bonusStrength = $value;
        return $this;
    }

    public function getBonusdexterity() {
        return $this->bonusDexterity;
    }

    public function setBonusdexterity($value) {
        $this->bonusDexterity = $value;
        return $this;
    }

    public function getBonusconstitution() {
        return $this->bonusConstitution;
    }

    public function setBonusconstitution($value) {
        $this->bonusConstitution = $value;
        return $this;
    }

    public function getBonusintelligence() {
        return $this->bonusIntelligence;
    }

    public function setBonusintelligence($value) {
        $this->bonusIntelligence = $value;
        return $this;
    }

    public function getBonuswisdom() {
        return $this->bonusWisdom;
    }

    public function setBonuswisdom($value) {
        $this->bonusWisdom = $value;
        return $this;
    }

    public function getBonuscharisma() {
        return $this->bonusCharisma;
    }

    public function setBonuscharisma($value) {
        $this->bonusCharisma = $value;
        return $this;
    }

    public function getModstrength() {
        return $this->modStrength;
    }

    public function setModstrength($value) {
        $this->modStrength = $value;
        return $this;
    }

    public function getModdexterity() {
        return $this->modDexterity;
    }

    public function setModdexterity($value) {
        $this->modDexterity = $value;
        return $this;
    }

    public function getModconstitution() {
        return $this->modConstitution;
    }

    public function setModconstitution($value) {
        $this->modConstitution = $value;
        return $this;
    }

    public function getModintelligence() {
        return $this->modIntelligence;
    }

    public function setModintelligence($value) {
        $this->modIntelligence = $value;
        return $this;
    }

    public function getModwisdom() {
        return $this->modWisdom;
    }

    public function setModwisdom($value) {
        $this->modWisdom = $value;
        return $this;
    }

    public function getModcharisma() {
        return $this->modCharisma;
    }

    public function setModcharisma($value) {
        $this->modCharisma = $value;
        return $this;
    }

    public function getBonusmodstrength() {
        return $this->bonusModStrength;
    }

    public function setBonusmodstrength($value) {
        $this->bonusModStrength = $value;
        return $this;
    }

    public function getBonusmoddexterity() {
        return $this->bonusModDexterity;
    }

    public function setBonusmoddexterity($value) {
        $this->bonusModDexterity = $value;
        return $this;
    }

    public function getBonusmodconstitution() {
        return $this->bonusModConstitution;
    }

    public function setBonusmodconstitution($value) {
        $this->bonusModConstitution = $value;
        return $this;
    }

    public function getBonusmodintelligence() {
        return $this->bonusModIntelligence;
    }

    public function setBonusmodintelligence($value) {
        $this->bonusModIntelligence = $value;
        return $this;
    }

    public function getBonusmodwisdom() {
        return $this->bonusModWisdom;
    }

    public function setBonusmodwisdom($value) {
        $this->bonusModWisdom = $value;
        return $this;
    }

    public function getBonusmodcharisma() {
        return $this->bonusModCharisma;
    }

    public function setBonusmodcharisma($value) {
        $this->bonusModCharisma = $value;
        return $this;
    }

    public function getBonusacrobatics() {
        return $this->bonusAcrobatics;
    }

    public function setBonusacrobatics($value) {
        $this->bonusAcrobatics = $value;
        return $this;
    }

    public function getBonusanimalhandling() {
        return $this->bonusAnimalHandling;
    }

    public function setBonusanimalhandling($value) {
        $this->bonusAnimalHandling = $value;
        return $this;
    }

    public function getBonusarcana() {
        return $this->bonusArcana;
    }

    public function setBonusarcana($value) {
        $this->bonusArcana = $value;
        return $this;
    }

    public function getBonusathletics() {
        return $this->bonusAthletics;
    }

    public function setBonusathletics($value) {
        $this->bonusAthletics = $value;
        return $this;
    }

    public function getBonusdeception() {
        return $this->bonusDeception;
    }

    public function setBonusdeception($value) {
        $this->bonusDeception = $value;
        return $this;
    }

    public function getBonushistory() {
        return $this->bonusHistory;
    }

    public function setBonushistory($value) {
        $this->bonusHistory = $value;
        return $this;
    }

    public function getBonusinsight() {
        return $this->bonusInsight;
    }

    public function setBonusinsight($value) {
        $this->bonusInsight = $value;
        return $this;
    }

    public function getBonusintimidation() {
        return $this->bonusIntimidation;
    }

    public function setBonusintimidation($value) {
        $this->bonusIntimidation = $value;
        return $this;
    }

    public function getBonusinvestigation() {
        return $this->bonusInvestigation;
    }

    public function setBonusinvestigation($value) {
        $this->bonusInvestigation = $value;
        return $this;
    }

    public function getBonusmedicine() {
        return $this->bonusMedicine;
    }

    public function setBonusmedicine($value) {
        $this->bonusMedicine = $value;
        return $this;
    }

    public function getBonusnature() {
        return $this->bonusNature;
    }

    public function setBonusnature($value) {
        $this->bonusNature = $value;
        return $this;
    }

    public function getBonusperception() {
        return $this->bonusPerception;
    }

    public function setBonusperception($value) {
        $this->bonusPerception = $value;
        return $this;
    }

    public function getBonusperformance() {
        return $this->bonusPerformance;
    }

    public function setBonusperformance($value) {
        $this->bonusPerformance = $value;
        return $this;
    }

    public function getBonuspersuasion() {
        return $this->bonusPersuasion;
    }

    public function setBonuspersuasion($value) {
        $this->bonusPersuasion = $value;
        return $this;
    }

    public function getBonusreligion() {
        return $this->bonusReligion;
    }

    public function setBonusreligion($value) {
        $this->bonusReligion = $value;
        return $this;
    }

    public function getBonussleightofhand() {
        return $this->bonusSleightOfHand;
    }

    public function setBonussleightofhand($value) {
        $this->bonusSleightOfHand = $value;
        return $this;
    }

    public function getBonusstealth() {
        return $this->bonusStealth;
    }

    public function setBonusstealth($value) {
        $this->bonusStealth = $value;
        return $this;
    }

    public function getBonussurvival() {
        return $this->bonusSurvival;
    }

    public function setBonussurvival($value) {
        $this->bonusSurvival = $value;
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

    public function getMoneycopper() {
        return $this->moneyCopper;
    }

    public function setMoneycopper($value) {
        $this->moneyCopper = $value;
        return $this;
    }

    public function getMoneysilver() {
        return $this->moneySilver;
    }

    public function setMoneysilver($value) {
        $this->moneySilver = $value;
        return $this;
    }

    public function getMoneyelectrum() {
        return $this->moneyElectrum;
    }

    public function setMoneyelectrum($value) {
        $this->moneyElectrum = $value;
        return $this;
    }

    public function getMoneygold() {
        return $this->moneyGold;
    }

    public function setMoneygold($value) {
        $this->moneyGold = $value;
        return $this;
    }

    public function getMoneyplatinum() {
        return $this->moneyPlatinum;
    }

    public function setMoneyplatinum($value) {
        $this->moneyPlatinum = $value;
        return $this;
    }

    public function getEquipmentquiver1() {
        return $this->equipmentQuiver1;
    }

    public function setEquipmentquiver1($value) {
        $this->equipmentQuiver1 = $value;
        return $this;
    }

    public function getEquipmentquiver2() {
        return $this->equipmentQuiver2;
    }

    public function setEquipmentquiver2($value) {
        $this->equipmentQuiver2 = $value;
        return $this;
    }

    public function getEquipmentquiver3() {
        return $this->equipmentQuiver3;
    }

    public function setEquipmentquiver3($value) {
        $this->equipmentQuiver3 = $value;
        return $this;
    }

    public function getEquipmenthelmet() {
        return $this->equipmentHelmet;
    }

    public function setEquipmenthelmet($value) {
        $this->equipmentHelmet = $value;
        return $this;
    }

    public function getEquipmentcape() {
        return $this->equipmentCape;
    }

    public function setEquipmentcape($value) {
        $this->equipmentCape = $value;
        return $this;
    }

    public function getEquipmentnecklace() {
        return $this->equipmentNecklace;
    }

    public function setEquipmentnecklace($value) {
        $this->equipmentNecklace = $value;
        return $this;
    }

    public function getEquipmentweapon1() {
        return $this->equipmentWeapon1;
    }

    public function setEquipmentweapon1($value) {
        $this->equipmentWeapon1 = $value;
        return $this;
    }

    public function getEquipmentweapon2() {
        return $this->equipmentWeapon2;
    }

    public function setEquipmentweapon2($value) {
        $this->equipmentWeapon2 = $value;
        return $this;
    }

    public function getEquipmentweapon3() {
        return $this->equipmentWeapon3;
    }

    public function setEquipmentweapon3($value) {
        $this->equipmentWeapon3 = $value;
        return $this;
    }

    public function getEquipmentoffweapon() {
        return $this->equipmentOffWeapon;
    }

    public function setEquipmentoffweapon($value) {
        $this->equipmentOffWeapon = $value;
        return $this;
    }

    public function getEquipmentgloves() {
        return $this->equipmentGloves;
    }

    public function setEquipmentgloves($value) {
        $this->equipmentGloves = $value;
        return $this;
    }

    public function getEquipmentarmor() {
        return $this->equipmentArmor;
    }

    public function setEquipmentarmor($value) {
        $this->equipmentArmor = $value;
        return $this;
    }

    public function getEquipmentobject() {
        return $this->equipmentObject;
    }

    public function setEquipmentobject($value) {
        $this->equipmentObject = $value;
        return $this;
    }

    public function getEquipmentbelt() {
        return $this->equipmentBelt;
    }

    public function setEquipmentbelt($value) {
        $this->equipmentBelt = $value;
        return $this;
    }

    public function getEquipmentboots() {
        return $this->equipmentBoots;
    }

    public function setEquipmentboots($value) {
        $this->equipmentBoots = $value;
        return $this;
    }

    public function getEquipmentring1() {
        return $this->equipmentRing1;
    }

    public function setEquipmentring1($value) {
        $this->equipmentRing1 = $value;
        return $this;
    }

    public function getEquipmentring2() {
        return $this->equipmentRing2;
    }

    public function setEquipmentring2($value) {
        $this->equipmentRing2 = $value;
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

    public function fillFromPost($a) {
        
        $this->money = (isset($a["cp"]) ? $a["cp"] : 0) . ';' .(isset($a["sp"]) ? $a["sp"] : 0) . ';' .(isset($a["ep"]) ? $a["ep"] : 0) . ';' .(isset($a["gp"]) ? $a["gp"] : 0) . ';' .(isset($a["pp"]) ? $a["pp"] : 0);
        $this->savingThrows = (isset($a["str"])?$a["str"]:0).';'.(isset($a["dex"])?$a["dex"]:0).';'.(isset($a["con"])?$a["con"]:0).';'.(isset($a["int"])?$a["int"]:0).';'.(isset($a["wis"])?$a["wis"]:0).';'.(isset($a["cha"])?$a["cha"]:0);
        $this->skills = (isset($a["acrobatics"]) ? $a["acrobatics"] : 0) . ';' . (isset($a["animalhandling"]) ? $a["animalhandling"] : 0) . ';' . (isset($a["arcana"]) ? $a["arcana"] : 0) . ';' . (isset($a["athletics"]) ? $a["athletics"] : 0) . ';' . (isset($a["deception"]) ? $a["deception"] : 0) . ';' . (isset($a["history"]) ? $a["history"] : 0) . ';' . (isset($a["insight"]) ? $a["insight"] : 0) . ';' . (isset($a["intimidation"]) ? $a["intimidation"] : 0) . ';' . (isset($a["investigation"]) ? $a["investigation"] : 0) . ';' . (isset($a["medicine"]) ? $a["medicine"] : 0) . ';' . (isset($a["nature"]) ? $a["nature"] : 0) . ';' . (isset($a["perception"]) ? $a["perception"] : 0) . ';' . (isset($a["performance"]) ? $a["performance"] : 0) . ';' . (isset($a["persuasion"]) ? $a["persuasion"] : 0) . ';' . (isset($a["religion"]) ? $a["religion"] : 0) . ';' . (isset($a["sleightofhand"]) ? $a["sleightofhand"] : 0) . ';' . (isset($a["stealth"]) ? $a["stealth"] : 0) . ';' . (isset($a["survival"]) ? $a["survival"] : 0);

        if(isset($a["id"])){$this->id = $a["id"];}
        if(isset($a["mail"]) && !empty($a["mail"]) ){$this->mail = $a["mail"];}
        if(isset($a["password"]) && !empty($a["password"]) ){$this->password = $a["password"];}
        if(isset($a["lastLogin"]) ){$this->lastLogin = $a["lastLogin"];}
        if(isset($a["lastIp"]) ){$this->lastIp = $a["lastIp"];}
        if(isset($a["token"]) ){$this->token = $a["token"];}
        if(isset($a["secToken"]) ){$this->secToken = $a["secToken"];}
        if(isset($a["active"]) ){$this->active = $a["active"];}
        if(isset($a["gm"]) ){$this->gm = $a["gm"];}
        if(isset($a["environmentId"]) ){$this->environmentId = $a["environmentId"];}
        if(isset($a["lastChange"]) ){$this->lastChange = $a["lastChange"];}
        if(isset($a["charname"]) ){$this->charname = $a["charname"];}
        if(isset($a["race"]) ){$this->race = $a["race"];}
        if(isset($a["class"]) ){$this->class = $a["class"];}
        if(isset($a["background"]) ){$this->background = $a["background"];}
        if(isset($a["alignment"]) ){$this->alignment = $a["alignment"];}
        if(isset($a["level"]) ){$this->level = $a["level"];}
        if(isset($a["exp"]) ){$this->exp = $a["exp"];}
        if(isset($a["inspiration"]) ){$this->inspiration = $a["inspiration"];}
        if(isset($a["proficiency"]) ){$this->proficiency = $a["proficiency"];}
        if(isset($a["initiative"]) ){$this->initiative = $a["initiative"];}
        if(isset($a["money"]) ){$this->money = $a["money"];}
        if(isset($a["savingThrows"]) ){$this->savingThrows = $a["savingThrows"];}
        if(isset($a["skills"]) ){$this->skills = $a["skills"];}
        if(isset($a["bonusModifier"]) ){$this->bonusModifier = $a["bonusModifier"];}
        if(isset($a["hp"]) ){$this->hp = $a["hp"];}
        if(isset($a["ac"]) ){$this->ac = $a["ac"];}
        if(isset($a["death"]) ){$this->death = $a["death"];}
        if(isset($a["obj"]) ){$this->obj = $a["obj"];}
        if(isset($a["diary"]) ){$this->diary = $a["diary"];}
        if(isset($array["lastActivity"]) ){$this->lastActivity = $array["lastActivity"];}

        if(isset($array["equipmentQuiver1"])){$this->equipmentQuiver1 = $array["equipmentQuiver1"];}
        if(isset($array["equipmentQuiver2"])){$this->equipmentQuiver2 = $array["equipmentQuiver2"];}
        if(isset($array["equipmentQuiver3"])){$this->equipmentQuiver3 = $array["equipmentQuiver3"];}
        if(isset($array["equipmentHelmet"])){$this->equipmentHelmet = $array["equipmentHelmet"];}
        if(isset($array["equipmentCape"])){$this->equipmentCape = $array["equipmentCape"];}
        if(isset($array["equipmentNecklace"])){$this->equipmentNecklace = $array["equipmentNecklace"];}
        if(isset($array["equipmentWeapon1"])){$this->equipmentWeapon1 = $array["equipmentWeapon1"];}
        if(isset($array["equipmentWeapon2"])){$this->equipmentWeapon2 = $array["equipmentWeapon2"];}
        if(isset($array["equipmentWeapon3"])){$this->equipmentWeapon3 = $array["equipmentWeapon3"];}
        if(isset($array["equipmentOffWeapon"])){$this->equipmentOffWeapon = $array["equipmentOffWeapon"];}
        if(isset($array["equipmentGloves"])){$this->equipmentGloves = $array["equipmentGloves"];}
        if(isset($array["equipmentArmor"])){$this->equipmentArmor = $array["equipmentArmor"];}
        if(isset($array["equipmentObject"])){$this->equipmentObject = $array["equipmentObject"];}
        if(isset($array["equipmentBelt"])){$this->equipmentBelt = $array["equipmentBelt"];}
        if(isset($array["equipmentBoots"])){$this->equipmentBoots = $array["equipmentBoots"];}
        if(isset($array["equipmentRing1"])){$this->equipmentRing1 = $array["equipmentRing1"];}
        if(isset($array["equipmentRing2"])){$this->equipmentRing2 = $array["equipmentRing2"];}
    
                
    }

    public static function getSQLAdd() {
        return "INSERT INTO `" . self::tableName . "` (`id`, `mail`, `password`, `lastLogin`, `lastIp`, `token`, `secToken`, `active`, `gm`, `environmentId`, `lastChange`, `charname`, `race`, `class`, `background`, `alignment`, `level`, `exp`, `inspiration`, `proficiency`, `initiative`, `money`, `savingThrows`, `skills`, `bonusModifier`, `hp`, `ac`, `death`, `obj`, `diary`, `lastActivity`, `equipmentQuiver1`, `equipmentQuiver2`, `equipmentQuiver3`, `equipmentHelmet`, `equipmentCape`, `equipmentNecklace`, `equipmentWeapon1`, `equipmentWeapon2`, `equipmentWeapon3`, `equipmentOffWeapon`, `equipmentGloves`, `equipmentArmor`, `equipmentObject`, `equipmentBelt`, `equipmentBoots`, `equipmentRing1`, `equipmentRing2` )" . " VALUES " . " (NULL , :mail, :password, :lastLogin, :lastIp, :token, :secToken, :active, :gm, :environmentId, :lastChange, :charname, :race, :class, :background, :alignment, :level, :exp, :inspiration, :proficiency, :initiative, :money, :savingThrows, :skills, :bonusModifier, :hp, :ac, :death, :obj, :diary, :lastActivity, :equipmentQuiver1, :equipmentQuiver2, :equipmentQuiver3, :equipmentHelmet, :equipmentCape, :equipmentNecklace, :equipmentWeapon1, :equipmentWeapon2, :equipmentWeapon3, :equipmentOffWeapon, :equipmentGloves, :equipmentArmor, :equipmentObject, :equipmentBelt, :equipmentBoots, :equipmentRing1, :equipmentRing2 );";
    }

    public function bindSQLAdd(\PDOStatement &$stmt) {
        $stmt->bindParam(":mail", $this->mail);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":lastLogin", $this->lastLogin);
        $stmt->bindParam(":lastIp", $this->lastIp);
        $stmt->bindParam(":token", $this->token);
        $stmt->bindParam(":secToken", $this->secToken);
        $stmt->bindParam(":active", $this->active);
        $stmt->bindParam(":gm", $this->gm);
        $stmt->bindParam(":environmentId", $this->environmentId);
        $stmt->bindParam(":lastChange", $this->lastChange);
        $stmt->bindParam(":charname", $this->charname);
        $stmt->bindParam(":race", $this->race);
        $stmt->bindParam(":class", $this->class);
        $stmt->bindParam(":background", $this->background);
        $stmt->bindParam(":alignment", $this->alignment);
        $stmt->bindParam(":level", $this->level);
        $stmt->bindParam(":exp", $this->exp);
        $stmt->bindParam(":inspiration", $this->inspiration);
        $stmt->bindParam(":proficiency", $this->proficiency);
        $stmt->bindParam(":initiative", $this->initiative);
        $stmt->bindParam(":money", $this->money);
        $stmt->bindParam(":savingThrows", $this->savingThrows);
        $stmt->bindParam(":skills", $this->skills);
        $stmt->bindParam(":bonusModifier", $this->bonusModifier);
        $stmt->bindParam(":hp", $this->hp);
        $stmt->bindParam(":ac", $this->ac);
        $stmt->bindParam(":death", $this->death);
        $stmt->bindParam(":obj", $this->obj);
        $stmt->bindParam(":diary", $this->diary);
        $stmt->bindParam(":lastActivity", $this->lastActivity);
        $stmt->bindParam(":equipmentQuiver1", $this->equipmentQuiver1);
        $stmt->bindParam(":equipmentQuiver2", $this->equipmentQuiver2);
        $stmt->bindParam(":equipmentQuiver3", $this->equipmentQuiver3);
        $stmt->bindParam(":equipmentHelmet", $this->equipmentHelmet);
        $stmt->bindParam(":equipmentCape", $this->equipmentCape);
        $stmt->bindParam(":equipmentNecklace", $this->equipmentNecklace);
        $stmt->bindParam(":equipmentWeapon1", $this->equipmentWeapon1);
        $stmt->bindParam(":equipmentWeapon2", $this->equipmentWeapon2);
        $stmt->bindParam(":equipmentWeapon3", $this->equipmentWeapon3);
        $stmt->bindParam(":equipmentOffWeapon", $this->equipmentOffWeapon);
        $stmt->bindParam(":equipmentGloves", $this->equipmentGloves);
        $stmt->bindParam(":equipmentArmor", $this->equipmentArmor);
        $stmt->bindParam(":equipmentObject", $this->equipmentObject);
        $stmt->bindParam(":equipmentBelt", $this->equipmentBelt);
        $stmt->bindParam(":equipmentBoots", $this->equipmentBoots);
        $stmt->bindParam(":equipmentRing1", $this->equipmentRing1);
        $stmt->bindParam(":equipmentRing2", $this->equipmentRing2);
    }

    public static function getSQLEdit() {
        return "UPDATE `" . self::tableName . "` SET `mail` = :mail, `password` = :password, `lastLogin` = :lastLogin, `lastIp` = :lastIp, `token` = :token, `secToken` = :secToken, `active` = :active, `gm` = :gm, `environmentId` = :environmentId, `lastChange` = :lastChange, `charname` = :charname, `race` = :race, `class` = :class, `background` = :background, `alignment` = :alignment, `level` = :level, `exp` = :exp, `inspiration` = :inspiration, `proficiency` = :proficiency, `initiative` = :initiative, `money` = :money, `savingThrows` = :savingThrows, `skills` = :skills, `bonusModifier` = :bonusModifier, `hp` = :hp, `ac` = :ac, `death` = :death, `obj` = :obj, `diary` = :diary, `lastActivity` = :lastActivity, `equipmentQuiver1` = :equipmentQuiver1, `equipmentQuiver2` = :equipmentQuiver2, `equipmentQuiver3` = :equipmentQuiver3, `equipmentHelmet` = :equipmentHelmet, `equipmentCape` = :equipmentCape, `equipmentNecklace` = :equipmentNecklace, `equipmentWeapon1` = :equipmentWeapon1, `equipmentWeapon2` = :equipmentWeapon2, `equipmentWeapon3` = :equipmentWeapon3, `equipmentOffWeapon` = :equipmentOffWeapon, `equipmentGloves` = :equipmentGloves, `equipmentArmor` = :equipmentArmor, `equipmentObject` = :equipmentObject, `equipmentBelt` = :equipmentBelt, `equipmentBoots` = :equipmentBoots, `equipmentRing1` = :equipmentRing1, `equipmentRing2` = :equipmentRing2 " . " WHERE `id` = :id;"; 
    }

    public function bindSQLEdit(\PDOStatement &$stmt) {
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":mail", $this->mail);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":lastLogin", $this->lastLogin);
        $stmt->bindParam(":lastIp", $this->lastIp);
        $stmt->bindParam(":token", $this->token);
        $stmt->bindParam(":secToken", $this->secToken);
        $stmt->bindParam(":active", $this->active);
        $stmt->bindParam(":gm", $this->gm);
        $stmt->bindParam(":environmentId", $this->environmentId);
        $stmt->bindParam(":lastChange", $this->lastChange);
        $stmt->bindParam(":charname", $this->charname);
        $stmt->bindParam(":race", $this->race);
        $stmt->bindParam(":class", $this->class);
        $stmt->bindParam(":background", $this->background);
        $stmt->bindParam(":alignment", $this->alignment);
        $stmt->bindParam(":level", $this->level);
        $stmt->bindParam(":exp", $this->exp);
        $stmt->bindParam(":inspiration", $this->inspiration);
        $stmt->bindParam(":proficiency", $this->proficiency);
        $stmt->bindParam(":initiative", $this->initiative);
        $stmt->bindParam(":money", $this->money);
        $stmt->bindParam(":savingThrows", $this->savingThrows);
        $stmt->bindParam(":skills", $this->skills);
        $stmt->bindParam(":bonusModifier", $this->bonusModifier);
        $stmt->bindParam(":hp", $this->hp);
        $stmt->bindParam(":ac", $this->ac);
        $stmt->bindParam(":death", $this->death);
        $stmt->bindParam(":obj", $this->obj);
        $stmt->bindParam(":diary", $this->diary);
        $stmt->bindParam(":lastActivity", $this->lastActivity);
        $stmt->bindParam(":equipmentQuiver1", $this->equipmentQuiver1);
        $stmt->bindParam(":equipmentQuiver2", $this->equipmentQuiver2);
        $stmt->bindParam(":equipmentQuiver3", $this->equipmentQuiver3);
        $stmt->bindParam(":equipmentHelmet", $this->equipmentHelmet);
        $stmt->bindParam(":equipmentCape", $this->equipmentCape);
        $stmt->bindParam(":equipmentNecklace", $this->equipmentNecklace);
        $stmt->bindParam(":equipmentWeapon1", $this->equipmentWeapon1);
        $stmt->bindParam(":equipmentWeapon2", $this->equipmentWeapon2);
        $stmt->bindParam(":equipmentWeapon3", $this->equipmentWeapon3);
        $stmt->bindParam(":equipmentOffWeapon", $this->equipmentOffWeapon);
        $stmt->bindParam(":equipmentGloves", $this->equipmentGloves);
        $stmt->bindParam(":equipmentArmor", $this->equipmentArmor);
        $stmt->bindParam(":equipmentObject", $this->equipmentObject);
        $stmt->bindParam(":equipmentBelt", $this->equipmentBelt);
        $stmt->bindParam(":equipmentBoots", $this->equipmentBoots);
        $stmt->bindParam(":equipmentRing1", $this->equipmentRing1);
        $stmt->bindParam(":equipmentRing2", $this->equipmentRing2);
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
        "lastLogin" => $this->lastLogin, 
        "lastIp" => $this->lastIp, 
        "token" => $this->token, 
        "secToken" => $this->secToken, 
        "active" => $this->active, 
        "gm" => $this->gm, 
        "environmentId" => $this->environmentId, 
        "lastChange" => $this->lastChange, 
        "charname" => $this->charname, 
        "race" => $this->race, 
        "class" => $this->class, 
        "background" => $this->background, 
        "alignment" => $this->alignment, 
        "level" => $this->level, 
        "exp" => $this->exp, 
        "inspiration" => $this->inspiration, 
        "proficiency" => $this->proficiency, 
        "initiative" => $this->initiative, 
        "money" => $this->money, 
        "savingThrows" => $this->savingThrows, 
        "skills" => $this->skills, 
        "bonusModifier" => $this->bonusModifier, 
        "hp" => $this->hp, 
        "ac" => $this->ac, 
        "death" => $this->death, 
        "obj" => $this->obj, 
        "diary" => $this->diary, 
        "lastActivity" => $this->lastActivity, 
        "hpMax" => $this->hpMax, 
        "hpCurrent" => $this->hpCurrent, 
        "hpTemporary" => $this->hpTemporary, 
        "deathSucces " => $this->deathSucces , 
        "deathFail" => $this->deathFail, 
        "myRace" => $this->myRace, 
        "myClass" => $this->myClass, 
        "myBackground" => $this->myBackground, 
        "myAlignment" => $this->myAlignment, 
        "myModifier" => $this->myModifier, 
        "strength" => $this->strength, 
        "dexterity" => $this->dexterity, 
        "constitution" => $this->constitution, 
        "intelligence" => $this->intelligence, 
        "wisdom" => $this->wisdom, 
        "charisma" => $this->charisma, 
        "bonusStrength" => $this->bonusStrength, 
        "bonusDexterity" => $this->bonusDexterity, 
        "bonusConstitution" => $this->bonusConstitution, 
        "bonusIntelligence" => $this->bonusIntelligence, 
        "bonusWisdom" => $this->bonusWisdom, 
        "bonusCharisma" => $this->bonusCharisma, 
        "modStrength" => $this->modStrength, 
        "modDexterity" => $this->modDexterity, 
        "modConstitution" => $this->modConstitution, 
        "modIntelligence" => $this->modIntelligence, 
        "modWisdom" => $this->modWisdom, 
        "modCharisma" => $this->modCharisma, 
        "bonusModStrength" => $this->bonusModStrength, 
        "bonusModDexterity" => $this->bonusModDexterity, 
        "bonusModConstitution" => $this->bonusModConstitution, 
        "bonusModIntelligence" => $this->bonusModIntelligence, 
        "bonusModWisdom" => $this->bonusModWisdom, 
        "bonusModCharisma" => $this->bonusModCharisma, 
        "bonusAcrobatics" => $this->bonusAcrobatics, 
        "bonusAnimalHandling" => $this->bonusAnimalHandling, 
        "bonusArcana" => $this->bonusArcana, 
        "bonusAthletics" => $this->bonusAthletics, 
        "bonusDeception" => $this->bonusDeception, 
        "bonusHistory" => $this->bonusHistory, 
        "bonusInsight" => $this->bonusInsight, 
        "bonusIntimidation" => $this->bonusIntimidation, 
        "bonusInvestigation" => $this->bonusInvestigation, 
        "bonusMedicine" => $this->bonusMedicine, 
        "bonusNature" => $this->bonusNature, 
        "bonusPerception" => $this->bonusPerception, 
        "bonusPerformance" => $this->bonusPerformance, 
        "bonusPersuasion" => $this->bonusPersuasion, 
        "bonusReligion" => $this->bonusReligion, 
        "bonusSleightOfHand" => $this->bonusSleightOfHand, 
        "bonusStealth" => $this->bonusStealth, 
        "bonusSurvival" => $this->bonusSurvival, 
        "proficiencyStrength" => $this->proficiencyStrength, 
        "proficiencyDexterity" => $this->proficiencyDexterity, 
        "proficiencyConstitution" => $this->proficiencyConstitution, 
        "proficiencyIntelligence" => $this->proficiencyIntelligence, 
        "proficiencyWisdom" => $this->proficiencyWisdom, 
        "proficiencyCharisma" => $this->proficiencyCharisma, 
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
        "moneyCopper" => $this->moneyCopper, 
        "moneySilver" => $this->moneySilver, 
        "moneyElectrum" => $this->moneyElectrum, 
        "moneyGold" => $this->moneyGold, 
        "moneyPlatinum" => $this->moneyPlatinum, 
        "equipmentQuiver1" => $this->equipmentQuiver1, 
        "equipmentQuiver2" => $this->equipmentQuiver2, 
        "equipmentQuiver3" => $this->equipmentQuiver3, 
        "equipmentHelmet" => $this->equipmentHelmet, 
        "equipmentCape" => $this->equipmentCape, 
        "equipmentNecklace" => $this->equipmentNecklace, 
        "equipmentWeapon1" => $this->equipmentWeapon1, 
        "equipmentWeapon2" => $this->equipmentWeapon2, 
        "equipmentWeapon3" => $this->equipmentWeapon3, 
        "equipmentOffWeapon" => $this->equipmentOffWeapon, 
        "equipmentGloves" => $this->equipmentGloves, 
        "equipmentArmor" => $this->equipmentArmor, 
        "equipmentObject" => $this->equipmentObject, 
        "equipmentBelt" => $this->equipmentBelt, 
        "equipmentBoots" => $this->equipmentBoots, 
        "equipmentRing1" => $this->equipmentRing1, 
        "equipmentRing2" => $this->equipmentRing2, 
        );
    }

    public function setFromSqlRow(&$rec) {
        $this->id = $rec["id"];
        $this->mail =  $rec["mail"];
        $this->password =  $rec["password"];
        $this->lastLogin =  $rec["lastLogin"];
        $this->lastIp =  $rec["lastIp"];
        $this->token =  $rec["token"];
        $this->secToken =  $rec["secToken"];
        $this->active =  $rec["active"];
        $this->gm =  $rec["gm"];
        $this->environmentId =  $rec["environmentId"];
        $this->lastChange =  $rec["lastChange"];
        $this->charname =  $rec["charname"];
        $this->race =  $rec["race"];
        $this->class =  $rec["class"];
        $this->background =  $rec["background"];
        $this->alignment =  $rec["alignment"];
        $this->level =  $rec["level"];
        $this->exp =  $rec["exp"];
        $this->inspiration =  $rec["inspiration"];
        $this->proficiency =  $rec["proficiency"];
        $this->initiative =  $rec["initiative"];
        $this->money =  $rec["money"];
        $this->savingThrows =  $rec["savingThrows"];
        $this->skills =  $rec["skills"];
        $this->bonusModifier =  $rec["bonusModifier"];
        $this->hp =  $rec["hp"];
        $this->ac =  $rec["ac"];
        $this->death =  $rec["death"];
        $this->obj =  $rec["obj"];
        $this->diary =  $rec["diary"];
        $this->lastActivity =  $rec["lastActivity"];
        $this->equipmentQuiver1 =  $rec["equipmentQuiver1"];
        $this->equipmentQuiver2 =  $rec["equipmentQuiver2"];
        $this->equipmentQuiver3 =  $rec["equipmentQuiver3"];
        $this->equipmentHelmet =  $rec["equipmentHelmet"];
        $this->equipmentCape =  $rec["equipmentCape"];
        $this->equipmentNecklace =  $rec["equipmentNecklace"];
        $this->equipmentWeapon1 =  $rec["equipmentWeapon1"];
        $this->equipmentWeapon2 =  $rec["equipmentWeapon2"];
        $this->equipmentWeapon3 =  $rec["equipmentWeapon3"];
        $this->equipmentOffWeapon =  $rec["equipmentOffWeapon"];
        $this->equipmentGloves =  $rec["equipmentGloves"];
        $this->equipmentArmor =  $rec["equipmentArmor"];
        $this->equipmentObject =  $rec["equipmentObject"];
        $this->equipmentBelt =  $rec["equipmentBelt"];
        $this->equipmentBoots =  $rec["equipmentBoots"];
        $this->equipmentRing1 =  $rec["equipmentRing1"];
        $this->equipmentRing2 =  $rec["equipmentRing2"];
    }

}

?>