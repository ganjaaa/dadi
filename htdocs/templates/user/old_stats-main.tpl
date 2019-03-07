{block name="stats-main"}
<div class="stats">
    <div class="stats__score-box  stats__item--proficiency-bonus">
        <div class="stats__item-title">Proficiency Bonus</div>
        <div class="stats__item-score">{$charsheet.proficiency}</div>
    </div>
    <div class="stats__score-box  stats__item--armor-class">
        <div class="stats__item-title">Armor Class</div>
        <div class="stats__item-score">{$charsheet.ac}</div>
    </div>
    <div class="stats__score-box  stats__item--initiative">
        <div class="stats__item-title">Initiative</div>
        <div class="stats__item-score">{$charsheet.initiative}</div>
    </div>
    <div class="stats__score-box  stats__item--speed">
        <div class="stats__item-title">Speed</div>
        <div class="stats__item-score">{$charsheet.speed}</div>
    </div>
    <div class="stats__score-box stats__item--insp">
        <div class="stats__item-title">Inspiration</div>
        <div class="stats__item-score">{$charsheet.inspiration}</div>
    </div>
    <div class="stats__score-box stats__item--death-saves">
        <div class="stats__item-title">Saves</div>
        <div class="stats__item-score">Sucesses: {$charsheet.deathSuccess}</div>
        <div class="stats__item-score">Fails: {$charsheet.deathFail}</div>
    </div>
    <div class="stats__score-box stats__item--tempHP">
        <div class="stats__item-title">THP/HP/MHP</div>
        <div class="stats__item-score">{$charsheet.tempHp}/{$charsheet.hp}/{$charsheet.maxHp}</div>
    </div>
    <div class="stats__score-box stats__item--hit-dice">
        <div class="stats__item-title">Hit Dice</div>
        <div class="stats__item-score">{$charsheet.hitDice}</div>
    </div>
</div>
{/block}
