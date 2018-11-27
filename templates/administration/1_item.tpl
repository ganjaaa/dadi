{extends file="1_page.tpl"}
{block name=pageHead}
    <script type="text/javascript" src="/inc/js/gm/items.js"></script>
{/block}
{block name=pageContent}
    <div class="ui one column stackable grid" style="margin: 10px">
        <div class="column">
            <div class="ui segment">
                <button id="btnAddItems" class="ui label button"><i class="ui plus icon"></i>New Item</button><br><br>
                <table class="ui compact table" cellpadding="0" cellspacing="0" border="0" id="datatableItems"  style="width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Beschreibung</th>
                            <th>Modifier</th>
                            <th>Aktionen</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    {include file="forms/Item.tpl"}
    <script>
        $(document).ready(dndItems.init());
    </script>
{/block}
