var gmMap = {
    init: function (settings) {
        gmMap.config = {
            idCan1: 'canvas1',
            idCan2: 'canvas2',
            idCan3: 'canvas3',
            idUploadField: 'imgInp',
            idButtonPen: 'pen',
            idButtonErasor: 'eraser',
            idButtonLoad: 'loadMap',
            idButtonSave: 'save',
            idSelectEnv: 'saveEnv',
            can1: null,
            can2: null,
            can3: null,
            ctx1: null,
            ctx2: null,
            ctx3: null,
            mode: "pen",
            penRadius: 15,
            penColor: '#000000',
            isDrawing: false,
            imageHeight: 600,
            imageWidth: 800
        };
        $.extend(gmMap.config, settings);

        gmMap.setup();
    },
    setup: function () {
        gmMap.config.can1 = document.getElementById(gmMap.config.idCan1);
        gmMap.config.can2 = document.getElementById(gmMap.config.idCan2);
        gmMap.config.can3 = document.getElementById(gmMap.config.idCan3);
        gmMap.config.ctx1 = gmMap.config.can1.getContext('2d');
        gmMap.config.ctx2 = gmMap.config.can2.getContext('2d');
        gmMap.config.ctx3 = gmMap.config.can3.getContext('2d');

        $("#" + gmMap.config.idUploadField).change(gmMap.changeUploadField);
        $("#" + gmMap.config.idButtonPen).click(gmMap.clickButtonPen);
        $("#" + gmMap.config.idButtonErasor).click(gmMap.clickButtonErasor);
        $("#" + gmMap.config.idButtonSave).click(gmMap.clickButtonSave);
        $("#" + gmMap.config.idSelectEnv).dropdown({
            onChange: gmMap.changeEnv
        });
        gmMap.setupDraw();
    },
    setupDraw: function () {
        gmMap.config.ctx2.fillCircle = gmMap.canvasFullCircle;
        gmMap.config.can2.onmousemove = gmMap.canvasOnMouseMove;
        gmMap.config.can2.onmousedown = gmMap.canvasOnMouseDown;
        gmMap.config.can2.onmouseup = gmMap.canvasOnMouseUp;
    },
    canvasFullCircle: function (x, y, radius, fillColor) {
        this.fillStyle = fillColor;
        this.beginPath();
        this.moveTo(x, y);
        this.arc(x, y, radius, 0, Math.PI * 2, false);
        this.fill();
    },
    canvasOnMouseMove: function (e) {
        if (!gmMap.config.isDrawing) {
            return;
        }

        var x = e.pageX - this.parentNode.offsetLeft;
        var y = e.pageY - this.parentNode.offsetTop;

        if (gmMap.config.mode === "pen") {
            gmMap.config.ctx2.globalCompositeOperation = "source-over";
            gmMap.config.ctx2.fillCircle(x, y, gmMap.config.penRadius, gmMap.config.penColor);
        } else {
            gmMap.config.ctx2.globalCompositeOperation = 'destination-out';
            gmMap.config.ctx2.fillCircle(x, y, gmMap.config.penRadius, gmMap.config.penColor);
        }
    },
    canvasOnMouseDown: function () {
        gmMap.config.isDrawing = true;
    },
    canvasOnMouseUp: function () {
        gmMap.config.isDrawing = false;
    },
    changeUploadField: function () {
        if (this.files && this.files[0]) {
            gmMap.blob2Canvas(gmMap.config.can1, gmMap.config.ctx1, URL.createObjectURL(this.files[0]));
        }
    },
    clickButtonPen: function () {
        gmMap.config.mode = "pen";
    },
    clickButtonErasor: function () {
        gmMap.config.mode = "eraser";
    },
    clickButtonSave: function () {
        gmMap.config.ctx3.drawImage(gmMap.config.can1, 0, 0);
        gmMap.config.ctx3.drawImage(gmMap.config.can2, 0, 0);

        $.ajax({
            url: '/v2/environment/' + $('#' + gmMap.config.idSelectEnv).val(),
            dataType: 'json',
            type: 'POST',
            data: {
                mapBG: gmMap.config.can1.toDataURL(),
                mapShadow: gmMap.config.can2.toDataURL(),
                map: gmMap.config.can3.toDataURL()
            },
            success: function (data) {
                if (data.success) {
                    alert("Karte wurde gepeichert");
                } else {
                    alert(data.message);
                }
            }
        });
    },
    changeEnv:function (value, text, $selectedItem){
        $.ajax({
            url: '/v2/environment/' + value,
            dataType: 'json',
            type: 'GET',
            data: {},
            success: function (data) {
                if (data.success) {
                    gmMap.blob2Canvas(gmMap.config.can1, gmMap.config.ctx1, data.data.mapBG);
                    gmMap.blob2Canvas(gmMap.config.can2, gmMap.config.ctx2, data.data.mapShadow);
                    gmMap.blob2Canvas(gmMap.config.can3, gmMap.config.ctx3, data.data.map);
                } else {
                    alert(data.message);
                }
            }
        });
    },
    blob2Canvas: function (can, ctx, blobtext) {
        var img = new Image();
        img.onload = function () {
            ctx.clearRect(0, 0, can.width, can.height);
            ctx.drawImage(img, 0, 0);
        };
        img.src = blobtext;
    },
};

$(document).ready(gmMap.init);

