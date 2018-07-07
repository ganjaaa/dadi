
<div class="ui four column grid">
    <div class="ui column form">
        <div class="ui raised segment">
            <h3>Race Traits</h3>
            <div class="ui list" style="max-height: 36em;overflow-y: scroll;overflow-x: hidden;">
                {foreach item=trait from=$character.race.trait }
                    {if $trait.name neq "Languages"}  
                        <div class="item">
                            <div class="header">{$trait.name}</div>
                            {$trait.text|nl2br}
                        </div>
                    {/if}
                {/foreach}
            </div>
        </div>
    </div>
    <div class="ui column form">
        <div class="ui raised segment">
            <h3>Class Trais</h3>
            <div class="ui list" style="max-height: 36em;overflow-y: scroll;overflow-x: hidden;">
                {foreach item=lvl from=$character.class.autolevel }
                    {if $lvl._level lte $character.level.level }
                        {foreach item=feature from=$lvl.content }
                            <div class="item">
                                <div class="header">{$feature.name}</div>
                                {$feature.text|nl2br}
                            </div>
                        {/foreach}
                    {/if}
                {/foreach}
            </div>
        </div>
    </div>
    <div class="ui column form">
        <div class="ui raised segment">
            <h3>Other Proficiencies</h3>
            <div class="ui list" style="max-height: 36em;overflow-y: scroll;overflow-x: hidden;">
                {foreach item=trait from=$character.background.trait }
                    <div class="item">
                        <div class="header">{$trait.name}</div>
                        {$trait.text|nl2br}
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
    <div class="ui column form">
        <div class="ui raised segment">
            <h3>Languages</h3>
            <div class="ui list" style="max-height: 36em;overflow-y: scroll;overflow-x: hidden;">
                {foreach item=trait from=$character.race.trait }
                    {if $trait.name eq "Languages"}  
                        <div class="item">
                            <div class="header">{$trait.name}</div>
                            {$trait.text|nl2br}
                        </div>
                    {/if}
                {/foreach}
            </div>
        </div>
    </div>

</div>