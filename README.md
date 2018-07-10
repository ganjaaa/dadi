# Dungeons & Dragons UI

## Vorwort

Hier ein neues Repo mit neuer Struktur. Objecte werden via XML definiert und erzeugen automatische Standard Funktionen, Formulare etc.

## Magic
Irgendwann sollte man mal einen Installations-Routine schreiben. 

## Installation

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

Nodejs Server:
node_server/server.js als nohub dienst
node_server/ssl -> Zertifikate korrigieren
```bash
cp _config.default.php _config.php
```
_config.php bearbeiten
node_server/server.js bearbeiten



## DebugZugänge
#### DM
    Username: dm@wasmitleder.de
    Password: superGm 

#### User
    Username: felix@wasmitleder.de
    Password: superGm

    Username: kira@wasmitleder.de
    Password: superGm

    Username: imara@wasmitleder.de
    Password: superGm

## String Modifier
### Auf bau 
 [+ - =][integer][MOD]
z.B.
* +2int
*=5dex

### Berechnung 

Grundwert = WERT + WertBonus
Modifier = ModifierAusGrundWert + Modifier Bonus

Beispiel
Für 20 Stärke
=18str;-1mstr

20 =18str => 18 Stärke
+4 -1mstr => +3 modifier
Also Hat der Character 18 STR aber einen Str Modifier von nur +3 anstelle von 20 STR und einen Modifier +5

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

## Objekte

Sind unter ./Setup/xml/ definiert.

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
Liste aller {OBJECT}
### GET: /v2/gm/{OBJECT}/{id}
Infos zu {OBJECT}
### GET: /v2/gm/{OBJECT}/{field}/{search}
Suche innerhalb aller {OBJECT} wo {search} in {field} ist
### POST: /v2/gm/{OBJECT}
Bearbeiten von {OBJECT}
### POST: /v2/gm/{OBJECT}/{id}
Löschen von {OBJECT} mit {id}
### GET: /v2/random
Holen einer Zufallszahl
### GET: /v2/random/{id}
Holen einer Zufallszahl bis max {id}
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
