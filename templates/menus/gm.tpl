<div class="ui top blue inverted menu">
    <a href="/" class="item"><i class="dashboard icon"></i>Dashboard</a>
    <a href="/account" class="item"><i class="user icon"></i>Accounts & Inventory</a>
    <a href="/environment" class="item"><i class="globe icon"></i>Environment</a>
    <a href="/map" class="item"><i class="map icon"></i>Maps</a>

    <div class="ui mainmenu dropdown item">
        Basic Objects
        <i class=" dropdown icon"></i>
        <div class="menu">
            <a href="/item" class="item"><i class="cubes icon"></i>Items</a>
            <a href="/spell" class="item"><i class="magic icon"></i>Spells</a>
            <a href="/races" class="item"><i class="bug icon"></i>Races</a>
            <a href="/classes" class="item"><i class="shield alternate icon"></i>Classes</a>
            <a href="/backgrounds" class="item"><i class="user md icon"></i>Backgrounds</a>
            <a href="/features" class="item"><i class="tag icon"></i>Features</a>
            <a href="/traits" class="item"><i class="cogs icon"></i>Traits</a>
        </div>
    </div>

    <div class="right menu">
        <div class="item">{$VERSIONCO} - {$VERSIONNO} {$VERSIONTY}</div>
        <a  href="/logout" class="item"><i class="sign out icon"></i></a>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.ui.mainmenu.dropdown').dropdown();
    });

</script>