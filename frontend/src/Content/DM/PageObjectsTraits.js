import React from "react";
import { Segment, Icon, Button, Modal, Form } from 'semantic-ui-react';
import ReactTable from "react-table";

class PageObjectsTraits extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            ajax: '/v2/datatable/traits',
            api: '/v2/traits',
            loading: false,
            pages: '-1',
            pageSize: 10,
            sorted: [],
            filtered: [],
            data: [],
            formData: {
                id: null,
                name: '',
                description: '',
                modifier: '',
            },
            defaultFormData: {
                id: null,
                name: '',
                description: '',
                modifier: '',
            },
            table: null,
            openDialog: false,
            openDeleteDialog: false,
            selectedID: null,
            edit: false
        };

        this.reloadHandler = this.reloadHandler.bind(this);
        this.openDeleteHandler = this.openDeleteHandler.bind(this);
        this.closeDeleteHandler = this.closeDeleteHandler.bind(this);
        this.submitDeleteHandler = this.submitDeleteHandler.bind(this);
        this.openDialogHandler = this.openDialogHandler.bind(this);
        this.closeDialogHandler = this.closeDialogHandler.bind(this);
        this.changeDialogHandler = this.changeDialogHandler.bind(this);
        this.submitDialogHandler = this.submitDialogHandler.bind(this);
    }

    reloadHandler(e) {
        this.table.fireFetchData();
    }

    openDialogHandler(event, obj) {
        this.setState({
            formData: this.state.defaultFormData
        });

        if (obj.edit === '1') {
            fetch(this.state.api + '/' + obj.oid, {method: "GET"})
                    .then(response => response.json())
                    .then(data => {
                        this.setState({
                            edit: true,
                            selectedID: obj.oid,
                            formData: data.data
                        })
                    });
        }

        this.setState({
            openDialog: true,
        });
    }

    closeDialogHandler() {
        this.setState({
            openDialog: false,
            edit: false,
            selectedID: null
        });
    }

    changeDialogHandler(e, data) {
        this.setState({formData: Object.assign({}, this.state.formData, {[data.uid]: data.value})});
    }

    submitDialogHandler(e) {
        e.preventDefault();
        var formData = new FormData();
        formData.append('name', this.state.formData.name);
        formData.append('description', this.state.formData.description);
        formData.append('modifier', this.state.formData.modifier);

        if (this.state.edit) {
            formData.append('id', this.state.selectedID);
            fetch(this.state.api + '/' + this.state.selectedID, {method: "POST", body: formData})
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.reloadHandler();
                            this.closeDialogHandler();
                        }
                    });
        } else {
            fetch(this.state.api, {method: "POST", body: formData})
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.reloadHandler();
                            this.closeDialogHandler();
                        }
                    });
        }
    }

    openDeleteHandler(event, obj) {
        this.setState({
            openDeleteDialog: true,
            selectedID: obj.oid
        });
    }

    closeDeleteHandler() {
        this.setState({
            openDeleteDialog: false,
            selectedID: null
        });
    }

    submitDeleteHandler(e) {
        e.preventDefault();
        var formData = new FormData();
        formData.append('id', this.state.selectedID);
        fetch(this.state.api + '/' + this.state.selectedID, {method: "DELETE", body: formData})
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.reloadHandler();
                        this.closeDeleteHandler();
                    }
                });
    }

    render() {
        const columns = [
            {Header: 'Name', accessor: 'name', filterable: true},
            {Header: 'Description', accessor: 'description', filterable: true},
            {
                Header: 'Settings',
                id: 'settings',
                filterable: false,
                sortable: false,
                accessor: d => (
                            <Button.Group>
                                <Button icon color="blue" oid={d.id} edit='1' onClick={this.openDialogHandler} ><Icon name='edit' /></Button>
                                <Button icon color="red"  oid={d.id} onClick={this.openDeleteHandler} ><Icon name='trash' /></Button>
                            </Button.Group>
                            )
            }];

        const {edit, formData, openDeleteDialog, openDialog} = this.state;
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

                    <Button fluid color='blue' oid='0' edit='0' onClick={this.openDialogHandler}>Add Feature</Button>

                    <Modal open={openDeleteDialog} closeOnEscape={true} closeOnDimmerClick={false} >
                        <Modal.Header>Are you sure?</Modal.Header>
                        <Modal.Content>Really delete this object? Objects necessary related to this object are also deleted.</Modal.Content>
                        <Modal.Actions>
                            <Button negative onClick={this.closeDeleteHandler}>Cancel</Button>
                            <Button color='blue' onClick={this.submitDeleteHandler}><Icon name='checkmark' />Submit</Button>
                        </Modal.Actions>
                    </Modal>

                    <Modal open={openDialog} closeOnEscape={true} closeOnDimmerClick={false} >
                        <Modal.Header>{(edit ? 'Edit' : 'Add')} Feature</Modal.Header>
                        <Modal.Content>
                            <Form>
                                <Form.Group widths='equal'>
                                    <Form.Input fluid label='Name' placeholder='Im a unique Name' defaultValue={formData.name} uid="name" onChange={this.changeDialogHandler} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.TextArea label='Description' placeholder='' value={formData.description} uid="description" onChange={this.changeDialogHandler} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Input fluid label='Modifier' placeholder='' defaultValue={formData.modifier} uid="modifier" onChange={this.changeDialogHandler} />
                                </Form.Group>
                            </Form>
                        </Modal.Content>
                        <Modal.Actions>
                            <Button negative onClick={this.closeDialogHandler}>Cancel</Button>
                            <Button color='blue' onClick={this.submitDialogHandler} disabled={!this.state.formData.name }><Icon name='checkmark' />Submit</Button>
                        </Modal.Actions>
                    </Modal>
                </Segment>
                )
    }
}

export default PageObjectsTraits;
