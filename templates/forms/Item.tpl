<div id="Item_addForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">Item anlegen</div>
    <div class="content">
        <form class="ui form">
            <input id="Item_addForm_id" name="id" type="hidden" value="">
            <div class="two fields">
                <div class="field">
                    <label>Name</label>
                    <input type="text" name="name"  id="Item_addForm_name" placeholder="Welt von DND" >
                </div>
                <div class="field">
                    <label>Weight</label>
                    <input type="text" name="weight"  id="Item_addForm_weight" placeholder="" >
                </div>
            </div>
                <div class="field">
                    <label>Description</label>
                    <textarea name="description"  id="Item_addForm_description" placeholder=""></textarea>
                </div>
            <div class="five fields">
                <div class="field">
                    <label>Price CP</label>
                    <input type="text" name="priceCP"  id="Item_addForm_priceCP" placeholder="0" >
                </div>
                <div class="field">
                    <label>Price SP</label>
                    <input type="text" name="priceSP"  id="Item_addForm_priceSP" placeholder="0" >
                </div>
                <div class="field">
                    <label>Price EP</label>
                    <input type="text" name="priceEP"  id="Item_addForm_priceEP" placeholder="0" >
                </div>
                <div class="field">
                    <label>Price GP</label>
                    <input type="text" name="priceGP"  id="Item_addForm_priceGP" placeholder="0" >
                </div>
                <div class="field">
                    <label>Price PP</label>
                    <input type="text" name="pricePP"  id="Item_addForm_pricePP" placeholder="0" >
                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Magic</label>
                    <select id="Item_addForm_magic" name="magic">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Type</label>
                    <select id="Item_addForm_type" name="type">                        <option value="$">Money</option>                        <option value="HA">Heavy_Armor</option>                        <option value="LA">Light_Armor</option>                        <option value="MA">Medium_Armor</option>                        <option value="A">Ammunition</option>                        <option value="G">Adventuring_Gear</option>                        <option value="W">Wondrous</option>                        <option value="S">Schild</option>                        <option value="M">Melee_Weapon</option>                        <option value="R">Range_Weapons</option>                        <option value="P">Potion</option>                        <option value="RD">Rod</option>                        <option value="RG">Ring</option>                        <option value="SC">Scroll</option>                        <option value="ST">Staff</option>                        <option value="WD">Wand</option>                    </select>                </div>
                <div class="field">
                    <label>Rarity</label>
                    <select id="Item_addForm_rarity" name="rarity">                        <option value="0">COMMON</option>                        <option value="1">UNCOMMON</option>                        <option value="2">RARE</option>                        <option value="3">VERY_RARE</option>                        <option value="4">EPIC</option>                        <option value="5">LEGENDARY</option>                        <option value="6">UNIQUE</option>                    </select>                </div>
                <div class="field">
                    <label>AC</label>
                    <input type="text" name="ac"  id="Item_addForm_ac" placeholder="0" >
                </div>
            </div>
            <div class="three fields">
                <div class="field">
                    <label>Strength</label>
                    <input type="text" name="strength"  id="Item_addForm_strength" placeholder="0" >
                </div>
                <div class="field">
                    <label>Stealth</label>
                    <input type="text" name="stealth"  id="Item_addForm_stealth" placeholder="0" >
                </div>
                <div class="field">
                    <label>Modifier</label>
                    <input type="text" name="modifier"  id="Item_addForm_modifier" placeholder="0" >
                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Roll</label>
                    <input type="text" name="roll"  id="Item_addForm_roll" placeholder="0" >
                </div>
                <div class="field">
                    <label>Dmg1</label>
                    <input type="text" name="dmg1"  id="Item_addForm_dmg1" placeholder="0" >
                </div>
                <div class="field">
                    <label>Dmg2</label>
                    <input type="text" name="dmg2"  id="Item_addForm_dmg2" placeholder="0" >
                </div>
                <div class="field">
                    <label>DmgType</label>
                    <input type="text" name="dmgType"  id="Item_addForm_dmgType" placeholder="0" >
                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Property</label>
                    <input type="text" name="property"  id="Item_addForm_property" placeholder="0" >
                </div>
                <div class="field">
                    <label>Range</label>
                    <input type="text" name="range"  id="Item_addForm_range" placeholder="0" >
                </div>
                <div class="field">
                    <label>Wearable</label>
                    <select id="Item_addForm_wearable" name="wearable">                        <option value="0">NONE</option>                        <option value="1">QUIVER</option>                        <option value="2">HELMET</option>                        <option value="3">CAPE</option>                        <option value="4">NECKLACE</option>                        <option value="5">GLOVES</option>                        <option value="6">RING</option>                        <option value="7">ARMOR</option>                        <option value="8">WEAPON</option>                        <option value="9">OFF HAND</option>                        <option value="10">BELT</option>                        <option value="11">BOOTS</option>                    </select>                </div>
                <div class="field">
                    <label>Cursed</label>
                    <select id="Item_addForm_cursed" name="cursed">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
                <div class="field">
                    <label>Stackable</label>
                    <select id="Item_addForm_stackable" name="stackable">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

<div id="Item_editForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">Item bearbeiten</div>
    <div class="content">
        <form class="ui form">
            <input id="Item_editForm_id" name="id" type="hidden" value="">
            <div class="three fields">
                <div class="field">
                    <label>Name</label>
                    <input type="text" name="name"  id="Item_editForm_name" placeholder="Welt von DND" >
                </div>
                <div class="field">
                    <label>Description</label>
                    <textarea name="description"  id="Item_editForm_description" placeholder=""></textarea>
                </div>
                <div class="field">
                    <label>Weight</label>
                    <input type="text" name="weight"  id="Item_editForm_weight" placeholder="" >
                </div>
            </div>
            <div class="five fields">
                <div class="field">
                    <label>Price CP</label>
                    <input type="text" name="priceCP"  id="Item_editForm_priceCP" placeholder="0" >
                </div>
                <div class="field">
                    <label>Price SP</label>
                    <input type="text" name="priceSP"  id="Item_editForm_priceSP" placeholder="0" >
                </div>
                <div class="field">
                    <label>Price EP</label>
                    <input type="text" name="priceEP"  id="Item_editForm_priceEP" placeholder="0" >
                </div>
                <div class="field">
                    <label>Price GP</label>
                    <input type="text" name="priceGP"  id="Item_editForm_priceGP" placeholder="0" >
                </div>
                <div class="field">
                    <label>Price PP</label>
                    <input type="text" name="pricePP"  id="Item_editForm_pricePP" placeholder="0" >
                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Magic</label>
                    <select id="Item_editForm_magic" name="magic">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Type</label>
                    <select id="Item_editForm_type" name="type">                        <option value="$">Money</option>                        <option value="HA">Heavy_Armor</option>                        <option value="LA">Light_Armor</option>                        <option value="MA">Medium_Armor</option>                        <option value="A">Ammunition</option>                        <option value="G">Adventuring_Gear</option>                        <option value="W">Wondrous</option>                        <option value="S">Schild</option>                        <option value="M">Melee_Weapon</option>                        <option value="R">Range_Weapons</option>                        <option value="P">Potion</option>                        <option value="RD">Rod</option>                        <option value="RG">Ring</option>                        <option value="SC">Scroll</option>                        <option value="ST">Staff</option>                        <option value="WD">Wand</option>                    </select>                </div>
                <div class="field">
                    <label>Rarity</label>
                    <select id="Item_editForm_rarity" name="rarity">                        <option value="0">COMMON</option>                        <option value="1">UNCOMMON</option>                        <option value="2">RARE</option>                        <option value="3">VERY_RARE</option>                        <option value="4">EPIC</option>                        <option value="5">LEGENDARY</option>                        <option value="6">UNIQUE</option>                    </select>                </div>
                <div class="field">
                    <label>AC</label>
                    <input type="text" name="ac"  id="Item_editForm_ac" placeholder="0" value="0">
                </div>
            </div>
            <div class="three fields">
                <div class="field">
                    <label>Strength</label>
                    <input type="text" name="strength"  id="Item_editForm_strength" placeholder="0" >
                </div>
                <div class="field">
                    <label>Stealth</label>
                    <input type="text" name="stealth"  id="Item_editForm_stealth" placeholder="0" >
                </div>
                <div class="field">
                    <label>Modifier</label>
                    <input type="text" name="modifier"  id="Item_editForm_modifier" placeholder="0" >
                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Roll</label>
                    <input type="text" name="roll"  id="Item_editForm_roll" placeholder="0" >
                </div>
                <div class="field">
                    <label>Dmg1</label>
                    <input type="text" name="dmg1"  id="Item_editForm_dmg1" placeholder="0" >
                </div>
                <div class="field">
                    <label>Dmg2</label>
                    <input type="text" name="dmg2"  id="Item_editForm_dmg2" placeholder="0" >
                </div>
                <div class="field">
                    <label>DmgType</label>
                    <input type="text" name="dmgType"  id="Item_editForm_dmgType" placeholder="0" >
                </div>
            </div>
            <div class="four fields">
                <div class="field">
                    <label>Property</label>
                    <input type="text" name="property"  id="Item_editForm_property" placeholder="0" >
                </div>
                <div class="field">
                    <label>Range</label>
                    <input type="text" name="range"  id="Item_editForm_range" placeholder="0" >
                </div>
                <div class="field">
                    <label>Wearable</label>
                    <select id="Item_editForm_wearable" name="wearable">                        <option value="0">NONE</option>                        <option value="1">QUIVER</option>                        <option value="2">HELMET</option>                        <option value="3">CAPE</option>                        <option value="4">NECKLACE</option>                        <option value="5">GLOVES</option>                        <option value="6">RING</option>                        <option value="7">ARMOR</option>                        <option value="8">WEAPON</option>                        <option value="9">OFF HAND</option>                        <option value="10">BELT</option>                        <option value="11">BOOTS</option>                    </select>                </div>
                <div class="field">
                    <label>Cursed</label>
                    <select id="Item_editForm_cursed" name="cursed">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
            </div>
                <div class="field">
                    <label>Stackable</label>
                    <select id="Item_editForm_stackable" name="stackable">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

