import React from "react";
import { Segment, Icon, Button, Modal, Form } from 'semantic-ui-react';
import ReactTable from "react-table";

class AddSpell extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            api: '/v2/spell',
            edit: false,
            open: false,
            data: {
                id: null,
                name: '',
                description: '',
                level: '0',
                school: '',
                time: '',
                range: '',
                components: '',
                duration: '',
                classes: '',
                roll: '',
                ritual: ''
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
        this.setState({
            open: true,
            data: {
                id: null,
                name: '',
                description: '',
                level: '0',
                school: '',
                time: '',
                range: '',
                components: '',
                duration: '',
                classes: '',
                roll: '',
                ritual: ''
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
                        this.forceUpdate();
                    });
        }
    }
    submit(e) {
        e.preventDefault();

        var formData = new FormData();
        formData.append('name', this.state.data.name);
        formData.append('description', this.state.data.description);
        formData.append('level', this.state.data.level);
        formData.append('school', this.state.data.school);
        formData.append('time', this.state.data.time);
        formData.append('range', this.state.data.range);
        formData.append('components', this.state.data.components);
        formData.append('duration', this.state.data.duration);
        formData.append('classes', this.state.data.classes);
        formData.append('roll', this.state.data.roll);
        formData.append('ritual', this.state.data.ritual);

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
            {(edit ? <Button icon color="blue" onClick={this.open} ><Icon name='edit' /></Button> : <Button fluid color='blue' onClick={this.open}>Add Spell</Button>)}
            <Modal open={open} onSubmit={this.submit} closeOnEscape={true} closeOnDimmerClick={false} >
                <Modal.Header>{(edit ? 'Edit' : 'Add')} Spell</Modal.Header>
                <Modal.Content>
                    <Form>
                        <Form.Group widths='equal'>
                            <Form.Input fluid label='Name' placeholder='Magisches Spell' defaultValue={data.name} uid="name" onChange={this.handleChange} />
                            <Form.Input fluid label='Level' placeholder='0' defaultValue={data.level} uid="level" onChange={this.handleChange} />
                        </Form.Group>
                        <Form.TextArea label='Description' placeholder='' value={data.description} uid="description" onChange={this.handleChange} />
                        <Form.Group widths='equal'>
                            <Form.Input fluid label='School' placeholder='0' defaultValue={data.school} uid="school" onChange={this.handleChange} />
                            <Form.Input fluid label='Cast-Time' placeholder='0' defaultValue={data.time} uid="time" onChange={this.handleChange} />
                            <Form.Input fluid label='Range' placeholder='0' defaultValue={data.range} uid="range" onChange={this.handleChange} />
                            <Form.Input fluid label='Components' placeholder='0' defaultValue={data.components} uid="components" onChange={this.handleChange} />
                        </Form.Group>
                        <Form.Group widths='equal'>
                            <Form.Input fluid label='Duration' placeholder='0' defaultValue={data.duration} uid="duration" onChange={this.handleChange} />
                            <Form.Input fluid label='Classes' placeholder='0' defaultValue={data.time} uid="classes" onChange={this.handleChange} />
                            <Form.Input fluid label='Roll' placeholder='0' defaultValue={data.roll} uid="roll" onChange={this.handleChange} />
                            <Form.Input fluid label='Ritual' placeholder='0' defaultValue={data.ritual} uid="ritual" onChange={this.handleChange} />
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

class DeletetObjectSpell extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            api: '/v2/spell',
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


class PageObjectsSpells extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            ajax: '/v2/datatable/spell',
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
                Header: 'Name',
                accessor: 'name', // String-based value accessors!
                filterable: true
            }, {
                Header: 'Description',
                accessor: 'description',
                filterable: true
                        //// Custom cell components!
            }, {
                Header: 'Settings',
                id: 'settings',
                filterable: false,
                sortable: false,
                accessor: d => (
                            <Button.Group>
                                <AddSpell edit={true} oid={d.id} refreshHandler={this.reloadHandler} />
                                <DeletetObjectSpell oid={d.id} refreshHandler={this.reloadHandler} />
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
                    <AddSpell refreshHandler={this.reloadHandler} />
                </Segment>
                )
    }
}

export default PageObjectsSpells;

