<div id="Inventory_addForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">Inventar Object anlegen</div>
    <div class="content">
        <form class="ui form">
            <input id="Inventory_addForm_id" name="id" type="hidden" value="">
                <div class="field">
                    <label></label>
                    <input type="hidden" name="characterId"  id="Inventory_addForm_characterId" placeholder="" >
                </div>
            <div class="two fields">
                <div class="field">
                    <label>Item</label>
                    <select id="Inventory_addForm_itemId" name="itemId">                    {$listItem|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Menge</label>
                    <input type="text" name="amount"  id="Inventory_addForm_amount" placeholder="" >
                </div>
            </div>
                <div class="field">
                    <label>Wissen</label>
                    <select id="Inventory_addForm_knowledge" name="knowledge">                        <option value="0">UNKOWN</option>                        <option value="1">KNOWN</option>                        <option value="2">BETTER_KNOWN</option>                        <option value="3">MASTERED</option>                    </select>                </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

<div id="Inventory_editForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">Inventar Object bearbeiten</div>
    <div class="content">
        <form class="ui form">
            <input id="Inventory_editForm_id" name="id" type="hidden" value="">
                <div class="field">
                    <label></label>
                    <input type="hidden" name="characterId"  id="Inventory_editForm_characterId" placeholder="" >
                </div>
            <div class="two fields">
                <div class="field">
                    <label>Item</label>
                    <select id="Inventory_editForm_itemId" name="itemId">                    {$listItem|default:"<option value=''>-</option>"}                    </select>                </div>
                <div class="field">
                    <label>Menge</label>
                    <input type="text" name="amount"  id="Inventory_editForm_amount" placeholder="" >
                </div>
            </div>
                <div class="field">
                    <label>Wissen</label>
                    <select id="Inventory_editForm_knowledge" name="knowledge">                        <option value="0">UNKOWN</option>                        <option value="1">KNOWN</option>                        <option value="2">BETTER_KNOWN</option>                        <option value="3">MASTERED</option>                    </select>                </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

<div id="Inventory_tradeForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">Item weitergeben</div>
    <div class="content">
        <form class="ui form">
            <input id="Inventory_tradeForm_id" name="id" type="hidden" value="">
                <div class="field">
                    <label>Menge</label>
                    <input type="text" name="amount"  id="Inventory_tradeForm_amount" placeholder="" >
                </div>
                <div class="field">
                    <label>Benutzer</label>
                    <select id="Inventory_tradeForm_userId" name="userId" class="ui fluid remote search dropdown" >                    </select>                </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

<div id="Inventory_dropForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">Item Entfernen</div>
    <div class="content">
        <form class="ui form">
            <input id="Inventory_dropForm_id" name="id" type="hidden" value="">
                <div class="field">
                    <label>Menge</label>
                    <input type="text" name="amount"  id="Inventory_dropForm_amount" placeholder="" >
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
            $('#Inventory_tradeForm_userId').dropdown({
             apiSettings: {
               url: '{/literal}{$BASEURL}{literal}/v2/user'
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
