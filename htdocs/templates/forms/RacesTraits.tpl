<div id="RacesTraits_chooseForm" class="ui modal">
    <i class="close icon"></i>
    <div class="header">Wähle Feature</div>
    <div class="content">
        <form class="ui form">
            <input id="RacesTraits_chooseForm_id" name="id" type="hidden" value="">
                <div class="field">
                    <label></label>
                    <input type="hidden" name="raceId"  id="RacesTraits_chooseForm_raceId" placeholder="" >
                </div>
                <div class="field">
                    <label>Name</label>
                    <select id="RacesTraits_chooseForm_traitId" name="traitId">                    {$listTraits|default:"<option value=''>-</option>"}                    </select>                </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui black approve button" data-kind="1">Speichern</div>
        <div class="ui red deny button">Abbrechen</div>
    </div>
</div>

