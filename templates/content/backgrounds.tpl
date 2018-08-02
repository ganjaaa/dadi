{extends file="system/page.tpl"}
{block name=pageHead}
    <!--script type="text/javascript" src="/inc/js/gm/spell.js"></script-->
{/block}
{block name=pageContent}
    <div class="ui one column stackable grid" style="margin: 10px">
        <div class="column">
            <div class="ui segment">
                <button id="btnAddSpell" class="ui label button"><i class="ui plus icon"></i>New Background</button><br><br>
                <table class="ui compact table" cellpadding="0" cellspacing="0" border="0" id="datatableSpell"  style="width: 100%;">
                    <thead>
                        <tr>
                       
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        //$(document).ready(dndSpell.init());
    </script>
{/block}
