{extends file="0_html.tpl"}

{block name=pageBody}
    {include file="1_header.tpl"}
    <div class="pusher">
        {block name=pageContent}{/block}
        {include file="1_footer.tpl"}
    </div>
{/block}
