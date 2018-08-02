{extends file="system/page.tpl"}
{block name=pageHead}
    <script type="text/javascript" src="/inc/js/gm/spell.js"></script>
{/block}
{block name=pageContent}
    <div class="ui one column stackable grid" style="margin: 10px">
        <div class="column">
            <div class="ui segment">
                <button id="btnAddSpell" class="ui label button"><i class="ui plus icon"></i>New Spell</button><br><br>
                <table class="ui compact table" cellpadding="0" cellspacing="0" border="0" id="datatableSpell"  style="width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    {include file="forms/Spell.tpl"}
    <script>
        $(document).ready(dndSpell.init());
    </script>
{/block}
