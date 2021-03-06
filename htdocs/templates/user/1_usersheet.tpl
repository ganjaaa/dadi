{extends file="1_page.tpl"}
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
    <div class="ui bottom attached active tab " data-tab="Stats">
        {include file="user/2_usersheet_tab_charsheet.tpl"}
    </div>
    <div class="ui bottom attached tab " data-tab="Backpack">
        {include file="user/2_usersheet_tab_backpack.tpl"}
    </div>
    <div class="ui bottom attached tab " data-tab="Magic">
        {include file="user/2_usersheet_tab_magic.tpl"}
    </div>
    <div class="ui bottom attached tab " data-tab="Traits">
        {include file="user/2_usersheet_tab_traits.tpl"}
    </div>
    <div class="ui bottom attached tab " data-tab="Quest" style="min-height: 400px">
        {include file="user/2_usersheet_tab_questlog.tpl"}
    </div>
    <div class="ui bottom attached tab " data-tab="Diary">
        {include file="user/2_usersheet_tab_diary.tpl"}
    </div>
    <div class="ui bottom attached tab " data-tab="Map">
        {include file="user/2_usersheet_tab_map.tpl"}
    </div>
    <div class="ui bottom attached tab " data-tab="Log">
        {include file="user/2_usersheet_tab_log.tpl"}
    </div>
    <div class="ui bottom attached tab " data-tab="DEBUG">
        {include file="user/2_usersheet_tab_debug.tpl"}
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
        $(document).ready(dndUsersheet.init());
    </script>
{/block}
