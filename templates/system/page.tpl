{extends file="system/html.tpl"}

{block name=pageBody}
    {include file="system/header.tpl"}
    <div class="pusher">
        {block name=pageContent}{/block}
        {include file="system/footer.tpl"}
    </div>
{/block}
