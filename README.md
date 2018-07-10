# Hier entsteht Oh My Dadi
# Oh My Dungeons and Dragons Interface
# Dungeons & Dragons UI

## Welcome

Good day adventurer. Welcome to this mighty repository for the DADI (Dungeons and Dragons interface) software.
At this very moment we are working hard on issues, features and enhancements to ensure that none of you fine people out there has to play on the corpses of dead trees.

## Installation

Currently, we are missing a database installer. We build one, but SOMEONE rolled a one on release so... yea.

```bash
$ git clone https://github.com/ganjaaa/DungeonsAndDragons.git /some/dir
$ cd /some/dir
$ cp _config.default.php _config.php
$ vi _config.php
$ composer install
$ cd ./Setup
$ php ./install.php
$ mysql -uUSERNAME -p DATENBANK < Setup/sql/*.sql
```

Update the SALT in lib/Helper/CryptoHelper.php.

## String Modifier
### Overview
 [+ - =][integer][MOD]
z.B.
* +2int
*=5dex

### Calculation

Basevalue = Value + ValueBonus
Modifier = ModifierFromBase + Modifier Bonus

Example:
For 20 Strength
=18str;-1mstr

20 =18str => 18 Strength
+4 -1mstr => +3 modifier
So the Character has 18 STR but a modifier of only +3 instead of 20 STR and a modifier of +5

### Modifier
```bash
maxhp = Max HP
init = Initiative
insp = Inspiration
ac = Armor Class
prof = Proficiency
speed = Geschwindigkeit

st = Saving Throws

matk = Melee ATK
mdmg = Melee Dmg
ratk = Ranged ATK
rdmg = Ranged Dmg
satk = Spell ATK
sdmg = Spell Dmg
sdc = Spell DC
watk = Weapon ATK
wdmg = Weapon Dmg

str = Strength
dex = Dexterity
con = Constitution
int = Intelligence
wis = Wisdom
cha = Charisma

mstr = Strength Modifier
mdex = Dexterity Modifier
mcon = Constitution Modifier
mint = Intelligence Modifier
mwis = Wisdom Modifier
mcha = Charisma Modifier

acro = Acrobatics
anim = AnimalHandling
arca = Arcana
athl = Athletics
dece = Deception
hist = History
insi = Insight
inti = Intimidation
inve = Investigation
medi = Medicine
natu = Nature
perc = Perception
perf = Performance
pers = Persuasion
reli = Religion
slei = SleightOfHand
stea = Stealth
surv = Survival
```

## Objects

Objects are stored in ./Setup/xml/

* Account
* Character
* Environment
* Inventory
* Item
* Spell
* Spellbook

## API
### POST: /v2/auth/login
    username
    password

### GET: /v2/gm/{OBJECT}
List all {OBJECT}
### GET: /v2/gm/{OBJECT}/{id}
Information about {OBJECT}
### GET: /v2/gm/{OBJECT}/{field}/{search}
Search in all {OBJECT} where {search} in {field}
### POST: /v2/gm/{OBJECT}
Change {OBJECT}
### POST: /v2/gm/{OBJECT}/{id}
Delete {OBJECT} with {id}
### GET: /v2/random
Get random number
### GET: /v2/random/{id}
Get random number to a maximum of {id}
### POST: /v2/command/item[/{id}]
ToDo: Doku
### POST: /v2/command/exp[/{id}]
ToDo: Doku
### POST: /v2/command/hp[/{id}]
ToDo: Doku
### POST: /v2/command/fullhp[/{id}]
ToDo: Doku
### POST: /v2/command/date/add/{id}
ToDo: Doku
### POST: /v2/command/date/sub/{id}
ToDo: Doku
### POST: /v2/command/time/add/{id}
ToDo: Doku
### POST: /v2/command/time/sub/{id}
ToDo: Doku

## Template Globale
* isLogin
* isGm
* accountId
