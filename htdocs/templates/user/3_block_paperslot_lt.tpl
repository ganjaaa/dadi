
<div class="ui segment tooltip paperslot" style="left:{$x|default:0}px; top: {$y|default:0}px;" data-position="left center" data-id="{$id|default:0}" data-known="{$knowledge|default:0}" data-variation= "inverted very wide">
    <img class="ui itempic" src="/image/{$id|default:none}"> 
    {if $id gt 0 and $cursed lt 1}
        <div class="ui top right attached blue label" style="padding: 0.2em;">
            <i class="delete unequiptItem icon" style="margin:0" data-id="{$id|default:none}"></i>
        </div>
    {/if} 
    <div class="ui bottom right attached blue label" style="padding: 0.1em;">{$title}</div>
</div>
