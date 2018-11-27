<div class="ui top blue inverted menu">
    <div id="vENV1" class="item">{$environment.date.time}</div>
    <div id="vENV2" class="item">{$environment.day}.{$environment.month}.{$environment.year} - {$environment.date.monthWord}</div>
    <div id="vENV3" class="item">{$environment.weather} (Temp:{$environment.temperature}°C Hum:{$environment.humidity}%) </div>
    <div id="vENV4" class="item">Moon1: <img style="height:20px;width: 20px" title="{$environment.date.moon1}" src="/inc/images/moon_{$environment.date.moon1}.png">, Moon2: <img style="height:20px;width: 20px" title="{$environment.date.moon2}" src="/inc/images/moon_{$environment.date.moon2}.png"></div>
    <div id="vENV5" class="item"></div>    
    <div id="vENV6" class="item">Smog: {$environment.smog}%</div>    
    <div class="right menu">
        <div id="vChar" class="item">{$character.charname} Lvl {$character.level.level} ({$character.level.exp}/{$character.level.expCap})</div>
        <div class="item">{$account.mail}</div>
        <a  href="/logout" class="item"><i class="sign out icon"></i></a>
    </div>
</div>