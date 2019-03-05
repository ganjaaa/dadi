<div id="Features_chooseForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">Wähle Feature</div>
    <div class="content">
        <form class="ui form">
            <input id="Features_chooseForm_id" name="id" type="hidden" value="">
                <div class="field">
                    <label>Name</label>
                    <select id="Features_chooseForm_featureId" name="featureId">                    {$listFeature|default:"<option value=''>-</option>"}                    </select>                </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

<div id="Features_addForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">New Feature</div>
    <div class="content">
        <form class="ui form">
            <input id="Features_addForm_id" name="id" type="hidden" value="">
                <div class="field">
                    <label>Name</label>
                    <input type="text" name="name"  id="Features_addForm_name" placeholder="" >
                </div>
                <div class="field">
                    <label>Description</label>
                    <textarea name="description"  id="Features_addForm_description" placeholder=""></textarea>
                </div>
                <div class="field">
                    <label>Modifier</label>
                    <input type="text" name="modifier"  id="Features_addForm_modifier" placeholder="0" >
                </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

<div id="Features_editForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">Edit Feature</div>
    <div class="content">
        <form class="ui form">
            <input id="Features_editForm_id" name="id" type="hidden" value="">
                <div class="field">
                    <label>Name</label>
                    <input type="text" name="name"  id="Features_editForm_name" placeholder="" >
                </div>
                <div class="field">
                    <label>Description</label>
                    <textarea name="description"  id="Features_editForm_description" placeholder=""></textarea>
                </div>
                <div class="field">
                    <label>Modifier</label>
                    <input type="text" name="modifier"  id="Features_editForm_modifier" placeholder="0" >
                </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

