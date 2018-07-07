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

<div id="Inventory_tradeForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">Item weitergeben</div>
    <div class="content">
        <form class="ui form">
            <input id="Inventory_tradeForm_id" name="id" type="hidden" value="">
            <div class="two fields">
                <div class="field">
                    <label>Benutzer</label>
                    <select id="Inventory_tradeForm_userId" name="userId" class="ui fluid search dropdown" >
                        {foreach from=$listUser item=item}
                            <option value="{$item.id}">{$item.charname}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="field">
                    <label>Menge</label>
                    <input type="text" name="amount"  id="Inventory_tradeForm_amount" placeholder="" >
                </div>
            </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

