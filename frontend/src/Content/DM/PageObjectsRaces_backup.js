import React from "react";
import { Segment, Icon, Button, Modal, Form } from 'semantic-ui-react';
import ReactTable from "react-table";

class PageObjectsRaces extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            ajax: '/v2/datatable/races',
            api: '/v2/races',
            loading: false,
            pages: '-1',
            pageSize: 10,
            sorted: [],
            filtered: [],
            data: [],
            formData: {
                id: null,
                name: '',
                size: 'M',
                speed: '30',
                ability: '',
                proficiency: '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0',
                proficiencyAcrobatics: '0',
                proficiencyAnimalHandling: '0',
                proficiencyArcana: '0',
                proficiencyAthletics: '0',
                proficiencyDeception: '0',
                proficiencyHistory: '0',
                proficiencyInsight: '0',
                proficiencyIntimidation: '0',
                proficiencyInvestigation: '0',
                proficiencyMedicine: '0',
                proficiencyNature: '0',
                proficiencyPerception: '0',
                proficiencyPerformance: '0',
                proficiencyPersuasion: '0',
                proficiencyReligion: '0',
                proficiencySleightOfHand: '0',
                proficiencyStealth: '0',
                proficiencySurvival: '0',
                cleanProficiency: ''
            },
            defaultFormData: {
                id: null,
                name: '',
                size: 'M',
                speed: '30',
                ability: '',
                proficiency: '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0',
                proficiencyAcrobatics: '0',
                proficiencyAnimalHandling: '0',
                proficiencyArcana: '0',
                proficiencyAthletics: '0',
                proficiencyDeception: '0',
                proficiencyHistory: '0',
                proficiencyInsight: '0',
                proficiencyIntimidation: '0',
                proficiencyInvestigation: '0',
                proficiencyMedicine: '0',
                proficiencyNature: '0',
                proficiencyPerception: '0',
                proficiencyPerformance: '0',
                proficiencyPersuasion: '0',
                proficiencyReligion: '0',
                proficiencySleightOfHand: '0',
                proficiencyStealth: '0',
                proficiencySurvival: '0',
                cleanProficiency: ''
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
                        this.form.forceUpdate();
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
        formData.append('size', this.state.formData.size);
        formData.append('speed', this.state.formData.speed);
        formData.append('ability', this.state.formData.ability);
        formData.append('proficiency',
                this.state.formData.proficiencyAcrobatics + ';' +
                this.state.formData.proficiencyAnimalHandling + ';' +
                this.state.formData.proficiencyArcana + ';' +
                this.state.formData.proficiencyAthletics + ';' +
                this.state.formData.proficiencyDeception + ';' +
                this.state.formData.proficiencyHistory + ';' +
                this.state.formData.proficiencyInsight + ';' +
                this.state.formData.proficiencyIntimidation + ';' +
                this.state.formData.proficiencyInvestigation + ';' +
                this.state.formData.proficiencyMedicine + ';' +
                this.state.formData.proficiencyNature + ';' +
                this.state.formData.proficiencyPerception + ';' +
                this.state.formData.proficiencyPerformance + ';' +
                this.state.formData.proficiencyPersuasion + ';' +
                this.state.formData.proficiencyReligion + ';' +
                this.state.formData.proficiencySleightOfHand + ';' +
                this.state.formData.proficiencyStealth + ';' +
                this.state.formData.proficiencySurvival
                );

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
            {Header: 'Size', accessor: 'size', filterable: true},
            {Header: 'Speed', accessor: 'speed', filterable: true},
            {Header: 'Ability', accessor: 'ability', filterable: true},
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

        const chooseBool = [
            {text: 'Yes', value: '1'},
            {text: 'No', value: '0'},
        ];
        const chooseSize = [
            {text: 'XXS', value: 'XXS'},
            {text: 'XS', value: 'XS'},
            {text: 'S', value: 'S'},
            {text: 'M', value: 'M'},
            {text: 'L', value: 'L'},
            {text: 'XL', value: 'XL'},
            {text: 'XXL', value: 'XXL'},
            {text: '3XL', value: '3XL'}
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
                            <Form ref={(instance) => {
                        this.form = instance;
                    }}>
                                <Form.Group widths='equal'>
                                    <Form.Input fluid label='Name' placeholder='Im a unique Name' defaultValue={formData.name} uid="name" onChange={this.changeDialogHandler} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='Size' placeholder='Select Option' options={chooseSize} value={formData.size} uid="size" onChange={this.changeDialogHandler} />
                                    <Form.Input fluid label='Speed' placeholder='30' defaultValue={formData.speed} uid="speed" onChange={this.changeDialogHandler} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Input fluid label='Ability' placeholder='+1str' defaultValue={formData.ability} uid="ability" onChange={this.changeDialogHandler} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='Acrobatics' placeholder='Select Option' options={chooseBool} value={formData.proficiencyAcrobatics.toString()} uid="proficiencyAcrobatics" onChange={this.changeDialogHandler} />
                                    <Form.Select fluid label='AnimalHandling' placeholder='Select Option' options={chooseBool} value={formData.proficiencyAnimalHandling.toString()} uid="proficiencyAnimalHandling" onChange={this.changeDialogHandler} />
                                    <Form.Select fluid label='Arcana' placeholder='Select Option' options={chooseBool} value={formData.proficiencyArcana.toString()} uid="proficiencyArcana" onChange={this.changeDialogHandler} />
                                    <Form.Select fluid label='Athletics' placeholder='Select Option' options={chooseBool} value={formData.proficiencyAthletics.toString()} uid="proficiencyAthletics" onChange={this.changeDialogHandler} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='Deception' placeholder='Select Option' options={chooseBool} value={formData.proficiencyDeception.toString()} uid="proficiencyDeception" onChange={this.changeDialogHandler} />
                                    <Form.Select fluid label='History' placeholder='Select Option' options={chooseBool} value={formData.proficiencyHistory.toString()} uid="proficiencyHistory" onChange={this.changeDialogHandler} />
                                    <Form.Select fluid label='Insight' placeholder='Select Option' options={chooseBool} value={formData.proficiencyInsight.toString()} uid="proficiencyInsight" onChange={this.changeDialogHandler} />
                                    <Form.Select fluid label='Intimidation' placeholder='Select Option' options={chooseBool} value={formData.proficiencyIntimidation.toString()} uid="proficiencyIntimidation" onChange={this.changeDialogHandler} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='Investigation' placeholder='Select Option' options={chooseBool} value={formData.proficiencyInvestigation.toString()} uid="proficiencyInvestigation" onChange={this.changeDialogHandler} />
                                    <Form.Select fluid label='Medicine' placeholder='Select Option' options={chooseBool} value={formData.proficiencyMedicine.toString()} uid="proficiencyMedicine" onChange={this.changeDialogHandler} />
                                    <Form.Select fluid label='Nature' placeholder='Select Option' options={chooseBool} value={formData.proficiencyNature.toString()} uid="proficiencyNature" onChange={this.changeDialogHandler} />
                                    <Form.Select fluid label='Perception' placeholder='Select Option' options={chooseBool} value={formData.proficiencyPerception.toString()} uid="proficiencyPerception" onChange={this.changeDialogHandler} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='Performance' placeholder='Select Option' options={chooseBool} value={formData.proficiencyPerformance.toString()} uid="proficiencyPerformance" onChange={this.changeDialogHandler} />
                                    <Form.Select fluid label='Persuasion' placeholder='Select Option' options={chooseBool} value={formData.proficiencyPersuasion.toString()} uid="proficiencyPersuasion" onChange={this.changeDialogHandler} />
                                    <Form.Select fluid label='Religion' placeholder='Select Option' options={chooseBool} value={formData.proficiencyReligion.toString()} uid="proficiencyReligion" onChange={this.changeDialogHandler} />
                                    <Form.Select fluid label='SleightOfHand' placeholder='Select Option' options={chooseBool} value={formData.proficiencySleightOfHand.toString()} uid="proficiencySleightOfHand" onChange={this.changeDialogHandler} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='Stealth' placeholder='Select Option' options={chooseBool} value={formData.proficiencyStealth.toString()} uid="proficiencyStealth" onChange={this.changeDialogHandler} />
                                    <Form.Select fluid label='Survival' placeholder='Select Option' options={chooseBool} value={formData.proficiencySurvival.toString()} uid="proficiencySurvival" onChange={this.changeDialogHandler} />
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

export default PageObjectsRaces;
