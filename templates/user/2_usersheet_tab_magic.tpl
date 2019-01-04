<h3 class="ui center aligned header">Your Spell Ability: {$userSheet.Magic.1.modifier}</h3>

<div class="ui three column doubling grid container">
    <div class="ten wide column">
        <div class="ui styled accordion">
            {for $foo=0 to 9}
                <div class="title">
                    <i class="dropdown icon"></i>
                    0/{$userSheet.Magic.1.slots.$foo} - {if $foo eq 0}Cantrips{else}Level {$foo}{/if}
                </div>
                <div class="content">
                    -- Leer
                </div>
            {/for}
        </div>
    </div>
    <div class="six wide column">
        <table id="datatableSpellbook" class="ui compact celled definition table" style="width: 100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Spell</th>
                    <th>Optionen</th>
                </tr>
            </thead>
            <tbody>
                {foreach item=value from=$userSheet.Magic.List}

                    <tr>
                        <td><i class="ui spell info icon" data-id="{$value.id}" data-variation="very wide" style="cursor: pointer"></i></td>
                        <td>
                            {$value.name}
                            <div id="tooltip-spell-{$value.id}" style="display: none">
                                <h2>{$value.name}</h2>
                                CastingTime: {$value.time}<br>
                                Duration: {$value.duration}<br>
                                <hr>
                                {$value.description}
                            </div>
                        </td>
                        <td>
                            <button class="moveSpell ui icon button"><i class="ui blue left arrow icon"></i></button>
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</div>



