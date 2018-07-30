<h3 class="ui center aligned header">Your Spell Ability: {$magic.spellAbility}</h3>
<div class="ui three column doubling grid container">
    <div class="column">
        <table class="ui celled striped compact table">
            <thead>
                <tr>
                    <th colspan="1">0/{$magic.slots.0}</th>
                    <th colspan="2">Cantrips</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="collapsing"><i class="ui check square outline icon"></i></td>
                    <td>SPELLNAME</td>
                </tr>
                <tr>
                    <td class="collapsing"><i class="ui square outline icon"></i></td>
                    <td>SPELLNAME</td>
                </tr>
            </tbody>
        </table>
    </div>
    {for $foo=1 to 9}
        <div class="column">
            <table class="ui celled striped compact table">
                <thead>
                    <tr>
                        <th colspan="1">0/{$magic.slots.$foo}</th>
                        <th colspan="2">Level {$foo}</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    {/for}
</div>


<!--div class="ui segment" style="max-height: 36em;">
    <table id="datatableSpellbook" class="ui compact celled definition table" style="width: 100%">
        <thead>
            <tr>
                <th></th>
                <th>Slot</th>
                <th>Benutzt</th>
                <th>Name</th>
                <th>Details</th>
                <th>Optionen</th>
            </tr>
        </thead>
        <tbody> </tbody>
    </table>
</div--->