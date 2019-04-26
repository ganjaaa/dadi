{capture name="hpText"}{$userSheet.Charsheet.hp.now}/{$userSheet.Charsheet.hp.max}+({$userSheet.Charsheet.hp.tmp}){/capture}
{capture name="savesText"}<i class="ui fitted checkmark icon" style="display:inline"></i>:{$userSheet.Charsheet.deathSaves.success}/3<br><i class="ui remove icon" style="display:inline"></i>:{$userSheet.Charsheet.deathSaves.failture}/3{/capture}



<div class="ui two column grid">
    <div class="two wide column" style="max-width: 150px;">
        {include file="user/3_block_ability.tpl" name="Strength" value=$userSheet.Charsheet.savingThrows.strength.value modifier=$userSheet.Charsheet.savingThrows.strength.modifier_raw}
        {include file="user/3_block_ability.tpl" name="Dexterity" value=$userSheet.Charsheet.savingThrows.dexterity.value modifier=$userSheet.Charsheet.savingThrows.dexterity.modifier_raw}
        {include file="user/3_block_ability.tpl" name="Constitution" value=$userSheet.Charsheet.savingThrows.constitution.value modifier=$userSheet.Charsheet.savingThrows.constitution.modifier_raw}
        {include file="user/3_block_ability.tpl" name="Intelligence" value=$userSheet.Charsheet.savingThrows.intelligence.value modifier=$userSheet.Charsheet.savingThrows.intelligence.modifier_raw}
        {include file="user/3_block_ability.tpl" name="Wisdom" value=$userSheet.Charsheet.savingThrows.wisdom.value modifier=$userSheet.Charsheet.savingThrows.wisdom.modifier_raw}
        {include file="user/3_block_ability.tpl" name="Charisma" value=$userSheet.Charsheet.savingThrows.charisma.value modifier=$userSheet.Charsheet.savingThrows.charisma.modifier_raw}
    </div>
    <div class="fourteen wide column">
        <div class="ui eight column grid">
            <div style="width:100%; margin-top: 1rem">
                <table class="ui small striped table">
                    <tbody>
                        <tr>
                            <td><b>Proficiency:</b> {$userSheet.Charsheet.proficiency}</td>
                            <td><b>Speed:</b> {$userSheet.Charsheet.speed}</td>
                            <td><b>Saves:</b></td>
                            <td><b>HP</b></td>
                            <td><b>Angriff</b></td>
                        </tr>
                        <tr>
                            <td><b>Inspiration:</b> {$userSheet.Charsheet.inspiration}</td>
                            <td><b>AC:</b> {$userSheet.Charsheet.ac}</td>
                            <td><i class="ui fitted checkmark icon" style="display:inline"></i>: {$userSheet.Charsheet.deathSaves.success}/3</td>
                            <td id="vHP">{$userSheet.Charsheet.hp.now}/{$userSheet.Charsheet.hp.max}+({$userSheet.Charsheet.hp.tmp})</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>Initiative:</b> {$userSheet.Charsheet.initiative}</td>
                            <td></td>
                            <td><i class="ui remove icon" style="display:inline"></i>: {$userSheet.Charsheet.deathSaves.failture}/3</td>
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
                            <td><i class="{if $userSheet.Charsheet.savingThrows.strength.proficiency  eq 1}blue star{else}{/if} icon"></i>Strength</td>
                            <td>{if $userSheet.Charsheet.savingThrows.strength.modifier ge 0}+{/if}{$userSheet.Charsheet.savingThrows.strength.modifier }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.savingThrows.dexterity.proficiency  eq 1}blue star{else}{/if} icon"></i>Dexterity</td>
                            <td>{if $userSheet.Charsheet.savingThrows.dexterity.modifier ge 0}+{/if}{$userSheet.Charsheet.savingThrows.dexterity.modifier }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.savingThrows.constitution.proficiency  eq 1}blue star{else}{/if} icon"></i>Constitution</td>
                            <td>{if $userSheet.Charsheet.savingThrows.constitution.modifier ge 0}+{/if}{$userSheet.Charsheet.savingThrows.constitution.modifier }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.savingThrows.intelligence.proficiency  eq 1}blue star{else}{/if} icon"></i>Intelligence</td>
                            <td>{if $userSheet.Charsheet.savingThrows.intelligence.modifier ge 0}+{/if}{$userSheet.Charsheet.savingThrows.intelligence.modifier }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.savingThrows.wisdom.proficiency  eq 1}blue star{else}{/if} icon"></i>Wisdom</td>
                            <td>{if $userSheet.Charsheet.savingThrows.wisdom.modifier ge 0}+{/if}{$userSheet.Charsheet.savingThrows.wisdom.modifier }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.savingThrows.charisma.proficiency  eq 1}blue star{else}{/if} icon"></i>Charisma</td>
                            <td>{if $userSheet.Charsheet.savingThrows.charisma.modifier ge 0}+{/if}{$userSheet.Charsheet.savingThrows.charisma.modifier }</td>
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
                            <td><i class="{if $userSheet.Charsheet.skills.acrobatics.proficiency  eq 1}blue star{else}{/if} icon"></i>Acrobatics (Dex)</td>
                            <td>{if $userSheet.Charsheet.skills.acrobatics.value  ge 0}+{/if}{$userSheet.Charsheet.skills.acrobatics.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.skills.animalHandling.proficiency  eq 1}blue star{else}{/if} icon"></i>AnimalHandling (Wis)</td>
                            <td>{if $userSheet.Charsheet.skills.animalHandling.value  ge 0}+{/if}{$userSheet.Charsheet.skills.animalHandling.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.skills.arcana.proficiency  eq 1}blue star{else}{/if} icon"></i>Arcana (Int)</td>
                            <td>{if $userSheet.Charsheet.skills.arcana.value  ge 0}+{/if}{$userSheet.Charsheet.skills.arcana.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.skills.athletics.proficiency  eq 1}blue star{else}{/if} icon"></i>Athletics (Str)</td>
                            <td>{if $userSheet.Charsheet.skills.athletics.value  ge 0}+{/if}{$userSheet.Charsheet.skills.athletics.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.skills.deception.proficiency  eq 1}blue star{else}{/if} icon"></i>Deception (Cha)</td>
                            <td>{if $userSheet.Charsheet.skills.deception.value  ge 0}+{/if}{$userSheet.Charsheet.skills.deception.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.skills.history.proficiency  eq 1}blue star{else}{/if} icon"></i>History (Int)</td>
                            <td>{if $userSheet.Charsheet.skills.history.value  ge 0}+{/if}{$userSheet.Charsheet.skills.history.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.skills.insight.proficiency  eq 1}blue star{else}{/if} icon"></i>Insight (Wis)</td>
                            <td title="Absichten einer Person erraten">{if $userSheet.Charsheet.skills.insight.value  ge 0}+{/if}{$userSheet.Charsheet.skills.insight.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.skills.intimidation.proficiency  eq 1}blue star{else}{/if} icon"></i>Intimidation (Cha)</td>
                            <td>{if $userSheet.Charsheet.skills.intimidation.value  ge 0}+{/if}{$userSheet.Charsheet.skills.intimidation.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.skills.investigation.proficiency  eq 1}blue star{else}{/if} icon"></i>Investigation (Int)</td>
                            <td title="Gegenstände untersuchen/Herkunft bestimmen">{if $userSheet.Charsheet.skills.investigation.value  ge 0}+{/if}{$userSheet.Charsheet.skills.investigation.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.skills.medicine.proficiency  eq 1}blue star{else}{/if} icon"></i>Medicine (Wis)</td>
                            <td>{if $userSheet.Charsheet.skills.medicine.value  ge 0}+{/if}{$userSheet.Charsheet.skills.medicine.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.skills.nature.proficiency  eq 1}blue star{else}{/if} icon"></i>Nature (Int)</td>
                            <td>{if $userSheet.Charsheet.skills.nature.value  ge 0}+{/if}{$userSheet.Charsheet.skills.nature.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.skills.perception.proficiency  eq 1}blue star{else}{/if} icon"></i>Perception (Wis)</td>
                            <td>{if $userSheet.Charsheet.skills.perception.value  ge 0}+{/if}{$userSheet.Charsheet.skills.perception.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.skills.performance.proficiency  eq 1}blue star{else}{/if} icon"></i>Performance (Cha)</td>
                            <td>{if $userSheet.Charsheet.skills.performance.value  ge 0}+{/if}{$userSheet.Charsheet.skills.performance.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.skills.persuasion.proficiency  eq 1}blue star{else}{/if} icon"></i>Persuasion (Cha)</td>
                            <td>{if $userSheet.Charsheet.skills.persuasion.value  ge 0}+{/if}{$userSheet.Charsheet.skills.persuasion.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.skills.religion.proficiency  eq 1}blue star{else}{/if} icon"></i>Religion (Int)</td>
                            <td>{if $userSheet.Charsheet.skills.religion.value  ge 0}+{/if}{$userSheet.Charsheet.skills.religion.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.skills.sleightOfHand.proficiency  eq 1}blue star{else}{/if} icon"></i>Sleight of Hand (Dex)</td>
                            <td>{if $userSheet.Charsheet.skills.sleightOfHand.value  ge 0}+{/if}{$userSheet.Charsheet.skills.sleightOfHand.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.skills.stealth.proficiency  eq 1}blue star{else}{/if} icon"></i>Stealth (Dex)</td>
                            <td>{if $userSheet.Charsheet.skills.stealth.value  ge 0}+{/if}{$userSheet.Charsheet.skills.stealth.value }</td>
                        </tr>
                        <tr>
                            <td><i class="{if $userSheet.Charsheet.skills.survival.proficiency  eq 1}blue blue star{else}{/if} icon"></i>Survival (Wis)</td><td>{if $userSheet.Charsheet.skills.survival.value  ge 0}+{/if}{$userSheet.Charsheet.skills.survival.value }</td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="ten wide column">
                <div class="" style="background-size: 100%; background-image: url('/inc/images/paper.jpg'); height:500px; width: 367px; position: relative; ">
                    <div id="pupx" style="height: 1px;width: 1px;"></div>
                    <!-- Quiver -->
                    {include file="user/3_block_paperslot_rt.tpl" title="Quiver" x=0 y=0 id=$userSheet.Charsheet.equipment.quiver1 knowledge=$userSheet.Charsheet.equipment.quiver1 cursed=$userSheet.Charsheet.equipment.quiver1}
                    {include file="user/3_block_paperslot_rt.tpl" title="Quiver" x=0 y=50 id=$userSheet.Charsheet.equipment.quiver2 knowledge=$userSheet.Charsheet.equipment.quiver2 cursed=$userSheet.Charsheet.equipment.quiver2}
                    {include file="user/3_block_paperslot_rt.tpl" title="Quiver" x=0 y=100 id=$userSheet.Charsheet.equipment.quiver3 knowledge=$userSheet.Charsheet.equipment.quiver3 cursed=$userSheet.Charsheet.equipment.quiver3}
                    {include file="user/3_block_paperslot_lt.tpl" title="Helm" x=165 y=30 id=$userSheet.Charsheet.equipment.helmet knowledge=$userSheet.Charsheet.equipment.helmet cursed=$userSheet.Charsheet.equipment.helmet}
                    {include file="user/3_block_paperslot_lt.tpl" title="Necklace" x=165 y=85 id=$userSheet.Charsheet.equipment.necklace knowledge=$userSheet.Charsheet.equipment.necklace cursed=$userSheet.Charsheet.equipment.necklace}
                    {include file="user/3_block_paperslot_lt.tpl" title="Cape" x=220 y=85 id=$userSheet.Charsheet.equipment.cape knowledge=$userSheet.Charsheet.equipment.cape cursed=$userSheet.Charsheet.equipment.cape}
                    {include file="user/3_block_paperslot_lt.tpl" title="Armor" x=165 y=140 id=$userSheet.Charsheet.equipment.armor knowledge=$userSheet.Charsheet.equipment.armor cursed=$userSheet.Charsheet.equipment.armor}

                    {include file="user/3_block_paperslot_lt.tpl" title="Belt" x=165 y=195 id=$userSheet.Charsheet.equipment.belt knowledge=$userSheet.Charsheet.equipment.belt cursed=$userSheet.Charsheet.equipment.belt}
                    {include file="user/3_block_paperslot_lt.tpl" title="Boots" x=165 y=390 id=$userSheet.Charsheet.equipment.boots knowledge=$userSheet.Charsheet.equipment.boots cursed=$userSheet.Charsheet.equipment.boots}
                    {include file="user/3_block_paperslot_lt.tpl" title="Gloves" x=220 y=195 id=$userSheet.Charsheet.equipment.gloves knowledge=$userSheet.Charsheet.equipment.gloves cursed=$userSheet.Charsheet.equipment.gloves}
                    {include file="user/3_block_paperslot_lt.tpl" title="Ring" x=275 y=195 id=$userSheet.Charsheet.equipment.ring1 knowledge=$userSheet.Charsheet.equipment.ring1 cursed=$userSheet.Charsheet.equipment.ring1}
                    {include file="user/3_block_paperslot_lt.tpl" title="Ring" x=275 y=250 id=$userSheet.Charsheet.equipment.ring2 knowledge=$userSheet.Charsheet.equipment.ring2 cursed=$userSheet.Charsheet.equipment.ring2}
                    {include file="user/3_block_paperslot_lt.tpl" title="Weapon" x=110 y=195 id=$userSheet.Charsheet.equipment.weapon1 knowledge=$userSheet.Charsheet.equipment.weapon1 cursed=$userSheet.Charsheet.equipment.weapon1}
                    {include file="user/3_block_paperslot_lt.tpl" title="Weapon" x=110 y=250 id=$userSheet.Charsheet.equipment.weapon2 knowledge=$userSheet.Charsheet.equipment.weapon2 cursed=$userSheet.Charsheet.equipment.weapon2}
                    {include file="user/3_block_paperslot_lt.tpl" title="Weapon" x=110 y=305 id=$userSheet.Charsheet.equipment.weapon3 knowledge=$userSheet.Charsheet.equipment.weapon3 cursed=$userSheet.Charsheet.equipment.weapon3}

                    <!-- Gold -->
                    <div class="ui segment paperslot" style="left:0px; top: 0px;"><span id="vCP">{$userSheet.Charsheet.money.copper|default:0}</span><div class="ui bottom right attached blue label" style="padding: 0.1em;">CP</div></div>
                    <div class="ui segment paperslot" style="left:0px; top: 50px;"><span id="vSP">{$userSheet.Charsheet.money.silver|default:0}</span><div class="ui bottom right attached blue label" style="padding: 0.1em;">SP</div></div>
                    <div class="ui segment paperslot" style="left:0px; top: 100px;"><span id="vEP">{$userSheet.Charsheet.money.electrum|default:0}</span><div class="ui bottom right attached blue label" style="padding: 0.1em;">EP</div></div>
                    <div class="ui segment paperslot" style="left:0px; top: 150px;"><span id="vGP">{$userSheet.Charsheet.money.gold|default:0}</span><div class="ui bottom right attached blue label" style="padding: 0.1em;">GP</div></div>
                    <div class="ui segment paperslot" style="left:0px; top: 200px;"><span id="vPP">{$userSheet.Charsheet.money.platinum|default:0}</span><div class="ui bottom right attached blue label" style="padding: 0.1em;">PP</div></div>

                    <div class="ui indicating progress" style="position: absolute;left: 0; bottom: 0;right: 0" data-value="{$userSheet.Charsheet.hp.now}" data-total="{$userSheet.Charsheet.hp.max+$userSheet.Charsheet.hp.tmp}" id="hpBar">
                        <div class="bar">
                            <div class="progress"></div>
                        </div>
                        <div class="label">{$userSheet.Charsheet.hp.now}/{$userSheet.Charsheet.hp.max+$userSheet.Charsheet.hp.tmp}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>