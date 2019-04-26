{extends file="1_page.tpl"}
{block name=pageHead}
    <script type="text/javascript" src="/inc/js/gm/dashboard.js"></script>
{/block}
{block name=pageContent}
    <div class="pusher">
        <div class="ui three column grid">
            <div class="ui column form">
                <div class="ui raised segment">
                    <table id="datatableUser" class="ui compact table">
                        <thead><tr><th>Mail</th><th>Name</th></tr></thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="ui raised segment">
                    <table id="datatableEnv" class="ui compact table">
                        <thead><tr><th>Name</th></tr></thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="ui column form">
                <div class="ui raised segment">
                    <!-- User -->
                    <div id="userOptions" class="" style="display:none">
                        <div class="ui header">Für <span class="data"></span></div>
                        <div class="ui fluid vertical labeled icon buttons">
                            <button id="userExp" class="ui button"><i class="plus icon"></i>Manage EXP</button>
                            <button id="userItem" class="ui button"><i class="plus icon"></i>Add Item</button>
                            <button id="userMoney" class="ui button"><i class="money icon"></i>Manage Money</button>
                            <button id="userMessage" class="ui button"><i class="announcement  icon"></i>Send Message</button>
                            <button id="userReload" class="ui button"><i class="refresh icon"></i>Force Reload</button>
                            <button id="userHP" class="ui button"><i class="exchange alternate icon"></i>Add/Remove HP</button>
                            <button id="userFullHP" class="ui button"><i class="plus icon"></i>Full HP</button>
                        </div>
                    </div>
                    <!-- ENV -->
                    <div id="envOptions" class="" style="display:none">
                        <div class="ui header">For <span class="data"></span></div>
                        <div class="ui labeled fluid input">
                            <div class="ui label">Time</div>
                            <input id="envZeit" class="ui input" type="text">
                            <button id="btnAddEnvZeit" class="ui right attached icon button"><i class="save icon"></i></button>
                        </div>
                        <div class="ui labeled fluid input">
                            <div class="ui label">Date</div>
                            <input id="envDatum" class="ui input" type="text">
                            <button id="btnAddEnvDatum" class="ui right attached icon button"><i class="save icon"></i></button>
                        </div>
                        <div class="ui labeled fluid input">
                            <div class="ui label">Weather</div>
                            <input id="envWetter" class="ui input" type="text">
                            <button id="btnAddEnvWetter" class="ui right attached icon button"><i class="save icon"></i></button>
                        </div>
                        <div class="ui labeled fluid input">
                            <div class="ui label">Temperature</div>
                            <input id="envTemperatur" class="ui input" type="text">
                            <button id="btnAddEnvTemperatur" class="ui right attached icon button"><i class="save icon"></i></button>
                        </div>
                        <div class="ui labeled fluid input">
                            <div class="ui label">Humidity</div>
                            <input id="envHumidity" class="ui input" type="text">
                            <button id="btnAddEnvHumidity" class="ui right attached icon button"><i class="save icon"></i></button>
                        </div>
                        <div class="ui labeled fluid input">
                            <div class="ui label">Smog</div>
                            <input id="envSmog" class="ui input" type="text">
                            <button id="btnAddEnvSmog" class="ui right attached icon button"><i class="save icon"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ui column form">
                <div class="ui raised segment">
                    <div class="ui statistic">
                        <div id="staticDice" class="value">-</div>
                        <div class="label">Last Roll</div>
                    </div>
                    <div class="ui divider"></div>
                    <div id="statisticsGroup" class="ui mini statistics">
                        <div class="statistic"><div class="value" style="color: rgb(27, 28, 29);">-</div><div class="label" style="color: rgb(27, 28, 29);">W-</div></div>
                    </div>
                    <div class="ui fluid blue labeled icon buttons">
                        <div class="ui button bdice" data-value="4"><i class="ui cube icon"></i>w4</div>
                        <div class="ui button bdice" data-value="6"><i class="ui cube icon"></i>w6</div>
                        <div class="ui button bdice" data-value="8"><i class="ui cube icon"></i>w8</div>
                    </div>
                    <div class="ui fluid blue labeled icon buttons">
                        <div class="ui button bdice" data-value="10"><i class="ui cube icon"></i>w10</div>
                        <div class="ui button bdice" data-value="12"><i class="ui cube icon"></i>w12</div>
                        <div class="ui button bdice" data-value="20"><i class="ui cube icon"></i>w20</div>
                    </div>
                </div>
                <div class="ui raised segment">
                    <!-- Global -->
                    <div class="ui header">For All</div>
                    <div class="ui fluid vertical labeled icon buttons">
                        <button id="globalExp" class="ui button"><i class="plus icon"></i>Manage EXP</button>
                        <button id="globalItem" class="ui button"><i class="plus icon"></i>Add Item</button>
                        <button id="globalMoney" class="ui button"><i class="money icon"></i>Manage Money</button>
                        <button id="globalMessage" class="ui button"><i class="announcement  icon"></i>Send Message</button>
                        <button id="globalReload" class="ui button"><i class="refresh icon"></i>Force Reload</button>
                        <button id="globalHP" class="ui button"><i class="exchange alternate icon"></i>Add/Remove HP</button>
                        <button id="globalFullHP" class="ui button"><i class="plus icon"></i>Full HP</button>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    {include file="forms/Inventory.tpl"}
    {include file="forms/UserMoney.tpl"}

    <div id="modalMessage" class="ui modal">
        <i class="close icon"></i>
        <div class="header">Message</div>
        <form class="ui content form">
            <input id="modalMessageTarget" type="hidden">
            <div class="field">
                <label>Message</label>
                <input id="modalMessageValue" type="text">
                <small>HTML allowed</small>
            </div>
        </form>
        <div class="actions">
            <div class="ui button">Cancel</div>
            <div class="ui positive button">Submit</div>
        </div>
    </div>

    <div id="modalExp" class="ui modal">
        <i class="close icon"></i>
        <div class="header">Experience</div>
        <form class="ui content form">
            <input id="modalExpTarget" type="hidden">
            <div class="field">
                <label>Exp</label>
                <input id="modalExpValue" name="exp" type="text">
                <small>Bitte nur Zahlen! Die Anzahl wird nicht aufgeteilt, jeder bekommt die eingegebene Summe.</small>
            </div>
        </form>
        <div class="actions">
            <div class="ui button">Cancel</div>
            <div class="ui positive button">Absenden</div>
        </div>
    </div>

    <div id="modalHP" class="ui modal">
        <i class="close icon"></i>
        <div class="header">HP</div>
        <form class="ui content form">
            <input id="modalExpTarget" type="hidden">
            <div class="field">
                <label>HP</label>
                <input id="modalHPValue" name="hp" type="text">
                <small>Bitte nur Zahlen! Die Anzahl wird nicht aufgeteilt, jeder bekommt die eingegebene Summe.</small>
            </div>
        </form>
        <div class="actions">
            <div class="ui button">Cancel</div>
            <div class="ui positive button">Absenden</div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            dndDashboard.init();
        });
    </script>
{/block}
