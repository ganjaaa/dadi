import React from "react";
import { Segment, Icon, Button, Modal, Form } from 'semantic-ui-react';
import ReactTable from "react-table";

class AddEnvironment extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            api: '/v2/environment',
            edit: false,
            open: false,
            data: {
                id: null,
                active: 0,
                mail: '',
                password: '',
                gm: 0
            },
            error: false,
            errorsMail: false,
            errorsPassword: false
        };
        this.close = this.close.bind(this);
        this.open = this.open.bind(this);
        this.submit = this.submit.bind(this);

        if (props.edit) {
            this.state.edit = true;
        }

        this.handleChange = this.handleChange.bind(this);
    }
    close() {
        this.setState({open: false});
        this.props.refreshHandler();
    }
    open() {
        this.setState({open: true});
    }
    submit(e) {
        e.preventDefault();

        var formData = new FormData();
        formData.append('name', this.state.data.name);
        formData.append('time', this.state.data.time);
        formData.append('day', this.state.data.day);
        formData.append('month', this.state.data.month);
        formData.append('year', this.state.data.year);
        formData.append('weather', this.state.data.weather);
        formData.append('temperature', this.state.data.temperature);
        formData.append('humidity', this.state.data.humidity);
        formData.append('smog', this.state.data.smog);
        formData.append('modifier', this.state.data.modifier);

        if (this.state.edit) {
            formData.append('id', this.state.data.id);
            fetch(this.state.api + '/' + this.state.data.id, {method: "POST", body: formData})
                    .then(response => response.json())
                    .then(data => {

                    });
            this.close();
        } else {
            fetch(this.state.api, {method: "POST", body: formData})
                    .then(response => response.json())
                    .then(data => {

                    });
            this.close();
        }
    }
    componentWillMount() {
        this.setState({
            api: '/v2/environment',
            edit: false,
            data: {
                id: null,
                name: '',
                time: '00:00',
                day: 1,
                month: 1,
                year: 1100,
                weather: 'sunny',
                temperature: 24,
                humidity: 50,
                smog: 0,
                modifier: ''
            }
        });

        if (this.props.edit) {
            const newData = this.state.data;
            newData.id = this.props.oid;

            this.setState({
                data: newData,
                edit: true
            })
            fetch(this.state.api + '/' + this.props.oid, {method: "GET"})
                    .then(response => response.json())
                    .then(data => {
                        this.setState({data: data.data})
                    });
        }
    }

    handleChange(e, data) {
        this.setState({data: Object.assign({}, this.state.data, {[data.uid]: data.value})});
        this.validateForm();
    }

    validateForm() {

    }

    render() {
        const {open, edit} = this.state
        const data = this.state.data;

        return (<div>
            {(edit ? <Button icon color="blue" onClick={this.open} ><Icon name='edit' /></Button> : <Button fluid color='blue' onClick={this.open}>Add Environment</Button>)}
            <Modal open={open} onSubmit={this.submit} closeOnEscape={true} closeOnDimmerClick={false} >
                <Modal.Header>{(edit ? 'Edit' : 'Add')} Environment</Modal.Header>
                <Modal.Content>
                    <Form>
                        <Form.Input fluid label='Name' placeholder='0' defaultValue={data.name} uid="name" onChange={this.handleChange} />
                        <Form.Group widths='equal'>
                            <Form.Input fluid label='Day' placeholder='0' defaultValue={data.day} uid="day" onChange={this.handleChange} />
                            <Form.Input fluid label='Month' placeholder='0' defaultValue={data.month} uid="month" onChange={this.handleChange} />
                            <Form.Input fluid label='Year' placeholder='0' defaultValue={data.year} uid="year" onChange={this.handleChange} />
                        </Form.Group>
                        <Form.Group widths='equal'>
                            <Form.Input fluid label='Time' placeholder='0' defaultValue={data.time} uid="time" onChange={this.handleChange} />
                            <Form.Input fluid label='Weather' placeholder='0' defaultValue={data.weather} uid="weather" onChange={this.handleChange} />
                        </Form.Group>
                        <Form.Group widths='equal'>
                            <Form.Input fluid label='Temperature' placeholder='0' defaultValue={data.temperature} uid="temperature" onChange={this.handleChange} />
                            <Form.Input fluid label='Humidity' placeholder='0' defaultValue={data.humidity} uid="humidity" onChange={this.handleChange} />
                            <Form.Input fluid label='Smog' placeholder='0' defaultValue={data.smog} uid="smog" onChange={this.handleChange} />
                            <Form.Input fluid label='Modifier' placeholder='0' defaultValue={data.modifier} uid="modifier" onChange={this.handleChange} />
                        </Form.Group>
                    </Form>
                </Modal.Content>
                <Modal.Actions>
                    <Button negative onClick={this.close}>Cancel</Button>
                    <Button color='blue' onClick={this.submit} disabled={!this.state.data.name }><Icon name='checkmark' />Submit</Button>
                </Modal.Actions>
            </Modal>
        </div>
                );
    }
}

class DeletetObjectItem extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            api: '/v2/environment',
            open: false,
        };
        this.close = this.close.bind(this);
        this.open = this.open.bind(this);
        this.submit = this.submit.bind(this);
    }
    close() {
        this.setState({open: false});
    }
    open() {
        this.setState({open: true});
    }
    submit() {
        var formData = new FormData();
        formData.append('id', this.props.oid);
        fetch(this.state.api + '/' + this.props.oid, {method: "DELETE", body: formData})
                .then(response => response.json())
                .then(data => {
                });
        this.props.refreshHandler();
        this.close();
    }
    render() {
        const {open} = this.state;

        return (
                <div>
                    <Button icon color="red" onClick={this.open} ><Icon name='trash' /></Button>
                    <Modal open={open} closeOnEscape={true} closeOnDimmerClick={false} >
                        <Modal.Header>Are you sure?</Modal.Header>
                        <Modal.Content>Really delete this object? Objects necessary related to this object are also deleted.</Modal.Content>
                        <Modal.Actions>
                            <Button negative onClick={this.close}>Cancel</Button>
                            <Button color='blue' onClick={this.submit}><Icon name='checkmark' />Submit</Button>
                        </Modal.Actions>
                    </Modal>
                </div>
                );
    }
}


class PageEnvironments extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            ajax: '/v2/datatable/environment',
            loading: false,
            pages: '-1',
            pageSize: 10,
            sorted: [],
            filtered: [],
            data: [],
            table: null
        };

        this.reloadHandler = this.reloadHandler.bind(this);
    }

    reloadHandler(e) {
        this.table.fireFetchData();
    }

    render() {
        const columns = [{
                Header: 'ID',
                accessor: 'id', // String-based value accessors!
                filterable: true
            }, {
                Header: 'Name',
                accessor: 'name',
                filterable: true
                        //// Custom cell components!
            }, {
                //id: 'description', // Required because our accessor is not a string
                Header: 'Modifier',
                accessor: 'modifier',
                filterable: true
                        //accessor: d => d.friend.name // Custom value accessors!
            }, {
                Header: 'Settings',
                id: 'settings',
                filterable: false,
                sortable: false,
                accessor: d => (
                            <Button.Group>
                                <AddEnvironment edit={true} oid={d.id} refreshHandler={this.reloadHandler} />
                                <DeletetObjectItem oid={d.id} refreshHandler={this.reloadHandler} />
                            </Button.Group>
                            )
            }];

        return  (
                <Segment>
                    <ReactTable
                        ref={(instance) => {
                                this.table = instance;
                            }}
                        data={this.state.data}
                        columns={columns}
                        pages={this.state.pages}
                        pageSize={this.state.pageSize}
                        loading={this.state.loading}
                        manual
                        onFetchData={(state, instance) => {
                                this.setState({loading: true})
                                var formData = new FormData();
                                formData.append('page', state.page);
                                formData.append('pageSize', state.pageSize);
                                formData.append('sorted', JSON.stringify(state.sorted));
                                formData.append('filtered', JSON.stringify(state.filtered));
                                fetch(this.state.ajax, {method: "POST", body: formData})
                                        .then(response => response.json())
                                        .then(data => {
                                            this.setState({
                                                data: data.data,
                                                pages: data.pages,
                                                pageSize: data.pageSize,
                                                loading: false
                                            })
                                        });
                            }}
                        />
                    <AddEnvironment refreshHandler={this.reloadHandler} />
                </Segment>
                )
    }
}

export default PageEnvironments;

