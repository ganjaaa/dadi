<div id="Races_addForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">New Race</div>
    <div class="content">
        <form class="ui form">
            <input id="Races_addForm_id" name="id" type="hidden" value="">
                <div class="field">
                    <label>Name</label>
                    <input type="text" name="name"  id="Races_addForm_name" placeholder="Barbarian" >
                </div>
            <div class="two fields">
                <div class="field">
                    <label>Size</label>
                    <select id="Races_addForm_size" name="size">                        <option value="XXS">XXS</option>                        <option value="XS">XS</option>                        <option value="S">S</option>                        <option value="M">M</option>                        <option value="L">L</option>                        <option value="XL">XL</option>                        <option value="XXL">XXL</option>                    </select>                </div>
                <div class="field">
                    <label>Speed</label>
                    <input type="text" name="speed"  id="Races_addForm_speed" placeholder="0" >
                </div>
            </div>
                <div class="field">
                    <label>Ability</label>
                    <input type="text" name="ability"  id="Races_addForm_ability" placeholder="Welt von DND" >
                </div>
            <div class="four fields">
                <div class="field">
                    <label>Acrobatics</label>
                    <select id="Races_addForm_acrobatics" name="acrobatics">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>AnimalHandling</label>
                    <select id="Races_addForm_animalHandling" name="animalHandling">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Arcana</label>
                    <select id="Races_addForm_arcana" name="arcana">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Athletics</label>
                    <select id="Races_addForm_athletics" name="athletics">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Deception</label>
                    <select id="Races_addForm_deception" name="deception">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>History</label>
                    <select id="Races_addForm_history" name="history">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Insight</label>
                    <select id="Races_addForm_insight" name="insight">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Intimidation</label>
                    <select id="Races_addForm_intimidation" name="intimidation">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Investigation</label>
                    <select id="Races_addForm_investigation" name="investigation">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Medicine</label>
                    <select id="Races_addForm_medicine" name="medicine">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Nature</label>
                    <select id="Races_addForm_nature" name="nature">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Perception</label>
                    <select id="Races_addForm_perception" name="perception">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Performance</label>
                    <select id="Races_addForm_performance" name="performance">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Persuasion</label>
                    <select id="Races_addForm_persuasion" name="persuasion">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Religion</label>
                    <select id="Races_addForm_religion" name="religion">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>SleightOfHand</label>
                    <select id="Races_addForm_sleightOfHand" name="sleightOfHand">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>Stealth</label>
                    <select id="Races_addForm_stealth" name="stealth">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Survival</label>
                    <select id="Races_addForm_survival" name="survival">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

<div id="Races_editForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">Edit Race</div>
    <div class="content">
        <form class="ui form">
            <input id="Races_editForm_id" name="id" type="hidden" value="">
                <div class="field">
                    <label>Name</label>
                    <input type="text" name="name"  id="Races_editForm_name" placeholder="Barbarian" >
                </div>
            <div class="two fields">
                <div class="field">
                    <label>Size</label>
                    <select id="Races_editForm_size" name="size">                        <option value="XXS">XXS</option>                        <option value="XS">XS</option>                        <option value="S">S</option>                        <option value="M">M</option>                        <option value="L">L</option>                        <option value="XL">XL</option>                        <option value="XXL">XXL</option>                    </select>                </div>
                <div class="field">
                    <label>Speed</label>
                    <input type="text" name="speed"  id="Races_editForm_speed" placeholder="0" >
                </div>
            </div>
                <div class="field">
                    <label>Ability</label>
                    <input type="text" name="ability"  id="Races_editForm_ability" placeholder="Welt von DND" >
                </div>
            <div class="four fields">
                <div class="field">
                    <label>Acrobatics</label>
                    <select id="Races_editForm_acrobatics" name="acrobatics">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>AnimalHandling</label>
                    <select id="Races_editForm_animalHandling" name="animalHandling">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Arcana</label>
                    <select id="Races_editForm_arcana" name="arcana">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Athletics</label>
                    <select id="Races_editForm_athletics" name="athletics">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Deception</label>
                    <select id="Races_editForm_deception" name="deception">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>History</label>
                    <select id="Races_editForm_history" name="history">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Insight</label>
                    <select id="Races_editForm_insight" name="insight">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Intimidation</label>
                    <select id="Races_editForm_intimidation" name="intimidation">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Investigation</label>
                    <select id="Races_editForm_investigation" name="investigation">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Medicine</label>
                    <select id="Races_editForm_medicine" name="medicine">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Nature</label>
                    <select id="Races_editForm_nature" name="nature">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Perception</label>
                    <select id="Races_editForm_perception" name="perception">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Performance</label>
                    <select id="Races_editForm_performance" name="performance">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Persuasion</label>
                    <select id="Races_editForm_persuasion" name="persuasion">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Religion</label>
                    <select id="Races_editForm_religion" name="religion">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>SleightOfHand</label>
                    <select id="Races_editForm_sleightOfHand" name="sleightOfHand">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>Stealth</label>
                    <select id="Races_editForm_stealth" name="stealth">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Survival</label>
                    <select id="Races_editForm_survival" name="survival">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

