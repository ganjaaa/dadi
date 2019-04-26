{extends file="1_page.tpl"}
{block name=pageHead}
    <script type="text/javascript" src="/inc/js/gm/objects.js"></script>
{/block}
{block name=pageContent}
    <div class="pusher">
        <div class="ui four column grid">
            <div class="ui column form">
                <h3>Environment</h3>
                <div class="ui raised segment">
                    <div class="ui action fluid input">
                        <input id="searchEnvironment" class="ui input" id="search_field" placeholder="search...">
                        <button id="btnNewEnvironment" class="ui blue icon button"><i class="ui plus icon"></i></button>
                    </div>
                    <div id="listEnvironment" class="ui middle aligned divided list" style="max-height: 38em;overflow-y: scroll;overflow-x: hidden;"></div>
                </div>
            </div>
            <div class="ui column form">
                <h3>Items</h3>
                <div class="ui raised segment">
                    <div class="ui action fluid input">
                        <input id="searchItems" class="ui input" id="search_field" placeholder="search...">
                        <button id="btnNewItems" class="ui blue icon button"><i class="ui plus icon"></i></button>
                    </div>
                    <div id="listItems" class="ui middle aligned divided list" style="max-height: 38em;overflow-y: scroll;overflow-x: hidden;"></div>
                </div>
            </div>
            <div class="ui column form">
                <h3>Spells</h3>
                <div class="ui raised segment">
                    <div class="ui action fluid input">
                        <input id="searchSpells" class="ui input" id="search_field" placeholder="search...">
                        <button id="btnNewSpells" class="ui blue icon button"><i class="ui plus icon"></i></button>
                    </div>
                    <div id="listSpells" class="ui middle aligned divided list" style="max-height: 38em;overflow-y: scroll;overflow-x: hidden;"></div>
                </div>
            </div>
            <div class="ui column form">
                <h3>Monster</h3>
                <div class="ui raised segment">
                    <div class="ui action fluid input">
                        <input id="searchMonster" class="ui input" id="search_field" placeholder="search...">
                        <button id="btnNewMonster" class="ui blue icon button"><i class="ui plus icon"></i></button>
                    </div>
                    <div id="listMonster" class="ui middle aligned divided list" style="max-height: 38em;overflow-y: scroll;overflow-x: hidden;">
                        --- Gibt es nocht nicht ---
                    </div>
                </div>
            </div>
        </div>
    </div>
    {include file="forms/Environment.tpl"}
    {include file="forms/Item.tpl"}
    {include file="forms/Spell.tpl"}
{/block}
