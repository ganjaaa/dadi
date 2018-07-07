{extends file="system/page.tpl"}
{block name=pageHead}
    <script type="text/javascript" src="/inc/js/gm/account.js"></script>
{/block}
{block name=pageContent}
    <div class="pusher">
        <div class="ui two column grid">
            <div class="ui column form">
                <h3>1. Wähle ein Benutzer</h3>
                <div class="ui raised segment">
                    <table id="datatableUser" class="ui compact selectable table">
                        <thead><tr><th>Mail</th><th>Name</th><th></th></tr></thead>
                        <tbody></tbody>
                    </table>
                    <button id="btnNewUser" class="ui blue fluid icon button"><i class="ui plus icon"></i> Neuer Benutzer</button>                
                </div>
            </div>
            <div class="ui column form">
                <h3>2. Bearbeite das Inventar</h3>
                <div class="ui raised segment">
                    <table id="datatableInventory" class="ui compact table">
                        <thead><tr><th>Name</th><th>Anzahl</th><th></th></tr></thead>
                        <tbody></tbody>
                    </table>
                    <button id="btnNewInventory" class="ui blue fluid icon button"><i class="ui plus icon"></i> Neuer Gegenstand</button>
                </div>
            </div>
        </div>
    </div>
    {include file="forms/User.tpl"}
    {include file="forms/Inventory.tpl"}
{/block}
