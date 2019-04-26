<div id="Classes_addForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">New Class</div>
    <div class="content">
        <form class="ui form">
            <input id="Classes_addForm_id" name="id" type="hidden" value="">
                <div class="field">
                    <label>Name</label>
                    <input type="text" name="name"  id="Classes_addForm_name" placeholder="Ranger" >
                </div>
            <div class="two fields">
                <div class="field">
                    <label>Hit Dice</label>
                    <input type="text" name="hd"  id="Classes_addForm_hd" placeholder="0" >
                </div>
                <div class="field">
                    <label>Spell Ability</label>
                    <input type="text" name="spellAbility"  id="Classes_addForm_spellAbility" placeholder="" >
                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Acrobatics</label>
                    <select id="Classes_addForm_acrobatics" name="acrobatics">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>AnimalHandling</label>
                    <select id="Classes_addForm_animalHandling" name="animalHandling">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Arcana</label>
                    <select id="Classes_addForm_arcana" name="arcana">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Athletics</label>
                    <select id="Classes_addForm_athletics" name="athletics">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Deception</label>
                    <select id="Classes_addForm_deception" name="deception">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>History</label>
                    <select id="Classes_addForm_history" name="history">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Insight</label>
                    <select id="Classes_addForm_insight" name="insight">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Intimidation</label>
                    <select id="Classes_addForm_intimidation" name="intimidation">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Investigation</label>
                    <select id="Classes_addForm_investigation" name="investigation">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Medicine</label>
                    <select id="Classes_addForm_medicine" name="medicine">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Nature</label>
                    <select id="Classes_addForm_nature" name="nature">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Perception</label>
                    <select id="Classes_addForm_perception" name="perception">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Performance</label>
                    <select id="Classes_addForm_performance" name="performance">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Persuasion</label>
                    <select id="Classes_addForm_persuasion" name="persuasion">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Religion</label>
                    <select id="Classes_addForm_religion" name="religion">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>SleightOfHand</label>
                    <select id="Classes_addForm_sleightOfHand" name="sleightOfHand">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>Stealth</label>
                    <select id="Classes_addForm_stealth" name="stealth">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Survival</label>
                    <select id="Classes_addForm_survival" name="survival">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

<div id="Classes_editForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">Edit Class</div>
    <div class="content">
        <form class="ui form">
            <input id="Classes_editForm_id" name="id" type="hidden" value="">
                <div class="field">
                    <label>Name</label>
                    <input type="text" name="name"  id="Classes_editForm_name" placeholder="Ranger" >
                </div>
            <div class="two fields">
                <div class="field">
                    <label>Hit Dice</label>
                    <input type="text" name="hd"  id="Classes_editForm_hd" placeholder="0" >
                </div>
                <div class="field">
                    <label>Spell Ability</label>
                    <input type="text" name="spellAbility"  id="Classes_editForm_spellAbility" placeholder="" >
                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Acrobatics</label>
                    <select id="Classes_editForm_acrobatics" name="acrobatics">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>AnimalHandling</label>
                    <select id="Classes_editForm_animalHandling" name="animalHandling">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Arcana</label>
                    <select id="Classes_editForm_arcana" name="arcana">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Athletics</label>
                    <select id="Classes_editForm_athletics" name="athletics">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Deception</label>
                    <select id="Classes_editForm_deception" name="deception">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>History</label>
                    <select id="Classes_editForm_history" name="history">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Insight</label>
                    <select id="Classes_editForm_insight" name="insight">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Intimidation</label>
                    <select id="Classes_editForm_intimidation" name="intimidation">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Investigation</label>
                    <select id="Classes_editForm_investigation" name="investigation">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Medicine</label>
                    <select id="Classes_editForm_medicine" name="medicine">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Nature</label>
                    <select id="Classes_editForm_nature" name="nature">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Perception</label>
                    <select id="Classes_editForm_perception" name="perception">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Performance</label>
                    <select id="Classes_editForm_performance" name="performance">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Persuasion</label>
                    <select id="Classes_editForm_persuasion" name="persuasion">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Religion</label>
                    <select id="Classes_editForm_religion" name="religion">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>SleightOfHand</label>
                    <select id="Classes_editForm_sleightOfHand" name="sleightOfHand">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>Stealth</label>
                    <select id="Classes_editForm_stealth" name="stealth">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Survival</label>
                    <select id="Classes_editForm_survival" name="survival">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

