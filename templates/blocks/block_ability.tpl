<div class="ui raised segment" style="width:90%; margin-bottom: 0">
    <div class="ui small header">{$name}</div>
    <div class="ui header" style="margin-top: 0; margin-bottom:0">{if $modifier ge 0}+{/if}{$modifier}</div>
    {if !empty($value)}<div class="ui bottom right attached blue label">{$value}</div>{/if}
</div>

