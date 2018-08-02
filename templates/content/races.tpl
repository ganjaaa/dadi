{extends file="system/page.tpl"}
{block name=pageHead}
    <script type="text/javascript" src="/inc/js/gm/races.js"></script>
{/block}
{block name=pageContent}
    <div class="ui one column stackable grid" style="margin: 10px">
        <div class="column">
            <div class="ui segment">
                <button id="btnAddRace" class="ui label button"><i class="ui plus icon"></i>New Race</button><br><br>
                <table class="ui compact table" cellpadding="0" cellspacing="0" border="0" id="datatableRace"  style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Speed</th>
                            <th>Ability</th>
                            <th>Proficiency</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(dndRaces.init());
    </script>
{/block}
