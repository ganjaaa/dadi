<div id="Spellbook_addForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">Spellbook Object anlegen</div>
    <div class="content">
        <form class="ui form">
            <input id="Spellbook_addForm_id" name="id" type="hidden" value="">
                <div class="field">
                    <label></label>
                    <input type="hidden" name="characterId"  id="Spellbook_addForm_characterId" placeholder="" >
                </div>
                <div class="field">
                    <label>Zauber</label>
                    <select id="Spellbook_addForm_spellId" name="spellId" class="ui fluid remote search dropdown" >                    </select>                </div>
            <div class="two fields">
                <div class="field">
                    <label>Slot</label>
                    <input type="text" name="slot"  id="Spellbook_addForm_slot" placeholder="" >
                </div>
                <div class="field">
                    <label>Benutzt</label>
                    <input type="text" name="used"  id="Spellbook_addForm_used" placeholder="1" >
                </div>
            </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

<div id="Spellbook_editForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">Spellbook Object bearbeiten</div>
    <div class="content">
        <form class="ui form">
            <input id="Spellbook_editForm_id" name="id" type="hidden" value="">
                <div class="field">
                    <label>Zauber</label>
                    <select id="Spellbook_editForm_spellId" name="spellId" class="ui fluid remote search dropdown" >                    </select>                </div>
            <div class="two fields">
                <div class="field">
                    <label>Slot</label>
                    <input type="text" name="slot"  id="Spellbook_editForm_slot" placeholder="" >
                </div>
                <div class="field">
                    <label>Benutzt</label>
                    <input type="text" name="used"  id="Spellbook_editForm_used" placeholder="1" >
                </div>
            </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

<script>
{literal}
$(document).ready(function () {
            $('#Spellbook_addForm_spellId').dropdown({
             apiSettings: {
               url: '{/literal}{$BASEURL}{literal}/v2/gm/spell'
             },
             filterRemoteData: true,
             fields: {
               remoteValues: 'data',
               name: 'name',
               value: 'id'
             },
            });
            $('#Spellbook_editForm_spellId').dropdown({
             apiSettings: {
               url: '{/literal}{$BASEURL}{literal}/v2/gm/spell'
             },
             filterRemoteData: true,
             fields: {
               remoteValues: 'data',
               name: 'name',
               value: 'id'
             },
            });
});
{/literal}
</script>
