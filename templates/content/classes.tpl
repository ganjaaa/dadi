{extends file="system/page.tpl"}
{block name=pageHead}
    <script type="text/javascript" src="/inc/js/gm/classes.js"></script>
{/block}
{block name=pageContent}
    <div class="ui one column stackable grid" style="margin: 10px">
        <div class="column">
            <div class="ui segment">
                <button id="btnAddClasses" class="ui label button"><i class="ui plus icon"></i>New Race</button><br><br>
                <table class="ui compact table" cellpadding="0" cellspacing="0" border="0" id="datatableClasses"  style="width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>HD</th>
                            <th>Proficiency</th>
                            <th>Spell Ability</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    {include file="forms/Classes.tpl"}
    <script>
        $(document).ready(dndClasses.init());
    </script>
{/block}
