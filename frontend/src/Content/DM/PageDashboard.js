import React from "react";
import { Grid, Segment, Table, Button, Radio, Modal, Input, Form, Dropdown, Statistic, Divider, Header } from 'semantic-ui-react';

class FormDashboardSimpleModal extends React.Component {
    state = {modalOpen: false, value: ''}

    handleChange = (e, { name, value }) => this.setState(
                {[name]: value}
        )

    handleOpen = () => this.setState(
                {modalOpen: true}
        )

    handleClose = () => this.setState(
                {modalOpen: false}
        )

    handleSubmit = () => {
        var formData = new FormData();
        formData.append('value', this.state.value);
        fetch(this.props.url, {method: "POST", body: formData})
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.handleClose();
                    }
                });
    }

    render() {
        const trigger = <Button onClick={this.handleOpen} icon={this.props.icon} content={this.props.title} />
        return (
                <Modal trigger={trigger} open={this.state.modalOpen} onClose={this.handleClose} size='small' >
                    <Modal.Header>{this.props.title}</Modal.Header>
                    <Modal.Content>
                        <Input fluid placeholder='Wert' name='value' value={this.state.value} onChange={this.handleChange} />
                    </Modal.Content>
                    <Modal.Actions>
                        <Button onClick={this.handleClose} negative>Abort</Button>
                        <Button onClick={this.handleSubmit} positive labelPosition='right' icon='checkmark' content='Submit' />
                    </Modal.Actions>
                </Modal>
                )
    }
}

class FormDashboardItemModal extends React.Component {
    state = {
        modalOpen: false,
        isFetching: false,
        multiple: true,
        searchQuery: null,
        value: '',
        options: [],
    }

    handleChange = (e, { value }) => this.setState(
                {value}
        )
    handleSearchChange = (e, { searchQuery }) => this.setState(
                {searchQuery}
        )

    fetchOptions = () => {
        this.setState({isFetching: true})
        fetch('/', {method: "GET"})
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.setState({isFetching: false})
                    }
                });
    }

    handleOpen = () => this.setState(
                {modalOpen: true}
        )

    handleClose = () => this.setState(
                {modalOpen: false}
        )

    handleSubmit = () => {
        var formData = new FormData();
        formData.append('value', this.state.value);
        fetch(this.props.url, {method: "POST", body: formData})
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.handleClose();
                    }
                });
    }

    render() {
        const {options, isFetching, value} = this.state

        const trigger = <Button onClick={this.handleOpen} icon={this.props.icon} content={this.props.title} />
        return (
                <Modal trigger={trigger} open={this.state.modalOpen} onClose={this.handleClose} size='small' >
                    <Modal.Header>{this.props.title}</Modal.Header>
                    <Modal.Content>
                        <Input fluid label="Count" placeholder='Wert' name='value' value={this.state.value} onChange={this.handleChange} />
                        <Dropdown
                            label="Item"
                            fluid
                            selection
                            multiple={false}
                            search={true}
                            options={options}
                            value={value}
                            placeholder='Select Item'
                            onChange={this.handleChange}
                            onSearchChange={this.handleSearchChange}
                            disabled={isFetching}
                            loading={isFetching}
                            />
                    </Modal.Content>
                    <Modal.Actions>
                        <Button onClick={this.handleClose} negative>Abort</Button>
                        <Button onClick={this.handleSubmit} positive labelPosition='right' icon='checkmark' content='Submit' />
                    </Modal.Actions>
                </Modal>
                )
    }
}

class FormDashboardMoney extends React.Component {
    state = {
        modalOpen: false,
        cp: '',
        sp: '',
        ep: '',
        gp: '',
        pp: '',
    }

    handleChange = (e, { name, value }) => this.setState(
                {[name]: value}
        )

    handleOpen = () => this.setState(
                {modalOpen: true}
        )

    handleClose = () => this.setState(
                {modalOpen: false}
        )

    handleSubmit = () => {
        var formData = new FormData();
        formData.append('cp', this.state.cp);
        formData.append('sp', this.state.sp);
        formData.append('ep', this.state.ep);
        formData.append('gp', this.state.gp);
        formData.append('pp', this.state.pp);
        fetch(this.props.url, {method: "POST", body: formData})
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.handleClose();
                    }
                });
    }

    render() {
        const trigger = <Button onClick={this.handleOpen} icon={this.props.icon} content={this.props.title} />
        return (
                <Modal trigger={trigger} open={this.state.modalOpen} onClose={this.handleClose} size='small' >
                    <Modal.Header>{this.props.title}</Modal.Header>
                    <Modal.Content>
                        <Form>
                            <Form.Group widths='equal'>
                                <Form.Input fluid label="CP" placeholder='CP' name='cp' value={this.state.cp} onChange={this.handleChange} />
                                <Form.Input fluid label="SP" placeholder='SP' name='sp' value={this.state.sp} onChange={this.handleChange} />
                                <Form.Input fluid label="EP" placeholder='EP' name='ep' value={this.state.ep} onChange={this.handleChange} />
                                <Form.Input fluid label="GP" placeholder='GP' name='gp' value={this.state.gp} onChange={this.handleChange} />
                                <Form.Input fluid label="PP" placeholder='PP' name='pp' value={this.state.pp} onChange={this.handleChange} />
                            </Form.Group>
                        </Form>
                    </Modal.Content>
                    <Modal.Actions>
                        <Button onClick={this.handleClose} negative>Abort</Button>
                        <Button onClick={this.handleSubmit} positive labelPosition='right' icon='checkmark' content='Submit' />
                    </Modal.Actions>
                </Modal>
                )
    }
}


class DashboardMenu extends React.Component {
    state = {
        change: 0,
        saved: ''
    }

    constructor(props) {
        super(props);
        this.clickCommand = this.clickCommand.bind(this);
        this.clickSave = this.clickSave.bind(this);
        this.handleChange = this.handleChange.bind(this);
    }

    static getDerivedStateFromProps(props, state) {
        if (props.select !== state.select) {
            state.select = props.select;
            state.change = 1;
        }
        if (props.typ !== state.typ) {
            state.typ = props.typ;
            state.change = 1;
        }
        if (props.typ === "E") {
            if (state.change === 1) {
                state.id = props.dataE[props.select].id;
                state.time = props.dataE[props.select].time;
                state.day = props.dataE[props.select].day;
                state.month = props.dataE[props.select].month;
                state.year = props.dataE[props.select].year;
                state.weather = props.dataE[props.select].weather;
                state.temperature = props.dataE[props.select].temperature;
                state.humidity = props.dataE[props.select].humidity;
                state.smog = props.dataE[props.select].smog;
                state.change = 0;
                state.date = state.day + '.' + state.month + '.' + state.year;
            }
        }
        return state;
    }

    clickCommand(e) {
        var formData = new FormData();
        fetch(e.currentTarget.dataset.url, {method: "POST", body: formData})
                .then(result => result.json())
                .then(result => {
                    this.setState({
                        dataCharacter: result.data
                    });
                });
    }

    handleChange(event, x, o) {
        var stateObject = {};
        stateObject[event.target.name] = event.target.value;

        if (event.target.name === "date") {
            var spl = event.target.value.split(".", 3);
            if (spl.length === 3) {
                stateObject.day = spl[0];
                stateObject.month = spl[1];
                stateObject.year = spl[2];
            }
        }
        this.setState(stateObject);
    }

    clickSave(e, o) {
        e.preventDefault();
        var formData = new FormData();

        console.log(this.state);
        if (o.target === "date") {
            formData.append('day', this.state.day);
            formData.append('month', this.state.month);
            formData.append('year', this.state.year);
        } else {
            formData.append(o.target, this.state[o.target]);
        }
        fetch("/api/v2/environment/" + this.state.id, {method: "POST", body: formData})
                .then(result => result.json())
                .then(result => {
                    this.setState({
                        saved: result.success
                    });
                });
    }

    render() {
        var css = {};
        if (this.state.saved === true) {
            css = {backgroundColor: '#baffba'};
            setTimeout(function () { this.setState({saved: ''});}.bind(this), 1000);
        }
        if (this.state.saved === false) {
            css = {backgroundColor: '#ffbaba'};
            setTimeout(function () { this.setState({saved: ''});}.bind(this), 1000);
        }
        if (this.props.typ === "C") {
            if (this.props.select !== "A") {
                return (
                        <div id="userOptions" style={css} >
                            <Header as="h3">For <span className="data">{ this.props.dataC[this.props.select].charname }</span></Header>
                            <Button.Group fluid vertical labeled icon>
                                <FormDashboardSimpleModal icon="plus" title="Manage EXP" url={"/api/v2/dashboard/exp/" + this.props.dataC[this.props.select].id} />
                                <FormDashboardItemModal icon='plus' title='Add Item' url={"/api/v2/dashboard/item/" + this.props.dataC[this.props.select].id}  />
                                <FormDashboardMoney icon='money' title='Manage Money' url={"/api/v2/dashboard/money/" + this.props.dataC[this.props.select].id} />
                                <FormDashboardSimpleModal icon="announcement" title="Send Message" url={"/api/v2/dashboard/msg/" + this.props.dataC[this.props.select].id} />
                                <Button icon='refresh' content='Force Reload' data-url={"/api/v2/dashboard/reload/" + this.props.dataC[this.props.select].id} onClick={this.clickCommand} />
                                <FormDashboardSimpleModal icon="heart outline" title="Add/Remove HP" url={"/api/v2/dashboard/hp/" + this.props.dataC[this.props.select].id} />
                                <Button icon='plus' content='Full HP' data-url={"/api/v2/dashboard/rest/" + this.props.dataC[this.props.select].id} onClick={this.clickCommand} />
                            </Button.Group>
                        </div>
                        );
            } else {
                return (
                        <div style={css}>
                            <Header as="h3">For All</Header>
                            <Button.Group fluid vertical labeled icon>
                                <FormDashboardSimpleModal icon="plus" title="Manage EXP" url="/api/v2/dashboard/exp" />
                                <FormDashboardItemModal icon='plus' title='Add Item' url={"/api/v2/dashboard/item"}  />
                                <FormDashboardMoney icon='money' title='Manage Money' url={"/api/v2/dashboard/money"} />
                                <FormDashboardSimpleModal icon="announcement" title="Send Message" url="/api/v2/dashboard/msg" />
                                <Button icon='refresh' content='Force Reload' data-url={"/api/v2/dashboard/reload"} onClick={this.clickCommand} />
                                <FormDashboardSimpleModal icon="heart outline" title="Add/Remove HP" url="/api/v2/dashboard/hp" />
                                <Button icon='plus' content='Full HP' data-url={"/api/v2/dashboard/rest"} onClick={this.clickCommand} />
                            </Button.Group>
                        </div>
                        );
            }
        }
        if (this.props.typ === "E") {
            return (
                    <Form style={css}>
                        <Header as="h3">For <span className="data">{ this.props.dataE[this.props.select].name }</span></Header>
                        <div className="ui labeled fluid input">
                            <div className="ui label" style={{minWidth: "25%"}}>Time</div>
                            <Input placeholder='00:00' name='time' value={this.state.time} onChange={this.handleChange} />
                            <Button icon='save' target="time" onClick={this.clickSave} />
                        </div>
                        <div className="ui labeled fluid input">
                            <div className="ui label" style={{minWidth: "25%"}}>Date</div>
                            <Input placeholder='' name='date' value={this.state.date} onChange={this.handleChange} />
                            <Button icon='save' target="date" onClick={this.clickSave} />
                        </div>
                        <div className="ui labeled fluid input">
                            <div className="ui label" style={{minWidth: "25%"}}>Weather</div>
                            <Input placeholder='' name='weather' value={this.state.weather} onChange={this.handleChange} />
                            <Button icon='save' target="weather" onClick={this.clickSave} />
                        </div>
                        <div className="ui labeled fluid input">
                            <div className="ui label" style={{minWidth: "25%"}}>Temp.</div>
                            <Input placeholder='' name='temperature' value={this.state.temperature} onChange={this.handleChange} />
                            <Button icon='save' target="temperature" onClick={this.clickSave} />
                        </div>
                        <div className="ui labeled fluid input">
                            <div className="ui label" style={{minWidth: "25%"}}>Humidity</div>
                            <Input placeholder='' name='humidity' value={this.state.humidity} onChange={this.handleChange} />
                            <Button icon='save' target="humidity" onClick={this.clickSave} />
                        </div>
                        <div className="ui labeled fluid input">
                            <div className="ui label" style={{minWidth: "25%"}}>Smog</div>
                            <Input placeholder='' name='smog' value={this.state.smog} onChange={this.handleChange} />
                            <Button icon='save' target="smog" onClick={this.clickSave}  />
                        </div>
                    </Form>
                    );
        }
        return (<div />);
    }
}

class DashboardDice extends React.Component {
    state = {
        last: {
            sides: '-',
            value: '-'
        },
        history: []
    }

    constructor(props) {
        super(props);
        this.clickDice = this.clickDice.bind(this);
    }

    clickDice(e) {
        var formData = new FormData();
        fetch(e.currentTarget.dataset.url, {method: "POST", body: formData})
                .then(result => result.json())
                .then(result => {
                    this.setState({
                        last: result.data
                    });
                    var x = this.state.history;
                    if (x.length === 6) {
                        x.pop();
                    }
                    x.unshift(result.data);
                    this.setState({
                        history: x
                    });
                });
        return false;
    }

    render() {
        return (
                <div>
                    <Statistic>
                        <Statistic.Value>{this.state.last.value}</Statistic.Value>
                        <Statistic.Label>Last Roll</Statistic.Label>
                    </Statistic>
                    <Divider />
                    <Statistic.Group size='mini'>
                        {this.state.history.map((obj, i) => {
                                        return (
                                                <Statistic key={i} style={{opacity: (1 - (i / 10))}}>
                                                    <Statistic.Value>{obj.value}</Statistic.Value>
                                                    <Statistic.Label>W{obj.sides}</Statistic.Label>
                                                </Statistic>
                                                )
                                    })}
                    </Statistic.Group>
                    <Button.Group fluid>
                        <Button color="blue" icon='cube' content="w4" data-url={"/api/v2/dashboard/dice/4"} onClick={this.clickDice} />
                        <Button color="blue" icon='cube' content="w6" data-url={"/api/v2/dashboard/dice/6"} onClick={this.clickDice} />
                        <Button color="blue" icon='cube' content="w8" data-url={"/api/v2/dashboard/dice/8"} onClick={this.clickDice} />
                    </Button.Group>
                    <Button.Group fluid>
                        <Button color="blue" icon='cube' content="w10" data-url={"/api/v2/dashboard/dice/10"} onClick={this.clickDice} />
                        <Button color="blue" icon='cube' content="w12" data-url={"/api/v2/dashboard/dice/12"} onClick={this.clickDice} />
                        <Button color="blue" icon='cube' content="w20" data-url={"/api/v2/dashboard/dice/20"} onClick={this.clickDice} />
                    </Button.Group>
                </div>
                );
    }
}


class PageDashboard extends React.Component {
    constructor(props) {
        super(props);
        this.handleRadioSelect = this.handleRadioSelect.bind(this)
    }

    state = {
        dataCharacter: [],
        dataEnvironment: [],
        selectedObject: 'A',
        selectedTyp: 'C'
    };
    componentWillUnmount() {
        this.setState({
            dataCharacter: [],
            dataEnvironment: []
        });
    }

    componentDidMount() {
        fetch("/api/v2/dashboard/character")
                .then(result => result.json())
                .then(result => {
                    this.setState({
                        dataCharacter: result.data
                    });
                });
        fetch("/api/v2/dashboard/environment")
                .then(result => result.json())
                .then(result => {
                    this.setState({
                        dataEnvironment: result.data
                    });
                });
    }

    handleRadioSelect(e, { value, typ }) {
        return this.setState({selectedObject: value, selectedTyp: typ});
    }

    render() {
        const tableCharacter = this.state.dataCharacter.map((entry, index) => {
            return (
                    <Table.Row key={index}>
                        <Table.Cell><Radio name='selectedObj' value={index} typ="C" checked={this.state.selectedObject === index && this.state.selectedTyp === 'C' } onChange={this.handleRadioSelect} /></Table.Cell>
                        <Table.Cell>{entry.charname}</Table.Cell>
                    </Table.Row>
                    );
        });
        const tableEnvironment = this.state.dataEnvironment.map((entry, index) => {
            return (
                    <Table.Row key={index}>
                        <Table.Cell><Radio name='selectedObj' value={index} typ="E"  checked={this.state.selectedObject === index && this.state.selectedTyp === 'E'} onChange={this.handleRadioSelect} /></Table.Cell>
                        <Table.Cell>{entry.name}</Table.Cell>
                    </Table.Row>
                    );
        });
        return (
                <Grid stackable>
                    <Grid.Row columns={3}>
                        <Grid.Column>
                            <Segment raised>
                                <Table compact>
                                    <Table.Header>
                                        <Table.Row>
                                            <Table.HeaderCell colSpan='2'>Character</Table.HeaderCell>
                                        </Table.Row>
                                    </Table.Header>
                                    <Table.Body>
                                        <Table.Row key='A'>
                                            <Table.Cell><Radio name='selectedObj' value="A" typ="C" checked={this.state.selectedObject === "A" && this.state.selectedTyp === 'C'} onChange={this.handleRadioSelect} /></Table.Cell>
                                            <Table.Cell>Alle</Table.Cell>
                                        </Table.Row>
                                        {tableCharacter}
                                    </Table.Body>
                                </Table>
                            </Segment>
                            <Segment raised>
                                <Table id="datatableEnv" compact>
                                    <Table.Header>
                                        <Table.Row>
                                            <Table.HeaderCell  colSpan='2'>Environment</Table.HeaderCell>
                                        </Table.Row>
                                    </Table.Header>
                                    <Table.Body>
                                        {tableEnvironment}
                                    </Table.Body>
                                </Table>
                            </Segment>
                        </Grid.Column>
                        <Grid.Column>
                            <Segment raised>
                                <DashboardMenu typ={this.state.selectedTyp} select={this.state.selectedObject} dataC={this.state.dataCharacter} dataE={this.state.dataEnvironment} />
                            </Segment>
                        </Grid.Column>
                        <Grid.Column>
                            <Segment raised>
                                <DashboardDice />
                            </Segment>
                        </Grid.Column>
                    </Grid.Row>
                </Grid>
                );
    }
}



export default PageDashboard;
