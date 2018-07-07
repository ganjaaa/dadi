{extends file="system/page.tpl"}
{block name=pageHead}
    <script type="text/javascript" src="/inc/js/gm/map.js"></script>
{/block}
{block name=pageContent}
    <div class="pusher">
         <div class="ui buttons">
            <button id="pen" class="ui button">Pen</button>
            <button id="eraser" class="ui button">Eraser</button>
            <button id="save" class="ui button">save</button>
            <button id="loadMap" class="ui button">load</button>
        </div>
        <div class="ui field">
            <label>Speichern nach</label>
            <select id="saveEnv">
                {foreach item=item from=$envList}
                    <option value="{$item.id}">{$item.name}</option>
                {/foreach}
            </select>
        </div>
             <form id="form1" runat="server">
            <input type='file' id="imgInp" accept="image/png, image/jpeg" />
        </form>
         <div style="position: relative; height: 600px; width: 800px;border: 1px solid black">
            <canvas id="canvas1" width="800" height="600" style="position: absolute; top: 0;left: 0;border: none; z-index: 100"></canvas>
            <canvas id="canvas2" width="800" height="600" style="position: absolute; top: 0;left: 0;border: none; z-index: 200"></canvas>
            <canvas id="canvas3" width="800" height="600" style="position: absolute; top: 0;left: 0;border: none; z-index: 10;visibility: hidden"></canvas>
        </div>
       
        
       
    </div>
{/block}
