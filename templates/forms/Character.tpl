<div id="Character_addForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">User anlegen</div>
    <div class="content">
        <form class="ui form">
            <input id="Character_addForm_id" name="id" type="hidden" value="">
            <div class="two fields">
                <div class="field">
                    <label>Aktiv</label>
                    <select id="Character_addForm_active" name="active">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Account</label>
                    <select id="Character_addForm_accountId" name="accountId">                    {$listAccount|default:"<option value=''>-</option>"}                    </select>                </div>
            </div>
                <div class="field">
                    <label>Character Name</label>
                    <input type="text" name="charname"  id="Character_addForm_charname" placeholder="Ronnald" >
                </div>
                <div class="field">
                    <label>Umwelt</label>
                    <select id="Character_addForm_environmentId" name="environmentId">                    {$listEnvironment|default:"<option value=''>-</option>"}                    </select>                </div>
            <div class="two fields">
                <div class="field">
                    <label>Hintergrund</label>
                    <select id="Character_addForm_backgroundId" name="backgroundId">                    {$listBackground|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Gesinnung</label>
                    <select id="Character_addForm_alignment" name="alignment">                        <option value="0">Lawful good</option>                        <option value="1">Neutral good</option>                        <option value="2">Chaotic good</option>                        <option value="3">Lawful neutral</option>                        <option value="4">Neutral neutral</option>                        <option value="5">Chaotic neutral</option>                        <option value="6">Lawful evil</option>                        <option value="7">Neutral evil</option>                        <option value="8">Chaotic evil</option>                    </select>                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>Rasse</label>
                    <select id="Character_addForm_raceId" name="raceId">                    {$listRace|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Erfahrung</label>
                    <input type="text" name="exp"  id="Character_addForm_exp" placeholder="0" >
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>1. Klasse</label>
                    <select id="Character_addForm_class1Id" name="class1Id">                    {$listClass|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Level</label>
                    <input type="text" name="class1Level"  id="Character_addForm_class1Level" placeholder="0" >
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>2. Klasse</label>
                    <select id="Character_addForm_class2Id" name="class2Id">                    {$listClass|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Level</label>
                    <input type="text" name="class2Level"  id="Character_addForm_class2Level" placeholder="0" >
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>3. Klasse</label>
                    <select id="Character_addForm_class3Id" name="class3Id">                    {$listClass|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Level</label>
                    <input type="text" name="class3Level"  id="Character_addForm_class3Level" placeholder="0" >
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>4. Klasse</label>
                    <select id="Character_addForm_class4Id" name="class4Id">                    {$listClass|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Level</label>
                    <input type="text" name="class4Level"  id="Character_addForm_class4Level" placeholder="0" >
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>Inspiration</label>
                    <input type="text" name="inspiration"  id="Character_addForm_inspiration" placeholder="Ronnald" >
                </div>
                <div class="field">
                    <label>Initiative</label>
                    <input type="text" name="initiative"  id="Character_addForm_initiative" placeholder="Ronnald" >
                </div>
            </div>
            <div class="three fields">
                <div class="field">
                    <label>MAX HP</label>
                    <input type="text" name="hpMax"  id="Character_addForm_hpMax" placeholder="0" >
                </div>
                <div class="field">
                    <label>Current HP</label>
                    <input type="text" name="hpCurrent"  id="Character_addForm_hpCurrent" placeholder="0" >
                </div>
                <div class="field">
                    <label>Temp HP</label>
                    <input type="text" name="hpTemporary"  id="Character_addForm_hpTemporary" placeholder="0" >
                </div>
            </div>
            <div class="five fields">
                <div class="field">
                    <label>CP</label>
                    <input type="text" name="cp"  id="Character_addForm_cp" placeholder="0" >
                </div>
                <div class="field">
                    <label>SP</label>
                    <input type="text" name="sp"  id="Character_addForm_sp" placeholder="0" >
                </div>
                <div class="field">
                    <label>EP</label>
                    <input type="text" name="ep"  id="Character_addForm_ep" placeholder="0" >
                </div>
                <div class="field">
                    <label>GP</label>
                    <input type="text" name="gp"  id="Character_addForm_gp" placeholder="0" >
                </div>
                <div class="field">
                    <label>PP</label>
                    <input type="text" name="pp"  id="Character_addForm_pp" placeholder="0" >
                </div>
            </div>
            <div class="six fields">
                <div class="field">
                    <label>Str</label>
                    <input type="text" name="str"  id="Character_addForm_str" placeholder="0" >
                </div>
                <div class="field">
                    <label>Dex</label>
                    <input type="text" name="dex"  id="Character_addForm_dex" placeholder="0" >
                </div>
                <div class="field">
                    <label>Con</label>
                    <input type="text" name="con"  id="Character_addForm_con" placeholder="0" >
                </div>
                <div class="field">
                    <label>Int</label>
                    <input type="text" name="int"  id="Character_addForm_int" placeholder="0" >
                </div>
                <div class="field">
                    <label>Wis</label>
                    <input type="text" name="wis"  id="Character_addForm_wis" placeholder="0" >
                </div>
                <div class="field">
                    <label>Cha</label>
                    <input type="text" name="cha"  id="Character_addForm_cha" placeholder="0" >
                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Acrobatics</label>
                    <select id="Character_addForm_acrobatics" name="acrobatics">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>AnimalHandling</label>
                    <select id="Character_addForm_animalHandling" name="animalHandling">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Arcana</label>
                    <select id="Character_addForm_arcana" name="arcana">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Athletics</label>
                    <select id="Character_addForm_athletics" name="athletics">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Deception</label>
                    <select id="Character_addForm_deception" name="deception">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>History</label>
                    <select id="Character_addForm_history" name="history">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Insight</label>
                    <select id="Character_addForm_insight" name="insight">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Intimidation</label>
                    <select id="Character_addForm_intimidation" name="intimidation">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Investigation</label>
                    <select id="Character_addForm_investigation" name="investigation">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Medicine</label>
                    <select id="Character_addForm_medicine" name="medicine">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Nature</label>
                    <select id="Character_addForm_nature" name="nature">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Perception</label>
                    <select id="Character_addForm_perception" name="perception">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Performance</label>
                    <select id="Character_addForm_performance" name="performance">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Persuasion</label>
                    <select id="Character_addForm_persuasion" name="persuasion">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Religion</label>
                    <select id="Character_addForm_religion" name="religion">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>SleightOfHand</label>
                    <select id="Character_addForm_sleightOfHand" name="sleightOfHand">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>Stealth</label>
                    <select id="Character_addForm_stealth" name="stealth">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Survival</label>
                    <select id="Character_addForm_survival" name="survival">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
                <div class="field">
                    <label>bonusModifier</label>
                    <input type="text" name="bonusModifier"  id="Character_addForm_bonusModifier" placeholder="Ronnald" >
                </div>
            <div class="three fields">
                <div class="field">
                    <label>Quiver1</label>
                    <select id="Character_addForm_equipmentQuiver1" name="equipmentQuiver1">                    {$listQuiver|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Quiver2</label>
                    <select id="Character_addForm_equipmentQuiver2" name="equipmentQuiver2">                    {$listQuiver|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Quiver3</label>
                    <select id="Character_addForm_equipmentQuiver3" name="equipmentQuiver3">                    {$listQuiver|default:"<option value=''>-</option>"}                    </select>                </div>
            </div>
            <div class="three fields">
                <div class="field">
                    <label>Helmet</label>
                    <select id="Character_addForm_equipmentHelmet" name="equipmentHelmet">                    {$listHelmet|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Cape</label>
                    <select id="Character_addForm_equipmentCape" name="equipmentCape">                    {$listCape|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Necklace</label>
                    <select id="Character_addForm_equipmentNecklace" name="equipmentNecklace">                    {$listNecklace|default:"<option value=''>-</option>"}                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Weapon1</label>
                    <select id="Character_addForm_equipmentWeapon1" name="equipmentWeapon1">                    {$listWeapon|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Weapon2</label>
                    <select id="Character_addForm_equipmentWeapon2" name="equipmentWeapon2">                    {$listWeapon|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Weapon3</label>
                    <select id="Character_addForm_equipmentWeapon3" name="equipmentWeapon3">                    {$listWeapon|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Off-Weapon</label>
                    <select id="Character_addForm_equipmentOffWeapon" name="equipmentOffWeapon">                    {$listOffWeapon|default:"<option value=''>-</option>"}                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Gloves</label>
                    <select id="Character_addForm_equipmentGloves" name="equipmentGloves">                    {$listGloves|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Armor</label>
                    <select id="Character_addForm_equipmentArmor" name="equipmentArmor">                    {$listArmor|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Belt</label>
                    <select id="Character_addForm_equipmentBelt" name="equipmentBelt">                    {$listBelt|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Object</label>
                    <select id="Character_addForm_equipmentObject" name="equipmentObject">                    {$listObject|default:"<option value=''>-</option>"}                    </select>                </div>
            </div>
            <div class="three fields">
                <div class="field">
                    <label>Boots</label>
                    <select id="Character_addForm_equipmentBoots" name="equipmentBoots">                    {$listBoots|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Ring1</label>
                    <select id="Character_addForm_equipmentRing1" name="equipmentRing1">                    {$listRing|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Ring2</label>
                    <select id="Character_addForm_equipmentRing2" name="equipmentRing2">                    {$listRing|default:"<option value=''>-</option>"}                    </select>                </div>
            </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

<div id="Character_editForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">User bearbeiten</div>
    <div class="content">
        <form class="ui form">
            <input id="Character_editForm_id" name="id" type="hidden" value="">
            <div class="two fields">
                <div class="field">
                    <label>Aktiv</label>
                    <select id="Character_editForm_active" name="active">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Account</label>
                    <select id="Character_editForm_accountId" name="accountId">                    {$listAccount|default:"<option value=''>-</option>"}                    </select>                </div>
            </div>
                <div class="field">
                    <label>Character Name</label>
                    <input type="text" name="charname"  id="Character_editForm_charname" placeholder="Ronnald" >
                </div>
                <div class="field">
                    <label>Umwelt</label>
                    <select id="Character_editForm_environmentId" name="environmentId">                    {$listEnvironment|default:"<option value=''>-</option>"}                    </select>                </div>
            <div class="two fields">
                <div class="field">
                    <label>Hintergrund</label>
                    <select id="Character_editForm_backgroundId" name="backgroundId">                    {$listBackground|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Gesinnung</label>
                    <select id="Character_editForm_alignment" name="alignment">                        <option value="0">Lawful good</option>                        <option value="1">Neutral good</option>                        <option value="2">Chaotic good</option>                        <option value="3">Lawful neutral</option>                        <option value="4">Neutral neutral</option>                        <option value="5">Chaotic neutral</option>                        <option value="6">Lawful evil</option>                        <option value="7">Neutral evil</option>                        <option value="8">Chaotic evil</option>                    </select>                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>Rasse</label>
                    <select id="Character_editForm_raceId" name="raceId">                    {$listRace|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Erfahrung</label>
                    <input type="text" name="exp"  id="Character_editForm_exp" placeholder="0" >
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>1. Klasse</label>
                    <select id="Character_editForm_class1Id" name="class1Id">                    {$listClass|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Level</label>
                    <input type="text" name="class1Level"  id="Character_editForm_class1Level" placeholder="0" >
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>2. Klasse</label>
                    <select id="Character_editForm_class2Id" name="class2Id">                    {$listClass|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Level</label>
                    <input type="text" name="class2Level"  id="Character_editForm_class2Level" placeholder="0" >
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>3. Klasse</label>
                    <select id="Character_editForm_class3Id" name="class3Id">                    {$listClass|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Level</label>
                    <input type="text" name="class3Level"  id="Character_editForm_class3Level" placeholder="0" >
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>4. Klasse</label>
                    <select id="Character_editForm_class4Id" name="class4Id">                    {$listClass|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Level</label>
                    <input type="text" name="class4Level"  id="Character_editForm_class4Level" placeholder="0" >
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>Inspiration</label>
                    <input type="text" name="inspiration"  id="Character_editForm_inspiration" placeholder="Ronnald" >
                </div>
                <div class="field">
                    <label>Initiative</label>
                    <input type="text" name="initiative"  id="Character_editForm_initiative" placeholder="Ronnald" >
                </div>
            </div>
            <div class="three fields">
                <div class="field">
                    <label>MAX HP</label>
                    <input type="text" name="hpMax"  id="Character_editForm_hpMax" placeholder="0" >
                </div>
                <div class="field">
                    <label>Current HP</label>
                    <input type="text" name="hpCurrent"  id="Character_editForm_hpCurrent" placeholder="0" >
                </div>
                <div class="field">
                    <label>Temp HP</label>
                    <input type="text" name="hpTemporary"  id="Character_editForm_hpTemporary" placeholder="0" >
                </div>
            </div>
            <div class="five fields">
                <div class="field">
                    <label>CP</label>
                    <input type="text" name="cp"  id="Character_editForm_cp" placeholder="0" >
                </div>
                <div class="field">
                    <label>SP</label>
                    <input type="text" name="sp"  id="Character_editForm_sp" placeholder="0" >
                </div>
                <div class="field">
                    <label>EP</label>
                    <input type="text" name="ep"  id="Character_editForm_ep" placeholder="0" >
                </div>
                <div class="field">
                    <label>GP</label>
                    <input type="text" name="gp"  id="Character_editForm_gp" placeholder="0" >
                </div>
                <div class="field">
                    <label>PP</label>
                    <input type="text" name="pp"  id="Character_editForm_pp" placeholder="0" >
                </div>
            </div>
            <div class="six fields">
                <div class="field">
                    <label>Str</label>
                    <input type="text" name="str"  id="Character_editForm_str" placeholder="0" >
                </div>
                <div class="field">
                    <label>Dex</label>
                    <input type="text" name="dex"  id="Character_editForm_dex" placeholder="0" >
                </div>
                <div class="field">
                    <label>Con</label>
                    <input type="text" name="con"  id="Character_editForm_con" placeholder="0" >
                </div>
                <div class="field">
                    <label>Int</label>
                    <input type="text" name="int"  id="Character_editForm_int" placeholder="0" >
                </div>
                <div class="field">
                    <label>Wis</label>
                    <input type="text" name="wis"  id="Character_editForm_wis" placeholder="0" >
                </div>
                <div class="field">
                    <label>Cha</label>
                    <input type="text" name="cha"  id="Character_editForm_cha" placeholder="0" >
                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Acrobatics</label>
                    <select id="Character_editForm_acrobatics" name="acrobatics">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>AnimalHandling</label>
                    <select id="Character_editForm_animalHandling" name="animalHandling">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Arcana</label>
                    <select id="Character_editForm_arcana" name="arcana">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Athletics</label>
                    <select id="Character_editForm_athletics" name="athletics">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Deception</label>
                    <select id="Character_editForm_deception" name="deception">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>History</label>
                    <select id="Character_editForm_history" name="history">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Insight</label>
                    <select id="Character_editForm_insight" name="insight">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Intimidation</label>
                    <select id="Character_editForm_intimidation" name="intimidation">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Investigation</label>
                    <select id="Character_editForm_investigation" name="investigation">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Medicine</label>
                    <select id="Character_editForm_medicine" name="medicine">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Nature</label>
                    <select id="Character_editForm_nature" name="nature">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Perception</label>
                    <select id="Character_editForm_perception" name="perception">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Performance</label>
                    <select id="Character_editForm_performance" name="performance">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Persuasion</label>
                    <select id="Character_editForm_persuasion" name="persuasion">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Religion</label>
                    <select id="Character_editForm_religion" name="religion">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>SleightOfHand</label>
                    <select id="Character_editForm_sleightOfHand" name="sleightOfHand">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>Stealth</label>
                    <select id="Character_editForm_stealth" name="stealth">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Survival</label>
                    <select id="Character_editForm_survival" name="survival">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
                <div class="field">
                    <label>bonusModifier</label>
                    <input type="text" name="bonusModifier"  id="Character_editForm_bonusModifier" placeholder="Ronnald" >
                </div>
            <div class="three fields">
                <div class="field">
                    <label>Quiver1</label>
                    <select id="Character_editForm_equipmentQuiver1" name="equipmentQuiver1">                    {$listQuiver|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Quiver2</label>
                    <select id="Character_editForm_equipmentQuiver2" name="equipmentQuiver2">                    {$listQuiver|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Quiver3</label>
                    <select id="Character_editForm_equipmentQuiver3" name="equipmentQuiver3">                    {$listQuiver|default:"<option value=''>-</option>"}                    </select>                </div>
            </div>
            <div class="three fields">
                <div class="field">
                    <label>Helmet</label>
                    <select id="Character_editForm_equipmentHelmet" name="equipmentHelmet">                    {$listHelmet|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Cape</label>
                    <select id="Character_editForm_equipmentCape" name="equipmentCape">                    {$listCape|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Necklace</label>
                    <select id="Character_editForm_equipmentNecklace" name="equipmentNecklace">                    {$listNecklace|default:"<option value=''>-</option>"}                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Weapon1</label>
                    <select id="Character_editForm_equipmentWeapon1" name="equipmentWeapon1">                    {$listWeapon|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Weapon2</label>
                    <select id="Character_editForm_equipmentWeapon2" name="equipmentWeapon2">                    {$listWeapon|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Weapon3</label>
                    <select id="Character_editForm_equipmentWeapon3" name="equipmentWeapon3">                    {$listWeapon|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Off-Weapon</label>
                    <select id="Character_editForm_equipmentOffWeapon" name="equipmentOffWeapon">                    {$listOffWeapon|default:"<option value=''>-</option>"}                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Gloves</label>
                    <select id="Character_editForm_equipmentGloves" name="equipmentGloves">                    {$listGloves|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Armor</label>
                    <select id="Character_editForm_equipmentArmor" name="equipmentArmor">                    {$listArmor|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Belt</label>
                    <select id="Character_editForm_equipmentBelt" name="equipmentBelt">                    {$listBelt|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Object</label>
                    <select id="Character_editForm_equipmentObject" name="equipmentObject">                    {$listObject|default:"<option value=''>-</option>"}                    </select>                </div>
            </div>
            <div class="three fields">
                <div class="field">
                    <label>Boots</label>
                    <select id="Character_editForm_equipmentBoots" name="equipmentBoots">                    {$listBoots|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Ring1</label>
                    <select id="Character_editForm_equipmentRing1" name="equipmentRing1">                    {$listRing|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Ring2</label>
                    <select id="Character_editForm_equipmentRing2" name="equipmentRing2">                    {$listRing|default:"<option value=''>-</option>"}                    </select>                </div>
            </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

