Design fehlt noch / Scalierung
<div class="ui segment" style="max-height: 36em;">
    <canvas id="map1" width="800" height="600" style=""></canvas>
    <br>
    <script>
        var blobtext = "{$environment.map}";
        var img = new Image();
        var can = document.getElementById("map1");
        var ctx = can.getContext('2d');
        {literal}
            img.onload = function () {
                ctx.clearRect(0, 0, can.width, can.height);
                ctx.drawImage(img, 0, 0);
            };
            img.src = blobtext;
        {/literal}
    </script>
</div>
