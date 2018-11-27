{extends file="1_page.tpl"}
{block name=pageHead}
    <script type="text/javascript" src="/inc/js/gm/map.js"></script>
{/block}
{block name=pageContent}
    <div class="pusher">
        <div class="center aligned container" style="width: 40%;display: block;margin: 0 auto;">
            <div class="ui form">
                <div class="two fields">
                    <div class="field">
                        <label></label>
                        <select class="ui dropdown" id="saveEnv">
                            <option value="">Wähle eine Karte</option>
                            {foreach item=item from=$envList}
                                <option value="{$item.id}">{$item.name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="field">
                        <div class="ui icon buttons">
                            <button id="save" class="ui button"><i class="save icon"></i></button>
                            <button id="pen" class="ui button"><i class="pencil alternate icon"></i></button>
                            <button id="eraser" class="ui button"><i class="eraser icon"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="display: block; width: 801px; margin: 0 auto">
            
            <form id="form1" runat="server">
                Hintergrundbild:<input type='file' id="imgInp" accept="image/png, image/jpeg" />
            </form>
            <div style="position: relative; height: 600px; width: 800px;border: 1px solid black">
                <canvas id="canvas1" width="800" height="600" style="position: absolute; top: 0;left: 0;border: none; z-index: 100"></canvas>
                <canvas id="canvas2" width="800" height="600" style="position: absolute; top: 0;left: 0;border: none; z-index: 200"></canvas>
                <canvas id="canvas3" width="800" height="600" style="position: absolute; top: 0;left: 0;border: none; z-index: 10;visibility: hidden"></canvas>
            </div>
        </div>
    </div>
{/block}
