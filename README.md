# Oh My Dungeons and Dragons Interface

## Welcome

Good day adventurer. Welcome to this mighty repository for the DADI (Dungeons and Dragons interface) software.
At this very moment we are working hard on issues, features and enhancements to ensure that none of you fine people out there has to play on the corpse of dead trees.

## Installation
```bash
$ git clone https://github.com/ganjaaa/dadi.git --branch=docker /srv/dadi
$ cd /srv/dadi
$ docker-compose up -d --build
$ docker exec -it dadi_dadi_1 php setup/install.php
```

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

For Update run:
````bash
$ php ./Setup/install.php
```

## API
ToDo: write Dokumentation
