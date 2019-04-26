import React from "react";
import { Segment, Icon, Button, Modal, Form } from 'semantic-ui-react';
import ReactTable from "react-table";


class PlayerBackpack extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            ajax: '/api/v1/datatable/inventory',
            loading: false,
            pages: '-1',
            pageSize: 10,
            sorted: [],
            filtered: [],
            data: [],

            selectedId: null,
            maxNumber: 0,
            openDialogTrash: false,
            form_trash_amount: 1,

            openDialogGive: false,
            form_give_amount: 1,
            form_give_target: "",
        };

        this.reloadHandler = this.reloadHandler.bind(this);
        this.changeFormHandler = this.changeFormHandler.bind(this);
        this.changeFormSelectHandler = this.changeFormSelectHandler.bind(this);


        this.openDialogGiveHandler = this.openDialogGiveHandler.bind(this);
        this.closeDialogGiveHandler = this.closeDialogGiveHandler.bind(this);
        this.submitDialogGiveHandler = this.submitDialogGiveHandler.bind(this);

        this.openDialogTrashHandler = this.openDialogTrashHandler.bind(this);
        this.closeDialogTrashHandler = this.closeDialogTrashHandler.bind(this);
        this.submitDialogTrashHandler = this.submitDialogTrashHandler.bind(this);


        this.submitEquipt = this.submitEquipt.bind(this);
        //this.tableMenufunction = this.tableMenufunction.bind(this);
    }

    reloadHandler(e) {
        this.table.fireFetchData();
    }
    changeFormSelectHandler(e, {name, value}) {
        this.setState({[name]: value});
    }
    changeFormHandler(e, {name, value}) {
        if (value <= this.state.maxNumber) {
            this.setState({[name]: value});
        }
        if (value < 1) {
            this.setState({[name]: 1});
    }
    }

    openDialogGiveHandler(e, a) {
        e.preventDefault();
        this.setState({
            openDialogGive: true,
            selectedId: a.oid,
            maxNumber: a.omax
        });
    }
    closeDialogGiveHandler() {
        this.setState({openDialogGive: false});
    }
    submitDialogGiveHandler() {
        var formData = new FormData();
        formData.append('id', this.state.selectedId);
        formData.append('target', this.state.form_give_target);
        formData.append('amount', this.state.form_give_amount);
        fetch('/api/v1/inventory/give/' + this.state.selectedId + '/' + this.state.form_give_target, {method: "POST", body: formData})
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.reloadHandler();
                        this.closeDialogGiveHandler();
                    }
                });
    }

    submitEquipt(e, a) {
        var url = '/api/v1/inventory/' + (a.title === "Equipt" ? 'equipt/' : 'unequipt/') + a.oid
        var formData = new FormData();
        formData.append('id', a.oid);
        fetch(url, {method: "POST", body: formData})
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.reloadHandler();
                        this.props.refreshInfos();
                    }
                });
    }

    openDialogTrashHandler(e, a) {
        e.preventDefault();
        this.setState({
            openDialogTrash: true,
            selectedId: a.oid,
            maxNumber: a.omax
        });
    }
    closeDialogTrashHandler() {
        this.setState({openDialogTrash: false});
    }
    submitDialogTrashHandler() {
        var formData = new FormData();
        formData.append('id', this.state.selectedId);
        formData.append('amount', this.state.form_trash_amount);
        fetch('/api/v1/inventory/drop/' + this.state.selectedId, {method: "POST", body: formData})
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.reloadHandler();
                        this.closeDialogTrashHandler();
                    }
                });
    }
    render() {
        const {openDialogTrash, openDialogGive} = this.state;

        const columns = [{
                Header: '',
                id: 'icon',
                filterable: false,
                sortable: false,
                accessor: d => (<img src={ '/image/' + d.id } style={{height: '30px', width: '30px'}} alt="" />),
                Cell: row => (<div style={{width: '50px'}}>{row.value}</div>),
                minWidth: 50,
                maxWidth: 50
            }, {
                Header: 'Name',
                accessor: 'name',
                filterable: true
            }, {
                Header: 'Description',
                accessor: 'description',
                filterable: true
            }, {
                Header: 'Amount',
                accessor: 'amount',
                filterable: false,
                minWidth: 70,
                maxWidth: 70
            }, {
                Header: 'Weight',
                id: 'weight',
                filterable: false,
                accessor: d => (d.amount * d.weight),
                minWidth: 70,
                maxWidth: 70
            }, {
                Header: 'Settings',
                id: 'settings',
                filterable: false,
                sortable: false,
                minWidth: 150,
                maxWidth: 150,
                accessor: d => (
                            <Button.Group>
                                <Button disabled={ (d.wearable <= 0 || (Number(d.equipt) > 0 && Number(d.cursed) >= 1)) } title={ (d.equipt > 0) ? 'Unequipt' : 'Equipt' } icon color="blue" oid={d.id} omax={d.amount} ocursed={d.cursed} onClick={this.submitEquipt} >
                                    <Icon.Group>
                                        <Icon name='universal access' />
                                        <Icon corner name={ (d.equipt > 0) ? 'minus' : 'plus' } style={{right: '-2px', bottom: '-2px'}} />
                                    </Icon.Group>
                                </Button>
                                <Button disabled={(d.equipt > 0)} title="Give Away" icon color="blue"  oid={d.id} omax={d.amount} onClick={this.openDialogGiveHandler} ><Icon name='sync alternate' /></Button>
                                <Button disabled={(d.equipt > 0)} title="Trash" icon color="red"  oid={d.id} omax={d.amount} onClick={this.openDialogTrashHandler} ><Icon name='trash' /></Button>
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

                    <Modal open={openDialogGive} closeOnEscape={true} closeOnDimmerClick={false} >
                        <Modal.Header>Share Item</Modal.Header>
                        <Modal.Content>
                            <Form.Select fluid label='Target Player' placeholder='Select Option' options={this.props.userlist} value={this.state.form_give_target.toString()} name="form_give_target" onChange={this.changeFormSelectHandler} />
                            <Form.Input fluid label='Amount' placeholder='1' type="number" name="form_give_amount" defaultValue={this.state.form_give_amount} onChange={this.changeFormHandler} />
                        </Modal.Content>
                        <Modal.Actions>
                            <Button negative onClick={this.closeDialogGiveHandler}>Cancel</Button>
                            <Button color='blue' onClick={this.submitDialogGiveHandler}><Icon name='checkmark' />Submit</Button>
                        </Modal.Actions>
                    </Modal>

                    <Modal open={openDialogTrash} closeOnEscape={true} closeOnDimmerClick={false} >
                        <Modal.Header>Are you sure?</Modal.Header>
                        <Modal.Content>
                            How much Items you wanna throw away?
                            <Form.Input fluid label='Amount' placeholder='1' type="number" name="form_trash_amount" defaultValue={this.state.form_trash_amount} onChange={this.changeFormHandler} />
                        </Modal.Content>
                        <Modal.Actions>
                            <Button negative onClick={this.closeDialogTrashHandler}>Cancel</Button>
                            <Button color='blue' onClick={this.submitDialogTrashHandler}><Icon name='checkmark' />Submit</Button>
                        </Modal.Actions>
                    </Modal>
                </Segment>
                )
    }
}

export default PlayerBackpack;
