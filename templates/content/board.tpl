{extends file="system/page.tpl"}
{block name=pageHead}

    <script type="text/javascript" src="/inc/js/chessboard-0.3.0.js"></script>
    <script type="text/javascript" src="/inc/js/gm/board.js"></script>
{/block}
{block name=pageContent}
    <div class="pusher">
        <div class="center aligned container" style="width: 40%;display: block;margin: 0 auto;">
            as
            <div id="board" style="width: 400px"></div>
        </div>
        <script>
            var board = ChessBoard('board', {
                draggable: true,
                dropOffBoard: 'trash',
                sparePieces: true
            });
        </script>
    </div>
{/block}
