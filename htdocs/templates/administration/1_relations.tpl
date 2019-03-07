{extends file="1_page.tpl"}
{block name=pageHead}
    <script type="text/javascript" src="/inc/js/gm/relations.js"></script>
{/block}
{block name=pageContent}
    <div class="ui one column stackable grid" style="margin: 10px">
        <div class="column">
            <div class="ui ui form segment">
                <div class="ui field">
                    <input id="treeRelationsSearch" type="text" placeholder="Search...">
                </div>
                <div id="treeRelations">
                    <ul>
                    </ul>
                </div>
                <button id="btnSaveRelations" class="ui blue fluid button">Speichern</button>
            </div>
        </div>
    </div>
    {include file="forms/Features.tpl"}
    {include file="forms/Slots.tpl"}
    {include file="forms/Traits.tpl"}
    <script>
        {literal}
            $(document).ready(gmRelations.init({
                treeDataRelations: [
                    {
                        "id": 2,
                        "text": "Classes",
                        "type": "folder_classes",
                        "children": {/literal}{$listClass}{literal}
                    }, {
                        "id": 3,
                        "text": "Races",
                        "type": "folder_races",
                        "children": {/literal}{$listRace}{literal}
                    }, {
                        "id": 4,
                        "text": "Backgrounds",
                        "type": "folder_backgrounds",
                        "children": {/literal}{$listBackground}{literal}
                    }
                ]
            }));
        {/literal}
    </script>
{/block}
