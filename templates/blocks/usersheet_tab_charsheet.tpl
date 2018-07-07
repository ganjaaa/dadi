{capture name="hpText"}{$character.hp.tmp}/{$character.hp.now}/{$character.hp.max}{/capture}
{capture name="hpText"}Tmp:{$character.hp.tmp}<br>Now:{$character.hp.now}<br>Max:{$character.hp.max}{/capture}
{capture name="hpText"}{$character.hp.now}/{$character.hp.max}+({$character.hp.tmp}){/capture}
{capture name="savesText"}<i class="ui fitted checkmark icon" style="display:inline"></i>:{$character.deathSaves.success}/3<br><i class="ui remove icon" style="display:inline"></i>:{$character.deathSaves.failture}/3{/capture}



<div class="ui two column grid">
    <div class="two wide column">
        {include file="blocks/block_ability.tpl" name="Strength" value=$character.savingThrows.strength.value modifier=$character.savingThrows.strength.modifier_raw}
        {include file="blocks/block_ability.tpl" name="Dexterity" value=$character.savingThrows.dexterity.value modifier=$character.savingThrows.dexterity.modifier_raw}
        {include file="blocks/block_ability.tpl" name="Constitution" value=$character.savingThrows.constitution.value modifier=$character.savingThrows.constitution.modifier_raw}
        {include file="blocks/block_ability.tpl" name="Intelligence" value=$character.savingThrows.intelligence.value modifier=$character.savingThrows.intelligence.modifier_raw}
        {include file="blocks/block_ability.tpl" name="Wisdom" value=$character.savingThrows.wisdom.value modifier=$character.savingThrows.wisdom.modifier_raw}
        {include file="blocks/block_ability.tpl" name="Charisma" value=$character.savingThrows.charisma.value modifier=$character.savingThrows.charisma.modifier_raw}
    </div>
    <div class="fourteen wide column">
        <div class="ui eight column grid">
            <div style="width:100%; margin-top: 1rem">
                <table class="ui small striped table">
                    <tbody>
                        <tr>
                            <td><b>Proficiency:</b> {$character.proficiency}</td>
                            <td><b>Speed:</b> {$character.speed}</td>
                            <td><b>Saves:</b></td>
                            <td><b>HP</b></td>
                            <td><b>Angriff</b></td>
                        </tr>
                        <tr>
                            <td><b>Inspiration:</b> {$character.inspiration}</td>
                            <td><b>AC:</b> {$character.ac}</td>
                            <td><i class="ui fitted checkmark icon" style="display:inline"></i>: {$character.deathSaves.success}/3</td>
                            <td id="vHP">{$character.hp.now}/{$character.hp.max}+({$character.hp.tmp})</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>Initiative:</b> {$character.initiative}</td>
                            <td></td>
                            <td><i class="ui remove icon" style="display:inline"></i>: {$character.deathSaves.failture}/3</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="ui two column grid">
            <div class="five wide column">
                <table class="ui small striped table">
                    <colgroup>
                        <col>
                        <col style="width: 20%">
                    </colgroup>
                    <tbody>
                        <tr>
                            <td><i class="{if $character.savingThrows.strength.proficiency  eq 1}blue star{else}{/if} icon"></i>Strength</td>
                            <td>{if $character.savingThrows.strength.modifier ge 0}+{/if}{$character.savingThrows.strength.modifier }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.savingThrows.dexterity.proficiency  eq 1}blue star{else}{/if} icon"></i>Dexterity</td>
                            <td>{if $character.savingThrows.dexterity.modifier ge 0}+{/if}{$character.savingThrows.dexterity.modifier }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.savingThrows.constitution.proficiency  eq 1}blue star{else}{/if} icon"></i>Constitution</td>
                            <td>{if $character.savingThrows.constitution.modifier ge 0}+{/if}{$character.savingThrows.constitution.modifier }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.savingThrows.intelligence.proficiency  eq 1}blue star{else}{/if} icon"></i>Intelligence</td>
                            <td>{if $character.savingThrows.intelligence.modifier ge 0}+{/if}{$character.savingThrows.intelligence.modifier }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.savingThrows.wisdom.proficiency  eq 1}blue star{else}{/if} icon"></i>Wisdom</td>
                            <td>{if $character.savingThrows.wisdom.modifier ge 0}+{/if}{$character.savingThrows.wisdom.modifier }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.savingThrows.charisma.proficiency  eq 1}blue star{else}{/if} icon"></i>Charisma</td>
                            <td>{if $character.savingThrows.charisma.modifier ge 0}+{/if}{$character.savingThrows.charisma.modifier }</td>
                        </tr>
                    </tbody>
                </table>
                <table class="ui  small striped table">
                    <colgroup>
                        <col>
                        <col style="width: 20%">
                    </colgroup>
                    <tbody>
                        <tr>
                            <td><i class="{if $character.skills.acrobatics.proficiency  eq 1}blue star{else}{/if} icon"></i>Acrobatics (Dex)</td>
                            <td>{if $character.skills.acrobatics.value  ge 0}+{/if}{$character.skills.acrobatics.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.skills.animalHandling.proficiency  eq 1}blue star{else}{/if} icon"></i>AnimalHandling (Wis)</td>
                            <td>{if $character.skills.animalHandling.value  ge 0}+{/if}{$character.skills.animalHandling.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.skills.arcana.proficiency  eq 1}blue star{else}{/if} icon"></i>Arcana (Int)</td>
                            <td>{if $character.skills.arcana.value  ge 0}+{/if}{$character.skills.arcana.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.skills.athletics.proficiency  eq 1}blue star{else}{/if} icon"></i>Athletics (Str)</td>
                            <td>{if $character.skills.athletics.value  ge 0}+{/if}{$character.skills.athletics.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.skills.deception.proficiency  eq 1}blue star{else}{/if} icon"></i>Deception (Cha)</td>
                            <td>{if $character.skills.deception.value  ge 0}+{/if}{$character.skills.deception.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.skills.history.proficiency  eq 1}blue star{else}{/if} icon"></i>History (Int)</td>
                            <td>{if $character.skills.history.value  ge 0}+{/if}{$character.skills.history.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.skills.insight.proficiency  eq 1}blue star{else}{/if} icon"></i>Insight (Wis)</td>
                            <td>{if $character.skills.insight.value  ge 0}+{/if}{$character.skills.insight.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.skills.intimidation.proficiency  eq 1}blue star{else}{/if} icon"></i>Intimidation (Cha)</td>
                            <td>{if $character.skills.intimidation.value  ge 0}+{/if}{$character.skills.intimidation.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.skills.investigation.proficiency  eq 1}blue star{else}{/if} icon"></i>Investigation (Int)</td>
                            <td>{if $character.skills.investigation.value  ge 0}+{/if}{$character.skills.investigation.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.skills.medicine.proficiency  eq 1}blue star{else}{/if} icon"></i>Medicine (Wis)</td>
                            <td>{if $character.skills.medicine.value  ge 0}+{/if}{$character.skills.medicine.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.skills.nature.proficiency  eq 1}blue star{else}{/if} icon"></i>Nature (Int)</td>
                            <td>{if $character.skills.nature.value  ge 0}+{/if}{$character.skills.nature.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.skills.perception.proficiency  eq 1}blue star{else}{/if} icon"></i>Perception (Wis)</td>
                            <td>{if $character.skills.perception.value  ge 0}+{/if}{$character.skills.perception.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.skills.performance.proficiency  eq 1}blue star{else}{/if} icon"></i>Performance (Cha)</td>
                            <td>{if $character.skills.performance.value  ge 0}+{/if}{$character.skills.performance.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.skills.persuasion.proficiency  eq 1}blue star{else}{/if} icon"></i>Persuasion (Cha)</td>
                            <td>{if $character.skills.persuasion.value  ge 0}+{/if}{$character.skills.persuasion.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.skills.religion.proficiency  eq 1}blue star{else}{/if} icon"></i>Religion (Int)</td>
                            <td>{if $character.skills.religion.value  ge 0}+{/if}{$character.skills.religion.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.skills.sleightOfHand.proficiency  eq 1}blue star{else}{/if} icon"></i>Sleight of Hand (Dex)</td>
                            <td>{if $character.skills.sleightOfHand.value  ge 0}+{/if}{$character.skills.sleightOfHand.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.skills.stealth.proficiency  eq 1}blue star{else}{/if} icon"></i>Stealth (Dex)</td>
                            <td>{if $character.skills.stealth.value  ge 0}+{/if}{$character.skills.stealth.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $character.skills.survival.proficiency  eq 1}blue blue star{else}{/if} icon"></i>Survival (Wis)</td><td>{if $character.skills.survival.value  ge 0}+{/if}{$character.skills.survival.value }</td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="ten wide column">
                <div class="" style="background-size: 100%; background-image: url('/inc/images/paper.jpg'); height:500px; width: 367px; position: relative; ">
                    <div id="pupx" style="height: 1px;width: 1px;"></div>
                    <!-- Quiver -->
                    {include file="blocks/block_paperslot_rt.tpl" title="Quiver" x=0 y=0 id=$character.equipment.quiver1.id knowledge=$character.items[$character.equipment.quiver1.id].knowledge cursed=$character.equipment.quiver1.cursed}
                    {include file="blocks/block_paperslot_rt.tpl" title="Quiver" x=0 y=50 id=$character.equipment.quiver2.id knowledge=$character.items[$character.equipment.quiver2.id].knowledge cursed=$character.equipment.quiver2.cursed}
                    {include file="blocks/block_paperslot_rt.tpl" title="Quiver" x=0 y=100 id=$character.equipment.quiver3.id knowledge=$character.items[$character.equipment.quiver3.id].knowledge cursed=$character.equipment.quiver3.cursed}
                    {include file="blocks/block_paperslot_lt.tpl" title="Helm" x=165 y=30 id=$character.equipment.helmet.id knowledge=$character.items[$character.equipment.helmet.id].knowledge cursed=$character.equipment.helmet.cursed}
                    {include file="blocks/block_paperslot_lt.tpl" title="Necklace" x=165 y=85 id=$character.equipment.necklace.id knowledge=$character.items[$character.equipment.necklace.id].knowledge cursed=$character.equipment.necklace.cursed}
                    {include file="blocks/block_paperslot_lt.tpl" title="Cape" x=220 y=85 id=$character.equipment.cape.id knowledge=$character.items[$character.equipment.cape.id].knowledge cursed=$character.equipment.cape.cursed}
                    {include file="blocks/block_paperslot_lt.tpl" title="Armor" x=165 y=140 id=$character.equipment.armor.id knowledge=$character.items[$character.equipment.armor.id].knowledge cursed=$character.equipment.armor.cursed}

                    {include file="blocks/block_paperslot_lt.tpl" title="Belt" x=165 y=195 id=$character.equipment.belt.id knowledge=$character.items[$character.equipment.belt.id].knowledge cursed=$character.equipment.belt.cursed}
                    {include file="blocks/block_paperslot_lt.tpl" title="Boots" x=165 y=390 id=$character.equipment.boots.id knowledge=$character.items[$character.equipment.boots.id].knowledge cursed=$character.equipment.boots.cursed}
                    {include file="blocks/block_paperslot_lt.tpl" title="Gloves" x=220 y=195 id=$character.equipment.gloves.id knowledge=$character.items[$character.equipment.gloves.id].knowledge cursed=$character.equipment.gloves.cursed}
                    {include file="blocks/block_paperslot_lt.tpl" title="Ring" x=275 y=195 id=$character.equipment.ring1.id knowledge=$character.items[$character.equipment.ring1.id].knowledge cursed=$character.equipment.ring1.cursed}
                    {include file="blocks/block_paperslot_lt.tpl" title="Ring" x=275 y=250 id=$character.equipment.ring2.id knowledge=$character.items[$character.equipment.ring2.id].knowledge cursed=$character.equipment.ring2.cursed}
                    {include file="blocks/block_paperslot_lt.tpl" title="Weapon" x=110 y=195 id=$character.equipment.weapon1.id knowledge=$character.items[$character.equipment.weapon1.id].knowledge cursed=$character.equipment.weapon1.cursed}
                    {include file="blocks/block_paperslot_lt.tpl" title="Weapon" x=110 y=250 id=$character.equipment.weapon2.id knowledge=$character.items[$character.equipment.weapon2.id].knowledge cursed=$character.equipment.weapon2.cursed}
                    {include file="blocks/block_paperslot_lt.tpl" title="Weapon" x=110 y=305 id=$character.equipment.weapon3.id knowledge=$character.items[$character.equipment.weapon3.id].knowledge cursed=$character.equipment.weapon3.cursed}

                    <!-- Gold -->
                    <div class="ui segment paperslot" style="left:0px; top: 0px;"><span id="vCP">{$character.money.copper|default:0}</span><div class="ui bottom right attached blue label" style="padding: 0.1em;">CP</div></div>
                    <div class="ui segment paperslot" style="left:0px; top: 50px;"><span id="vSP">{$character.money.silver|default:0}</span><div class="ui bottom right attached blue label" style="padding: 0.1em;">SP</div></div>
                    <div class="ui segment paperslot" style="left:0px; top: 100px;"><span id="vEP">{$character.money.electrum|default:0}</span><div class="ui bottom right attached blue label" style="padding: 0.1em;">EP</div></div>
                    <div class="ui segment paperslot" style="left:0px; top: 150px;"><span id="vGP">{$character.money.gold|default:0}</span><div class="ui bottom right attached blue label" style="padding: 0.1em;">GP</div></div>
                    <div class="ui segment paperslot" style="left:0px; top: 200px;"><span id="vPP">{$character.money.platinum|default:0}</span><div class="ui bottom right attached blue label" style="padding: 0.1em;">PP</div></div>

                    <div class="ui indicating progress" style="position: absolute;left: 0; bottom: 0;right: 0" data-value="{$character.hp.now}" data-total="{$character.hp.max+$character.hp.tmp}" id="hpBar">
                        <div class="bar">
                            <div class="progress"></div>
                        </div>
                        <div class="label">{$character.hp.now}/{$character.hp.max+$character.hp.tmp}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>