<?php

namespace DND\Core;

class Rules {

    const RACE_AARAKOCRA = 0;
    const RACE_AASIMAR = 1;
    const RACE_DRAGONBORN = 2;
    const RACE_DWARF_DUERGAR_ = 3;
    const RACE_DWARF_HILL_ = 4;
    const RACE_DWARF_MOUNTAIN_ = 5;
    const RACE_ELF_DROW_ = 6;
    const RACE_ELF_ELADRIN_ = 7;
    const RACE_ELF_HIGH_ = 8;
    const RACE_ELF_WOOD_ = 9;
    const RACE_GENASI_AIR_ = 10;
    const RACE_GENASI_EARTH_ = 11;
    const RACE_GENASI_FIRE_ = 12;
    const RACE_GENASI_WATER_ = 13;
    const RACE_GNOME_DEEP_ = 14;
    const RACE_GNOME_FOREST_ = 15;
    const RACE_GNOME_ROCK_ = 16;
    const RACE_GOLIATH = 17;
    const RACE_HALF_ELF = 18;
    const RACE_HALF_ELF_AQUATIC_ELF_DESCENT_ = 19;
    const RACE_HALF_ELF_DROW_DESCENT_ = 20;
    const RACE_HALF_ELF_MOON_ELF_OR_SUN_ELF_DESCENT_ = 21;
    const RACE_HALF_ELF_WOOD_ELF_DESCENT_ = 22;
    const RACE_HALF_ORC = 23;
    const RACE_HALFLING_GHOSTWISE_ = 24;
    const RACE_HALFLING_LIGHTFOOT_ = 25;
    const RACE_HALFLING_STOUT_ = 26;
    const RACE_HUMAN = 27;
    const RACE_HUMAN_VARIANT_ = 28;
    const RACE_SHIFTER_RAZORCLAW_ = 29;
    const RACE_SHIFTER_WILDHUNT_ = 30;
    const RACE_TIEFLING_INFERNAL_ = 31;
    const CLASS_BARBARIAN = 0;
    const CLASS_BARD = 1;
    const CLASS_CLERIC = 2;
    const CLASS_DRUID = 3;
    const CLASS_FIGHTER = 4;
    const CLASS_MONK = 5;
    const CLASS_MYSTIC_UA_ = 6;
    const CLASS_PALADIN = 7;
    const CLASS_RANGER = 8;
    const CLASS_RANGER_VARIANT = 9;
    const CLASS_ROGUE = 10;
    const CLASS_SORCERER = 11;
    const CLASS_WARLOCK = 12;
    const CLASS_WIZARD = 13;
    const CLASS_BLOOD_HUNTER = 14;
    const CLASS_BARBARIAN_BERSERK = 15;
    const CLASS_BARBARIAN_TOTEM_WARRIOR = 16;
    const CLASS_BARBARIAN_BATTLERAGER = 17;

    public static function getLists() {

        $result = array(
            'class' => [
                0 => ["const" => "CLASS_BARBARIAN", "id" => 0, "name" => "Barbarian"],
                1 => ["const" => "CLASS_BARD", "id" => 1, "name" => "Bard"],
                2 => ["const" => "CLASS_CLERIC", "id" => 2, "name" => "Cleric"],
                3 => ["const" => "CLASS_DRUID", "id" => 3, "name" => "Druid"],
                4 => ["const" => "CLASS_FIGHTER", "id" => 4, "name" => "Fighter"],
                5 => ["const" => "CLASS_MONK", "id" => 5, "name" => "Monk"],
                6 => ["const" => "CLASS_MYSTIC_UA_", "id" => 6, "name" => "Mystic (UA)"],
                7 => ["const" => "CLASS_PALADIN", "id" => 7, "name" => "Paladin"],
                8 => ["const" => "CLASS_RANGER", "id" => 8, "name" => "Ranger"],
                9 => ["const" => "CLASS_RANGER_VARIANT_", "id" => 9, "name" => "Ranger (Variant)"],
                10 => ["const" => "CLASS_ROGUE", "id" => 10, "name" => "Rogue"],
                11 => ["const" => "CLASS_SORCERER", "id" => 11, "name" => "Sorcerer"],
                12 => ["const" => "CLASS_WARLOCK", "id" => 12, "name" => "Warlock"],
                13 => ["const" => "CLASS_WIZARD", "id" => 13, "name" => "Wizard"],
                14 => ["const" => "CLASS_BLOOD_HUNTER", "id" => 14, "name" => "Blood Hunter"],
            ],
            'race' => [
                0 => ["const" => "RACE_AARAKOCRA", "id" => 0, "name" => "Aarakocra"],
                1 => ["const" => "RACE_AASIMAR", "id" => 1, "name" => "Aasimar"],
                2 => ["const" => "RACE_DRAGONBORN", "id" => 2, "name" => "Dragonborn"],
                3 => ["const" => "RACE_DWARF_DUERGAR_", "id" => 3, "name" => "Dwarf (Duergar)"],
                4 => ["const" => "RACE_DWARF_HILL_", "id" => 4, "name" => "Dwarf (Hill)"],
                5 => ["const" => "RACE_DWARF_MOUNTAIN_", "id" => 5, "name" => "Dwarf (Mountain)"],
                6 => ["const" => "RACE_ELF_DROW_", "id" => 6, "name" => "Elf (Drow)"],
                7 => ["const" => "RACE_ELF_ELADRIN_", "id" => 7, "name" => "Elf (Eladrin)"],
                8 => ["const" => "RACE_ELF_HIGH_", "id" => 8, "name" => "Elf (High)"],
                9 => ["const" => "RACE_ELF_WOOD_", "id" => 9, "name" => "Elf (Wood)"],
                10 => ["const" => "RACE_GENASI_AIR_", "id" => 10, "name" => "Genasi (Air)"],
                11 => ["const" => "RACE_GENASI_EARTH_", "id" => 11, "name" => "Genasi (Earth)"],
                12 => ["const" => "RACE_GENASI_FIRE_", "id" => 12, "name" => "Genasi (Fire)"],
                13 => ["const" => "RACE_GENASI_WATER_", "id" => 13, "name" => "Genasi (Water)"],
                14 => ["const" => "RACE_GNOME_DEEP_", "id" => 14, "name" => "Gnome (Deep)"],
                15 => ["const" => "RACE_GNOME_FOREST_", "id" => 15, "name" => "Gnome (Forest)"],
                16 => ["const" => "RACE_GNOME_ROCK_", "id" => 16, "name" => "Gnome (Rock)"],
                17 => ["const" => "RACE_GOLIATH", "id" => 17, "name" => "Goliath"],
                18 => ["const" => "RACE_HALF_ELF", "id" => 18, "name" => "Half-Elf"],
                19 => ["const" => "RACE_HALF_ELF_AQUATIC_ELF_DESCENT_", "id" => 19, "name" => "Half-Elf (Aquatic Elf Descent)"],
                20 => ["const" => "RACE_HALF_ELF_DROW_DESCENT_", "id" => 20, "name" => "Half-Elf (Drow Descent)"],
                21 => ["const" => "RACE_HALF_ELF_MOON_ELF_OR_SUN_ELF_DESCENT_", "id" => 21, "name" => "Half-Elf (Moon Elf or Sun Elf Descent)"],
                22 => ["const" => "RACE_HALF_ELF_WOOD_ELF_DESCENT_", "id" => 22, "name" => "Half-Elf (Wood Elf Descent)"],
                23 => ["const" => "RACE_HALF_ORC", "id" => 23, "name" => "Half-Orc"],
                24 => ["const" => "RACE_HALFLING_GHOSTWISE_", "id" => 24, "name" => "Halfling (Ghostwise)"],
                25 => ["const" => "RACE_HALFLING_LIGHTFOOT_", "id" => 25, "name" => "Halfling (Lightfoot)"],
                26 => ["const" => "RACE_HALFLING_STOUT_", "id" => 26, "name" => "Halfling (Stout)"],
                27 => ["const" => "RACE_HUMAN", "id" => 27, "name" => "Human"],
                28 => ["const" => "RACE_HUMAN_VARIANT_", "id" => 28, "name" => "Human (Variant)"],
                29 => ["const" => "RACE_SHIFTER_RAZORCLAW_", "id" => 29, "name" => "Shifter (Razorclaw)"],
                30 => ["const" => "RACE_SHIFTER_WILDHUNT_", "id" => 30, "name" => "Shifter (Wildhunt)"],
                31 => ["const" => "RACE_TIEFLING_INFERNAL_", "id" => 31, "name" => "Tiefling (Infernal)"],
            ]
        );

        $result['background'] = [];
        foreach (self::getBackground() as $key => $val) {
            $result['background'][] = [
                'id' => $key,
                'name' => $val['name']
            ];
        }
        $result['aligment'] = [];
        foreach (self::getAligment() as $key => $val) {
            $result['aligment'][] = [
                'id' => $key,
                'name' => $val
            ];
        }

        return $result;
    }

    public static function getBonusArray($str) {
        $matches = array(
        );
        $rlt = array(
            "speed" => 0,
            "proficiency" => 0
        );
    }

    public static function extractAbility($source, $name, &$orginal = NULL) {
        $setter = false;
        $result = 0;
        $suchmuster = '/(\+|\-|\=)(\d+)(.+)/';
        $source = str_replace(',', ';', $source);
        if (!is_array($source) && !empty($source))
            $source = explode(';', $source);
        if (is_array($source)) {
            foreach ($source as $word) {
                $treffer = [];
                preg_match($suchmuster, $word, $treffer);
                if (isset($treffer[3]) && $treffer[3] == $name) {
                    if ($treffer[1] == '+') {
                        $result += intval($treffer[2]);
                    }
                    if ($treffer[1] == '-') {
                        $result -= intval($treffer[2]);
                    }
                    if ($orginal !== NULL && $treffer[1] == '=') {
                        $orginal = intval($treffer[2]);
                        $setter = true;
                    }
                }
            }
            return ($setter) ? 0 : $result;
        }
        return 0;
    }

    public static function ApplyModifier() {
        
    }

    public static function getAbilityArray($abilityString, \DND\Objects\Character &$obj = NULL) {
        $d = explode(',', $abilityString);
        $rslt = [
            'strength' => 0,
            'dexterity' => 0,
            'constitution' => 0,
            'intelligence' => 0,
            'wisdom' => 0,
            'charisma' => 0,
            #--
            'rangeAtk' => 0,
            'rangeDmg' => 0,
            'meleeAtk' => 0,
            'meleeDmg' => 0,
            'spellAtk' => 0,
            'spellDc' => 0,
            'atk' => 0,
            'dmg' => 0,
            'ac' => 0,
            'savingThrows' => 0,
            'proficiency' => 0,
            'passivWisdom' => 0,
            'spellDc' => 0,
            'spellAttack' => 0
        ];
        foreach ($d as $zeichenkette) {
            $suchmuster = '/(\+|\-)(\d+)(.+)/';
            preg_match($suchmuster, $zeichenkette, $treffer);
            switch ($treffer[3]) {
                case 'str':
                    if ($treffer[1] == '+')
                        $rslt['strength'] += $treffer[2];
                    if ($treffer[1] == '-')
                        $rslt['strength'] -= $treffer[2];
                    if ($treffer[1] == '=' && $obj != NULL) {
                        $obj->setStrength($treffer[2]);
                    }
                    break;
                case 'dex':
                    if ($treffer[1] == '+')
                        $rslt['dexterity'] += $treffer[2];
                    if ($treffer[1] == '-')
                        $rslt['dexterity'] -= $treffer[2];
                    if ($treffer[1] == '=' && $obj != NULL) {
                        $obj->setDexterity($treffer[2]);
                    }
                    break;
                case 'con':
                    if ($treffer[1] == '+')
                        $rslt['constitution'] += $treffer[2];
                    if ($treffer[1] == '-')
                        $rslt['constitution'] -= $treffer[2];
                    if ($treffer[1] == '=' && $obj != NULL) {
                        $obj->setConstitution($treffer[2]);
                    }
                    break;
                case 'int':
                    if ($treffer[1] == '+')
                        $rslt['intelligence'] += $treffer[2];
                    if ($treffer[1] == '-')
                        $rslt['intelligence'] -= $treffer[2];
                    if ($treffer[1] == '=' && $obj != NULL) {
                        $obj->setIntelligence($treffer[2]);
                    }
                    break;
                case 'wis':
                    if ($treffer[1] == '+')
                        $rslt['wisdom'] += $treffer[2];
                    if ($treffer[1] == '-')
                        $rslt['wisdom'] -= $treffer[2];
                    if ($treffer[1] == '=' && $obj != NULL) {
                        $obj->setWisdom($treffer[2]);
                    }
                    break;
                case 'cha':
                    if ($treffer[1] == '+')
                        $rslt['charisma'] += $treffer[2];
                    if ($treffer[1] == '-')
                        $rslt['charisma'] -= $treffer[2];
                    if ($treffer[1] == '=' && $obj != NULL) {
                        $obj->setCharisma($treffer[2]);
                    }
                    break;
            }
        }

        return $rslt;
    }

    public static function getModifier($value) {
        if ($value >= 30)
            return 10;
        if ($value >= 28)
            return 9;
        if ($value >= 26)
            return 8;
        if ($value >= 24)
            return 7;
        if ($value >= 22)
            return 6;
        if ($value >= 20)
            return 5;
        if ($value >= 18)
            return 4;
        if ($value >= 16)
            return 3;
        if ($value >= 14)
            return 2;
        if ($value >= 12)
            return 1;
        if ($value >= 10)
            return 0;
        if ($value >= 8)
            return -1;
        if ($value >= 6)
            return -2;
        if ($value >= 4)
            return -3;
        if ($value >= 2)
            return -4;
        return -5;
    }

    public static function setAbilityString(\DND\Objects\Character $char, $string) {
        
    }

    public static function rollDice($eyes) {
        return random_int(1, $eyes);
    }

    public static function getClassAbilitys() {
        return array(
            0 => [
                1 => '=2Prof,',
                2 => '=2Prof',
                3 => '=2Prof',
                4 => '=2Prof',
                5 => '=2Prof',
                6 => '=2Prof',
                7 => '=2Prof',
                8 => '=2Prof',
                9 => '=2Prof',
            ]
        );
    }

    public static function getProficiency($level) {
        switch ($level) {
            case 0:
            case 1:
            case 2:
            case 3:
            case 4:
                return 2;
                break;
            case 5:
            case 6:
            case 7:
            case 8:
                return 3;
                break;
            case 9:
            case 10:
            case 11:
            case 12:
                return 4;
                break;
            case 13:
            case 14:
            case 15:
            case 16:
                return 5;
                break;
            default:
                return 6;
                break;
        }
    }

    public static function getLevelCap($level) {
        if ($level == 1)
            return (300);
        if ($level == 2)
            return ( 900);
        if ($level == 3)
            return (2700);
        if ($level == 4)
            return ( 6500);
        if ($level == 5)
            return ( 1400);
        if ($level == 6)
            return ( 2300);
        if ($level == 7)
            return ( 3400);
        if ($level == 8)
            return ( 4800);
        if ($level == 9)
            return ( 6400);
        if ($level == 10)
            return ( 8500);
        if ($level == 11)
            return (100000);
        if ($level == 12)
            return ( 120000);
        if ($level == 13)
            return ( 140000);
        if ($level == 14)
            return ( 165000);
        if ($level == 15)
            return ( 195000);
        if ($level == 16)
            return ( 225000);
        if ($level == 17)
            return ( 265000);
        if ($level == 18)
            return ( 305000);
        return ( 355000);
    }

    public static function gotLevelup($level, $exp) {
        if ($exp > self::getLevelCap($level)) {
            return 1;
        }
        return 0;
    }

    public static function getAligment($id = null) {
        $a = array(
            0 => 'Lawful good',
            1 => 'Neutral good',
            2 => 'Chaotic good',
            3 => 'Lawful neutral',
            4 => 'Neutral neutral',
            5 => 'Chaotic neutral',
            6 => 'Lawful evil',
            7 => 'Neutral evil',
            8 => 'Chaotic evil'
        );
        
        if($id !== null){
            return $a[$id];
        }
        return $a;
    }

}
