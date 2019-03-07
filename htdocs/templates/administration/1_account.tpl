{extends file="1_page.tpl"}
{block name=pageHead}
    <script type="text/javascript" src="/inc/js/gm/account.js"></script>
{/block}
{block name=pageContent}
    <div class="ui one column stackable grid" style="margin: 10px">
        <div class="column">
            <div class="ui segment">
                <button id="btnNewAccount" class="ui label button"><i class="ui plus icon"></i>New Account</button><br><br>
                <table class="ui compact table" cellpadding="0" cellspacing="0" border="0" id="datatableAccount"  style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Active</th>
                            <th>Mail</th>
                            <th>Last IP</th>
                            <th>Last Login</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    {include file="forms/Account.tpl"}
    <script>
        {literal}
            $(document).ready(gmAccount.init());
        {/literal}
    </script>
{/block}
