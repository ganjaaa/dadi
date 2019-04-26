import React from "react";
import { Segment, Icon, Button, Modal, Form, Checkbox } from 'semantic-ui-react';
import ReactTable from "react-table";

class AddAccount extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            api: '/v2/account',
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
    submit(e) {
        e.preventDefault();

        var formData = new FormData();
        formData.append('active', this.state.data.active);
        formData.append('gm', this.state.data.gm);
        formData.append('mail', this.state.data.mail);

        if (this.state.data.password.length > 0) {
            formData.append('password', this.state.data.password);
        }

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
        if (this.state.data.password.length > 0 && this.state.data.password.length < 8) {
            this.setState({errorsPassword: true});
        } else {
            this.setState({errorsPassword: false});
        }
        if (this.state.data.mail.length === 0) {
            this.setState({errorsMail: true});
        } else {
            this.setState({errorsMail: false});
        }
    }

    render() {
        const {open, edit} = this.state
        const data = this.state.data;
        const chooseBool = [
            {text: 'Yes', value: '1'},
            {text: 'No', value: '0'},
        ];

        return (
                <div>
                    {(edit ? <Button icon color="blue" onClick={this.open} ><Icon name='edit' /></Button> : <Button fluid color='blue' onClick={this.open}>Add Account</Button>)}
                    <Modal open={open} onSubmit={this.submit} closeOnEscape={true} closeOnDimmerClick={false} >
                        <Modal.Header>{(edit ? 'Edit' : 'Add')} Account</Modal.Header>
                        <Modal.Content>
                            <Form>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='Active*' placeholder="Select Option" options={chooseBool} value={data.active} uid="active" onChange={this.handleChange} />
                                    <Form.Select fluid label='Admin*' placeholder="Select Option" options={chooseBool} value={data.gm} uid="gm" onChange={this.handleChange} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Input fluid label='E-Mail*' placeholder='0' defaultValue={data.mail} uid="mail" onChange={this.handleChange} error={this.state.errorsMail} />
                                    <Form.Input fluid label='Password' placeholder='0' defaultValue="" uid="password" type='password' onChange={this.handleChange} error={this.state.errorsPassword} />
                                </Form.Group>
                            </Form>
                        </Modal.Content>
                        <Modal.Actions>
                            <Button negative onClick={this.close}>Cancel</Button>
                            <Button color='blue' onClick={this.submit} disabled={!this.state.data.mail }><Icon name='checkmark' />Submit</Button>
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
            api: '/v2/account',
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

class PageAccounts extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            ajax: '/v2/datatable/account',
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
                Header: 'Active',
                accessor: 'active', // String-based value accessors!
                filterable: true,
                Cell: props => <Checkbox toggle disabled defaultChecked={(Number.parseInt(props.value) >= 1)} />
            }, {
                Header: 'Mail',
                accessor: 'mail',
                filterable: true
                        //// Custom cell components!
            }, {
                //id: 'description', // Required because our accessor is not a string
                Header: 'Last IP',
                accessor: 'lastIp',
                filterable: true
                        //accessor: d => d.friend.name // Custom value accessors!
            }, {
                Header: 'Last Login',
                accessor: 'lastLogin',
                filterable: true
                        //Header: props => <span>Friend Age</span>, // Custom header components!
                        //accessor: 'friend.age'
            }, {
                Header: 'Settings',
                id: 'settings',
                filterable: false,
                sortable: false,
                accessor: d => (
                            <Button.Group>
                                <AddAccount edit={true} oid={d.id} refreshHandler={this.reloadHandler} />
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
                                                loading: false
                                            })
                                        });
                            }}
                        />
                    <AddAccount refreshHandler={this.reloadHandler} />
                </Segment>
                );
    }
}

export default PageAccounts;

