{extends file="system/page.tpl"}
{block name=pageHead}
    <script type="text/javascript" src="/inc/js/user/usersheet.js"></script>
{/block}
{block name=pageContent}
    <div id="tabMenu" class="ui blue top attached tabular menu">
        <a class="active item" data-tab="Stats">Charsheet</a>
        <a class="item" data-tab="Backpack">Backpack</a>
        <a class="item" data-tab="Magic">Magic</a>
        <a class="item" data-tab="Traits">Traits</a>
        <a class="item" data-tab="Quest">Quest Log</a>
        <a class="item" data-tab="Diary">Diary</a>
        <a class="item" data-tab="Map">Map</a>
        <a class="item" data-tab="Log">Logbuch</a>
        <a class="item" data-tab="DEBUG">DEBUG</a>
    </div>
    <div class="ui bottom attached active tab segment" data-tab="Stats">
        {include file="blocks/usersheet_tab_charsheet.tpl"}
    </div>
    <div class="ui bottom attached tab segment" data-tab="Backpack">
        {include file="blocks/usersheet_tab_backpack.tpl"}
    </div>
    <div class="ui bottom attached tab segment" data-tab="Magic">
        {include file="blocks/usersheet_tab_magic.tpl"}
    </div>
    <div class="ui bottom attached tab segment" data-tab="Traits">
        {include file="blocks/usersheet_tab_traits.tpl"}
    </div>
    <div class="ui bottom attached tab segment" data-tab="Quest" style="min-height: 400px">
        {include file="blocks/usersheet_tab_questlog.tpl"}
    </div>
    <div class="ui bottom attached tab segment" data-tab="Diary">
        {include file="blocks/usersheet_tab_diary.tpl"}
    </div>
    <div class="ui bottom attached tab segment" data-tab="Map">
        {include file="blocks/usersheet_tab_map.tpl"}
    </div>
    <div class="ui bottom attached tab segment" data-tab="Log">
        {include file="blocks/usersheet_tab_log.tpl"}
    </div>
    <div class="ui bottom attached tab segment" data-tab="DEBUG">
        {include file="blocks/usersheet_tab_debug.tpl"}
    </div>

    {include file="forms/UserInventory.tpl"}

    <div id="popupMessage" style="display:none; position: fixed; z-index: 9999; bottom: 0; right: 0; height: 50%; width: 33%;">
        <h3 class="ui top attached header">Message<i id="popupMessageCancel" class="ui link remove icon" style="float: right"></i></h3>
        <div class="ui attached segment" style="height: 100%">
            <div id="popupMessageContent" class="ui list">
            </div>
        </div>
    </div>
    <script>
        $(document).ready(dndUsersheet.init({
            firepadConfig: {
                apiKey: "{$colab.firepad.apiKey}",
                authDomain: "{$colab.firepad.authDomain}",
                databaseURL: "{$colab.firepad.databaseURL}",
                projectId: "{$colab.firepad.projectId}",
                storageBucket: "{$colab.firepad.storageBucket}",
                messagingSenderId: "{$colab.firepad.messagingSenderId}",
            }
        }));
    </script>
{/block}
