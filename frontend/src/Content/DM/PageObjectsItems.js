import React from "react";
import { Segment, Icon, Button, Modal, Form } from 'semantic-ui-react';
import ReactTable from "react-table";

class PageObjectsItems extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            ajax: '/v2/datatable/item',
            api: '/v2/item',
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
                weight: '0',
                priceCP: '0',
                priceSP: '0',
                priceEP: '0',
                priceGP: '00',
                pricePP: '0',
                magic: '0',
                type: '$',
                rarity: '',
                ac: '0',
                strength: '0',
                stealth: '0',
                modifier: '',
                roll: '',
                dmg1: '',
                dmg2: '',
                dmgType: '',
                property: '',
                range: '',
                wearable: '0',
                cursed: '0',
                stackable: '1'
            },
            defaultFormData: {
                id: null,
                name: '',
                description: '',
                weight: '0',
                priceCP: '0',
                priceSP: '0',
                priceEP: '0',
                priceGP: '00',
                pricePP: '0',
                magic: '0',
                type: '$',
                rarity: '',
                ac: '0',
                strength: '0',
                stealth: '0',
                modifier: '',
                roll: '',
                dmg1: '',
                dmg2: '',
                dmgType: '',
                property: '',
                range: '',
                wearable: '0',
                cursed: '0',
                stackable: '1'
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
                        });
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
        formData.append('weight', this.state.formData.weight);
        formData.append('priceCP', this.state.formData.priceCP);
        formData.append('priceSP', this.state.formData.priceSP);
        formData.append('priceEP', this.state.formData.priceEP);
        formData.append('priceGP', this.state.formData.priceGP);
        formData.append('pricePP', this.state.formData.pricePP);
        formData.append('magic', this.state.formData.magic);
        formData.append('type', this.state.formData.type);
        formData.append('rarity', this.state.formData.rarity);
        formData.append('ac', this.state.formData.ac);
        formData.append('strength', this.state.formData.strength);
        formData.append('stealth', this.state.formData.stealth);
        formData.append('modifier', this.state.formData.modifier);
        formData.append('roll', this.state.formData.roll);
        formData.append('dmg1', this.state.formData.dmg1);
        formData.append('dmg2', this.state.formData.dmg2);
        formData.append('dmgType', this.state.formData.dmgType);
        formData.append('property', this.state.formData.property);
        formData.append('range', this.state.formData.range);
        formData.append('wearable', this.state.formData.wearable);
        formData.append('cursed', this.state.formData.cursed);
        formData.append('stackable', this.state.formData.stackable);

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
                                <Button icon color="blue" oid={d.id} edit='1' onClick={this.openDialogHandler} ><Icon name='edit' /></Button>
                                <Button icon color="red"  oid={d.id} onClick={this.openDeleteHandler} ><Icon name='trash' /></Button>
                            </Button.Group>
                            )
            }];

        const {edit, formData, openDeleteDialog, openDialog} = this.state;

        const chooseBool = [
            {text: 'Yes', value: '1'},
            {text: 'No', value: '0'},
        ];
        const chooseType = [
            {value: '$', text: 'Money'},
            {value: 'HA', text: 'Heavy_Armor'},
            {value: 'LA', text: 'Light_Armor'},
            {value: 'MA', text: 'Medium_Armor'},
            {value: 'A', text: 'Ammunition'},
            {value: 'G', text: 'Adventuring_Gear'},
            {value: 'W', text: 'Wondrous'},
            {value: 'S', text: 'Schild'},
            {value: 'M', text: 'Melee_Weapon'},
            {value: 'R', text: 'Range_Weapons'},
            {value: 'P', text: 'Potion'},
            {value: 'RD', text: 'Rod'},
            {value: 'RG', text: 'Ring'},
            {value: 'SC', text: 'Scroll'},
            {value: 'ST', text: 'Staff'},
            {value: 'WD', text: 'Wand'}
        ];
        const chooseRarity = [
            {value: '0', text: 'COMMON'},
            {value: '1', text: 'UNCOMMON'},
            {value: '2', text: 'RARE'},
            {value: '3', text: 'VERY_RARE'},
            {value: '4', text: 'EPIC'},
            {value: '5', text: 'LEGENDARY'},
            {value: '6', text: 'UNIQUE'}
        ];
        const chooseWear = [
            {value: '0', text: 'NONE'},
            {value: '1', text: 'QUIVER'},
            {value: '2', text: 'HELMET'},
            {value: '3', text: 'CAPE'},
            {value: '4', text: 'NECKLACE'},
            {value: '5', text: 'GLOVES'},
            {value: '6', text: 'RING'},
            {value: '7', text: 'ARMOR'},
            {value: '8', text: 'WEAPON'},
            {value: '9', text: 'OFF HAND'},
            {value: '10', text: 'BELT'},
            {value: '11', text: 'BOOTS'}
        ];

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
                            <Form ref={(instance) => {this.from = instance;}}>
                        <Form.Group widths='equal'>
                            <Form.Input fluid label='Name' placeholder='Magisches Item' defaultValue={formData.name} uid="name" onChange={this.changeDialogHandler} />
                            <Form.Input fluid label='Weight' placeholder='0.0' defaultValue={formData.weight} uid="weight" onChange={this.changeDialogHandler} />
                        </Form.Group>
                        <Form.TextArea label='Description' placeholder='' value={formData.description} uid="description" onChange={this.changeDialogHandler} />
                        <Form.Group widths='equal'>
                            <Form.Input fluid label='Price CP' placeholder='0' defaultValue={formData.priceCP} uid="priceCP" onChange={this.changeDialogHandler} />
                            <Form.Input fluid label='Price SP' placeholder='0' defaultValue={formData.priceSP} uid="priceSP" onChange={this.changeDialogHandler} />
                            <Form.Input fluid label='Price EP' placeholder='0' defaultValue={formData.priceEP} uid="priceEP" onChange={this.changeDialogHandler} />
                            <Form.Input fluid label='Price GP' placeholder='0' defaultValue={formData.priceGP} uid="priceGP" onChange={this.changeDialogHandler} />
                            <Form.Input fluid label='Price PP' placeholder='0' defaultValue={formData.pricePP} uid="pricePP" onChange={this.changeDialogHandler} />
                        </Form.Group>
                        <Form.Group widths='equal'>
                            <Form.Select fluid label='Magic' placeholder="Select Option" options={chooseBool} value={formData.magic.toString()} uid="magic" onChange={this.changeDialogHandler} />
                            <Form.Select fluid label='Type' placeholder="Select Option" options={chooseType} value={formData.type.toString()} uid="type" onChange={this.changeDialogHandler}  />
                            <Form.Select fluid label='Rarity' placeholder="Select Option"  options={chooseRarity} value={formData.rarity.toString()} uid="rarity" onChange={this.changeDialogHandler} />
                            <Form.Input fluid label='AC' placeholder='0' defaultValue={formData.ac} uid="ac" onChange={this.changeDialogHandler} />
                        </Form.Group>
                        <Form.Group widths='equal'>
                            <Form.Input fluid label='Strength' placeholder='0' defaultValue={formData.strength} uid="strength" onChange={this.changeDialogHandler} />
                            <Form.Input fluid label='Stealth' placeholder='0' defaultValue={formData.stealth} uid="stealth" onChange={this.changeDialogHandler} />
                            <Form.Input fluid label='Modifier' placeholder='' defaultValue={formData.modifier} uid="modifier" onChange={this.changeDialogHandler} />
                        </Form.Group>
                        <Form.Group widths='equal'>
                            <Form.Input fluid label='Roll' placeholder='0' defaultValue={formData.roll} uid="roll" onChange={this.changeDialogHandler} />
                            <Form.Input fluid label='Dmg1' placeholder='0' defaultValue={formData.dmg1} uid="dmg1" onChange={this.changeDialogHandler} />
                            <Form.Input fluid label='Dmg2' placeholder='' defaultValue={formData.dmg2} uid="dmg2" onChange={this.changeDialogHandler} />
                            <Form.Input fluid label='DmgType' placeholder='' defaultValue={formData.dmgType} uid="dmgType" onChange={this.changeDialogHandler} />
                        </Form.Group>
                        <Form.Group widths='equal'>
                            <Form.Input fluid label='Property' placeholder='0' defaultValue={formData.property} uid="property" onChange={this.changeDialogHandler} />
                            <Form.Input fluid label='Range' placeholder='0' defaultValue={formData.range} uid="range" onChange={this.changeDialogHandler} />
                            <Form.Select fluid label='Wearable' placeholder='Select Option' options={chooseWear} value={formData.wearable.toString()} uid="wearable" onChange={this.changeDialogHandler} />
                            <Form.Select fluid label='Cursed' placeholder='Select Option' options={chooseBool} value={formData.cursed.toString()} uid="cursed" onChange={this.changeDialogHandler} />
                        </Form.Group>
                        <Form.Group widths='equal'>
                            <Form.Select fluid label='Stackable' placeholder='Select Option' options={chooseBool} value={formData.stackable.toString()} uid="stackable" onChange={this.changeDialogHandler} />
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

export default PageObjectsItems;
