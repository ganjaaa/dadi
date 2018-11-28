{extends file="1_page.tpl"}
{block name=pageHead}
    <script type="text/javascript" src="/inc/js/gm/backgrounds.js"></script>
{/block}
{block name=pageContent}
    <div class="ui one column stackable grid" style="margin: 10px">
        <div class="column">
            <div class="ui segment">
                <button id="btnAddBackgrounds" class="ui label button"><i class="ui plus icon"></i>New Background</button><br><br>
                <table class="ui compact table" cellpadding="0" cellspacing="0" border="0" id="datatableBackgrounds"  style="width: 100%;">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Proficiency</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    {include file="forms/Backgrounds.tpl"}
    {include file="forms/BackgroundsTraits.tpl"}
    <script>
        $(document).ready(dndBackgrounds.init());
    </script>
{/block}
