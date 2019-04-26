<div id="Account_addForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">Account anlegen</div>
    <div class="content">
        <form class="ui form">
            <input id="Account_addForm_id" name="id" type="hidden" value="">
            <div class="two fields">
                <div class="field">
                    <label>Aktiv</label>
                    <select id="Account_addForm_active" name="active">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Admin LVL</label>
                    <select id="Account_addForm_gm" name="gm">                        <option value="0">Normaler User</option>                        <option value="1">Admin</option>                        <option value="2">Super Admin</option>                    </select>                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>E-Mail</label>
                    <input type="text" name="mail"  id="Account_addForm_mail" placeholder="max@mustermann.de" >
                </div>
                <div class="field">
                    <label>Password</label>
                    <input type="password" name="password"  id="Account_addForm_password" placeholder="*******" >
                </div>
            </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

<div id="Account_editForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">Account bearbeiten</div>
    <div class="content">
        <form class="ui form">
            <input id="Account_editForm_id" name="id" type="hidden" value="">
            <div class="two fields">
                <div class="field">
                    <label>Aktiv</label>
                    <select id="Account_editForm_active" name="active">                        <option value="0">Nein</option>                        <option value="1">Ja</option>                    </select>                </div>
                <div class="field">
                    <label>Admin LVL</label>
                    <select id="Account_editForm_gm" name="gm">                        <option value="0">Normaler User</option>                        <option value="1">Admin</option>                        <option value="2">Super Admin</option>                    </select>                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>E-Mail</label>
                    <input type="text" name="mail"  id="Account_editForm_mail" placeholder="max@mustermann.de" >
                </div>
                <div class="field">
                    <label>Password</label>
                    <input type="password" name="password"  id="Account_editForm_password" placeholder="*******" >
                </div>
            </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

