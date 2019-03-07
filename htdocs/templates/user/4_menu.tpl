<div class="ui top blue inverted menu">
    <div id="vENV1" class="item">{$userSheet.Enviroment.date.time}</div>
    <div id="vENV2" class="item">{$userSheet.Enviroment.day}.{$userSheet.Enviroment.month}.{$userSheet.Enviroment.year} - {$userSheet.Enviroment.date.monthWord}</div>
    <div id="vENV3" class="item">{$userSheet.Enviroment.weather} (Temp:{$userSheet.Enviroment.temperature}°C Hum:{$userSheet.Enviroment.humidity}%) </div>
    <div id="vENV4" class="item">Moon1: <img style="height:20px;width: 20px" title="{$userSheet.Enviroment.date.moon1}" src="/inc/images/moon_{$userSheet.Enviroment.date.moon1}.png">, Moon2: <img style="height:20px;width: 20px" title="{$userSheet.Enviroment.date.moon2}" src="/inc/images/moon_{$userSheet.Enviroment.date.moon2}.png"></div>
    <div id="vENV5" class="item"></div>    
    <div id="vENV6" class="item">Smog: {$userSheet.Enviroment.smog}%</div>    
    <div class="right menu">
        <div id="vChar" class="item">{$userSheet.Charsheet.charname} Lvl {$userSheet.Charsheet.level.level} ({$userSheet.Charsheet.level.exp}/{$userSheet.Charsheet.level.expCap})</div>
        <div class="item">{$account.mail}</div>
        <a  href="/logout" class="item"><i class="sign out icon"></i></a>
    </div>
</div>