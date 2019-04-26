import React from "react";
import { Segment, Icon, Button, Form } from 'semantic-ui-react';
import FileBase64 from 'react-file-base64';

class PageMapsMaps extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            api: '/v2/environment',
            isDrawing: false,
            lastX: 0,
            lastY: 0,
            hue: 1,
            direction: true,
            controlDisplay: "none",
            controlLeft: "100%",
            customColor: true,
            color: "#000000",
            customStroke: true,
            maxWidth: 100,
            minWidth: 5,
            mode: 'pen',
            brushsize: 10,
            data: [],
            chooseMaps: [],
            selectedMap: '0',
            width: 770,
            height: 570
        };
        this.draw = this.draw.bind(this);
        this.toggleControls = this.toggleControls.bind(this);
        this.getFiles = this.getFiles.bind(this);
        this.changeMapHandler = this.changeMapHandler.bind(this);
        this.saveMapHandler = this.saveMapHandler.bind(this);
        this.changeBrushSize = this.changeBrushSize.bind(this);
        this.changeMode = this.changeMode.bind(this);


    }

    canvas() {
        return document.querySelector("#canvas2");
    }

    ctx() {
        return this.canvas().getContext("2d");
    }

    setBackground(blobString) {
        var can = document.querySelector("#canvas1");
        var ctx = can.getContext("2d");

        var img = new Image();
        img.onload = function () {
            ctx.clearRect(0, 0, can.width, can.height);

            var iw = img.width;
            var ih = img.height;
            var scale = Math.min((770 / iw), (569 / ih));
            var iwScaled = iw * scale;
            var ihScaled = ih * scale;

            can.width = iwScaled;
            can.height = ihScaled;
            ctx.drawImage(img, 0, 0, iwScaled, ihScaled);
        };
        img.src = blobString;
    }

    setForeground(blobString) {
        var can = document.querySelector("#canvas2");
        var ctx = can.getContext("2d");

        var img = new Image();
        img.onload = function () {
            ctx.clearRect(0, 0, can.width, can.height);

            var iw = img.width;
            var ih = img.height;
            var scale = Math.min((770 / iw), (569 / ih));
            var iwScaled = iw * scale;
            var ihScaled = ih * scale;

            can.width = iwScaled;
            can.height = ihScaled;
            ctx.drawImage(img, 0, 0, iwScaled, ihScaled);
        };
        img.src = blobString;
    }

    componentDidMount() {
        const canvas = this.canvas()
        const ctx = this.ctx()
        if (this.props.fullscreen === true) {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        ctx.strokeStyle = "#BADA55";
        ctx.lineJoin = "round";
        ctx.lineCap = "round";
        ctx.lineWidth = Number(this.state.minWidth) + 1;

        fetch(this.state.api, {method: "GET"})
                .then(response => response.json())
                .then(data => {
                    var arr = [];
                    for (var key in data.data) {
                        arr.push({text: data.data[key].name, value: data.data[key].id});
                    }

                    this.setState({
                        data: data.data,
                        chooseMaps: arr
                    });

                });
    }

    draw(e) {
        const ctx = this.ctx();

        if (this.state.isDrawing) {
            ctx.lineJoin = "round";
            ctx.lineCap = "round";
            if (this.state.mode !== 'eraser') {
                ctx.globalCompositeOperation = "source-over";
            } else {
                ctx.globalCompositeOperation = "destination-out";
            }
            ctx.strokeStyle = this.state.color;
            //ctx.lineWidth = this.state.brushsize;
            ctx.lineWidth = Number(this.state.brushsize) + 1;
            ctx.beginPath();
            ctx.moveTo(this.state.lastX, this.state.lastY);
            ctx.lineTo(e.nativeEvent.offsetX, e.nativeEvent.offsetY);
            ctx.stroke();
            this.setState({
                lastX: e.nativeEvent.offsetX,
                lastY: e.nativeEvent.offsetY
            })
        }
    }
    toggleControls() {
        let onScreen = this.state.controlLeft;
        let display = this.state.controlDisplay;
        const fade = () => {
            onScreen === "0%" ? (this.setState({controlLeft: "100%"})) : (this.setState({controlLeft: "0%"}))
        }
        if ((display === "none" && onScreen === "100%") || (display === "block" && onScreen === "0%")) {
            if (display === "none") {
                this.setState({controlDisplay: "block"});
                setTimeout(() => fade(), 0);
            } else {
                fade();
                setTimeout(() => this.setState({controlDisplay: "none"}), 500);
            }
        }
    }
    getFiles(files) {
        this.setBackground(files.base64);
        this.setState({selectedBG: files.base64});
    }
    changeBrushSize(e, data) {
        e.preventDefault();
        this.setState({brushsize: data.value});
    }
    changeMode(e, data) {
        e.preventDefault();
        this.setState({mode: data.setmode});
    }
    changeMapHandler(e, data) {
        this.setBackground("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=");
        this.setForeground("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=");

        this.setState({selectedMap: data.value});
        fetch(this.state.api + '/' + data.value, {method: "GET"})
                .then(response => response.json())
                .then(data => {
                    this.setBackground(data.data.mapBG);
                    this.setForeground(data.data.mapShadow);
                });
    }
    saveMapHandler(e, data) {
        e.preventDefault();
        var can1 = document.querySelector("#canvas1");
        var can2 = document.querySelector("#canvas2");

        var formData = new FormData();
        formData.append('mapBG', can1.toDataURL("image/png"));
        formData.append('mapShadow', can2.toDataURL("image/png"));

        fetch(this.state.api + '/' + this.state.selectedMap, {method: "POST", body: formData})
                .then(response => response.json())
                .then(data => {

                });
    }
    render() {
        return (
                <div className="pusher">
                    <div className="center aligned container" style={{width: '40%', display: 'block', margin: '0 auto'}}>
                        <Form>
                            <Form.Group widths='equal'>
                                <Form.Select style={{zIndex: 900}} fluid label='Choose your Map' placeholder='Choose your Map' options={this.state.chooseMaps} value={this.state.selectedMap.toString()} onChange={this.changeMapHandler} />
                                <Button.Group>
                                    <Button icon onClick={this.saveMapHandler}><Icon name='save' /></Button>
                                    <Button icon active={this.state.mode === 'pen'} setmode='pen' onClick={this.changeMode} ><Icon name='pencil alternate' /></Button>
                                    <Button icon active={this.state.mode === 'eraser'} setmode='eraser' onClick={this.changeMode} ><Icon name='eraser'/></Button>
                                </Button.Group>
                                <Form.Input fluid label='Brush Size' type='number' defaultValue={this.state.brushsize} onChange={this.changeBrushSize} />
                            </Form.Group>
                        </Form>
                    </div>
                    <div style={{display: 'block', width: '801px', margin: '0 auto'}}>
                        <Segment raised >
                            <div style={{position: 'relative', height: (this.state.height + 'px'), width: (this.state.width + 'px'), border: '1px solid black'}}>
                                <canvas id="canvas1"
                                        width={this.state.width}
                                        height={this.state.height}
                                        style={{position: 'absolute', top: 0, left: 0, border: 'none', zIndex: 100}} />
                                <canvas id="canvas2"
                                        width={this.state.width}
                                        height={this.state.height}
                                        onMouseMove={this.draw}
                                        onMouseDown={(e) => {
                                                this.setState({
                                                    isDrawing: true,
                                                    lastX: e.nativeEvent.offsetX,
                                                    lastY: e.nativeEvent.offsetY
                                                })
                                            }}
                                        onMouseUp={ () => this.setState({isDrawing: false})}
                                        onMouseOut={ () => this.setState({isDrawing: false})}
                                        style={{position: 'absolute', top: 0, left: 0, border: 'none', zIndex: 200}} />
                                <canvas id="canvas3"
                                        width={this.state.width}
                                        height={this.state.height}
                                        style={{position: 'absolute', top: 0, left: 0, border: 'none', zIndex: 10, visibility: 'hidden'}} />
                
                            </div>
                            <FileBase64 multiple={ false } onDone={ this.getFiles.bind(this) } />
                        </Segment>
                    </div>
                </div>
                )
    }
}

export default PageMapsMaps;
