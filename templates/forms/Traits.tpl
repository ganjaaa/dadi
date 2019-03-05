<div id="Traits_addForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">New Trait</div>
    <div class="content">
        <form class="ui form">
            <input id="Traits_addForm_id" name="id" type="hidden" value="">
                <div class="field">
                    <label>Name</label>
                    <input type="text" name="name"  id="Traits_addForm_name" placeholder="" >
                </div>
                <div class="field">
                    <label>Description</label>
                    <textarea name="description"  id="Traits_addForm_description" placeholder=""></textarea>
                </div>
                <div class="field">
                    <label>Modifier</label>
                    <input type="text" name="modifier"  id="Traits_addForm_modifier" placeholder="0" >
                </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

<div id="Traits_editForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">Edit Trait</div>
    <div class="content">
        <form class="ui form">
            <input id="Traits_editForm_id" name="id" type="hidden" value="">
                <div class="field">
                    <label>Name</label>
                    <input type="text" name="name"  id="Traits_editForm_name" placeholder="" >
                </div>
                <div class="field">
                    <label>Description</label>
                    <textarea name="description"  id="Traits_editForm_description" placeholder=""></textarea>
                </div>
                <div class="field">
                    <label>Modifier</label>
                    <input type="text" name="modifier"  id="Traits_editForm_modifier" placeholder="0" >
                </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

