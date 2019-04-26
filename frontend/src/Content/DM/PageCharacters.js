import React, {Component} from "react";
import { Grid, Segment, Button, Header, Icon, Modal, Form } from 'semantic-ui-react';
import ReactTable from "react-table";

class PageCharacters extends Component {
    constructor(props) {
        super(props);
        this.state = {
            api: '/v2/character',
            character_open_dialog: false,
            character_edit: false,
            character_open_delete_dialog: false,
            character_loading: false,
            character_pages: '-1',
            character_pageSize: 10,
            character_data: [],
            character_selected: null,
            character_columns: [{
                    Header: 'Charname',
                    accessor: 'charname',
                    filterable: true,
                    sortable: true
                }, {
                    Header: 'Race',
                    accessor: 'raceId',
                    filterable: true,
                    sortable: true
                            //Cell: props => <span className='number'>{props.value}</span> // Custom cell components!
                }, {
                    Header: 'Class',
                    id: 'class1Id',
                    filterable: true,
                    sortable: true
                            //Cell: props => <span className='number'>{props.value}</span> // Custom cell components!
                }, {
                    Header: 'Options',
                    id: 'settings',
                    filterable: false,
                    sortable: false,
                    accessor: d => (
                                <Button.Group>
                                    <Button icon color="blue" oid={d.id} edit='1' onClick={this.openDialogCharacter} ><Icon name='edit' /></Button>
                                    <Button icon color="red"  oid={d.id} onClick={this.openDeleteHandler} ><Icon name='trash' /></Button>
                                </Button.Group>
                                )
                }],
            optionsQuiver: [],
            optionsHelmet: [],
            optionsCape: [],
            optionsNecklace: [],
            optionsWeapon: [],
            optionsOffWeapon: [],
            optionsGloves: [],
            optionsArmor: [],
            optionsBelt: [],
            optionsObject: [],
            optionsBoots: [],
            optionsRing: [],
            optionClass: [],
            optionRace: [],
            optionBackground: [],
            optionEnvironment: [],
            optionAccount: [],
            form_id: null,
form_active: '0',
form_accountId: 0,
form_charname: '',
form_environmentId: 0,
form_backgroundId: 0,
form_alignment: 4,
form_raceId: 0,
form_exp: '0',
form_class1Id: 0,
form_class1Level: '0',
form_class2Id: 0,
form_class2Level: '0',
form_class3Id: 0,
form_class3Level: '0',
form_class4Id: 0,
form_class4Level: '0',
form_inspiration: '0',
form_initiative: '0',
form_hpMax: '0',
form_hpCurrent: '0',
form_hpTemporary: '0',
form_cp: '0',
form_sp: '0',
form_ep: '0',
form_gp: '0',
form_pp: '0',
form_str: '0',
form_dex: '0',
form_con: '0',
form_int: '0',
form_wis: '0',
form_cha: '0',
form_acrobatics: '0',
form_animalHandling: '0',
form_arcana: '0',
form_athletics: '0',
form_deception: '0',
form_history: '0',
form_insight: '0',
form_intimidation: '0',
form_investigation: '0',
form_medicine: '0',
form_nature: '0',
form_perception: '0',
form_performance: '0',
form_persuasion: '0',
form_religion: '0',
form_sleightOfHand: '0',
form_stealth: '0',
form_survival: '0',
form_bonusModifier: '',
form_equipmentQuiver1: 0,
form_equipmentQuiver2: 0,
form_equipmentQuiver3: 0,
form_equipmentHelmet: 0,
form_equipmentCape: 0,
form_equipmentNecklace: 0,
form_equipmentWeapon1: 0,
form_equipmentWeapon2: 0,
form_equipmentWeapon3: 0,
form_equipmentOffWeapon: 0,
form_equipmentGloves: 0,
form_equipmentArmor: 0,
form_equipmentBelt: 0,
form_equipmentObject: 0,
form_equipmentBoots: 0,
form_equipmentRing1: 0,
form_equipmentRing2: 0,

            character_defaultFormData: {
                id: null,
                active: '0',
                accountId: 0,
                charname: '',
                environmentId: 0,
                backgroundId: 0,
                alignment: 4,
                raceId: 0,
                exp: '0',
                class1Id: 0,
                class1Level: '0',
                class2Id: 0,
                class2Level: '0',
                class3Id: 0,
                class3Level: '0',
                class4Id: 0,
                class4Level: '0',
                inspiration: '0',
                initiative: '0',
                hpMax: '0',
                hpCurrent: '0',
                hpTemporary: '0',
                cp: '0',
                sp: '0',
                ep: '0',
                gp: '0',
                pp: '0',
                str: '0',
                dex: '0',
                con: '0',
                int: '0',
                wis: '0',
                cha: '0',
                acrobatics: '0',
                animalHandling: '0',
                arcana: '0',
                athletics: '0',
                deception: '0',
                history: '0',
                insight: '0',
                intimidation: '0',
                investigation: '0',
                medicine: '0',
                nature: '0',
                perception: '0',
                performance: '0',
                persuasion: '0',
                religion: '0',
                sleightOfHand: '0',
                stealth: '0',
                survival: '0',
                bonusModifier: '',
                equipmentQuiver1: 0,
                equipmentQuiver2: 0,
                equipmentQuiver3: 0,
                equipmentHelmet: 0,
                equipmentCape: 0,
                equipmentNecklace: 0,
                equipmentWeapon1: 0,
                equipmentWeapon2: 0,
                equipmentWeapon3: 0,
                equipmentOffWeapon: 0,
                equipmentGloves: 0,
                equipmentArmor: 0,
                equipmentBelt: 0,
                equipmentObject: 0,
                equipmentBoots: 0,
                equipmentRing1: 0,
                equipmentRing2: 0
            },
        }
        //--
        this.openDialogCharacter = this.openDialogCharacter.bind(this);
        this.closeDialogCharacter = this.closeDialogCharacter.bind(this);
        this.submitDialogCharacter = this.submitDialogCharacter.bind(this);
        this.changeDialogCharacter = this.changeDialogCharacter.bind(this);
    }
    openDialogCharacter(event, obj) {
        event.preventDefault();
        this.setState({
            character_formData: this.state.character_defaultFormData
        });

        if (obj.edit === '1') {
            fetch(this.state.api + '/' + obj.oid, {method: "GET"})
                    .then(response => response.json())
                    .then(data => {
                        this.setState({
                            character_edit: true,
                            character_selected: obj.oid,
                            character_formData: data.data
                        });
                    });
        }
        this.setState({character_open_dialog: true});
    }
    closeDialogCharacter() {
        this.setState({character_open_dialog: false});
    }
    submitDialogCharacter() {

        var formData = new FormData();
        formData.append('active', this.state.form_active);
        formData.append('accountId', this.state.form_accountId);
        formData.append('charname', this.state.form_charname);
        formData.append('environmentId', this.state.form_environmentId);
        formData.append('backgroundId', this.state.form_backgroundId);
        formData.append('alignment', this.state.form_alignment);
        formData.append('raceId', this.state.form_raceId);
        formData.append('exp', this.state.form_exp);
        formData.append('class1Id', this.state.form_class1Id);
        formData.append('class1Level', this.state.form_class1Level);
        formData.append('class2Id', this.state.form_class2Id);
        formData.append('class2Level', this.state.form_class2Level);
        formData.append('class3Id', this.state.form_class3Id);
        formData.append('class3Level', this.state.form_class3Level);
        formData.append('class4Id', this.state.form_class4Id);
        formData.append('class4Level', this.state.form_class4Level);
        formData.append('inspiration', this.state.form_inspiration);
        formData.append('initiative', this.state.form_initiative);
        formData.append('hpMax', this.state.form_hpMax);
        formData.append('hpCurrent', this.state.form_hpCurrent);
        formData.append('hpTemporary', this.state.form_hpTemporary);
        formData.append('cp', this.state.form_cp);
        formData.append('sp', this.state.form_sp);
        formData.append('ep', this.state.form_ep);
        formData.append('gp', this.state.form_gp);
        formData.append('pp', this.state.form_pp);
        formData.append('str', this.state.form_str);
        formData.append('dex', this.state.form_dex);
        formData.append('con', this.state.form_con);
        formData.append('int', this.state.form_int);
        formData.append('wis', this.state.form_wis);
        formData.append('cha', this.state.form_cha);
        formData.append('acrobatics', this.state.form_acrobatics);
        formData.append('animalHandling', this.state.form_animalHandling);
        formData.append('arcana', this.state.form_arcana);
        formData.append('athletics', this.state.form_athletics);
        formData.append('deception', this.state.form_deception);
        formData.append('history', this.state.form_history);
        formData.append('insight', this.state.form_insight);
        formData.append('intimidation', this.state.form_intimidation);
        formData.append('investigation', this.state.form_investigation);
        formData.append('medicine', this.state.form_medicine);
        formData.append('nature', this.state.form_nature);
        formData.append('perception', this.state.form_perception);
        formData.append('performance', this.state.form_performance);
        formData.append('persuasion', this.state.form_persuasion);
        formData.append('religion', this.state.form_religion);
        formData.append('sleightOfHand', this.state.form_sleightOfHand);
        formData.append('stealth', this.state.form_stealth);
        formData.append('survival', this.state.form_survival);
        formData.append('bonusModifier', this.state.form_bonusModifier);
        formData.append('equipmentQuiver1', this.state.form_equipmentQuiver1);
        formData.append('equipmentQuiver2', this.state.form_equipmentQuiver2);
        formData.append('equipmentQuiver3', this.state.form_equipmentQuiver3);
        formData.append('equipmentHelmet', this.state.form_equipmentHelmet);
        formData.append('equipmentCape', this.state.form_equipmentCape);
        formData.append('equipmentNecklace', this.state.form_equipmentNecklace);
        formData.append('equipmentWeapon1', this.state.form_equipmentWeapon1);
        formData.append('equipmentWeapon2', this.state.form_equipmentWeapon2);
        formData.append('equipmentWeapon3', this.state.form_equipmentWeapon3);
        formData.append('equipmentOffWeapon', this.state.form_equipmentOffWeapon);
        formData.append('equipmentGloves', this.state.form_equipmentGloves);
        formData.append('equipmentArmor', this.state.form_equipmentArmor);
        formData.append('equipmentBelt', this.state.form_equipmentBelt);
        formData.append('equipmentObject', this.state.form_equipmentObject);
        formData.append('equipmentBoots', this.state.form_equipmentBoots);
        formData.append('equipmentRing1', this.state.form_equipmentRing1);
        formData.append('equipmentRing2', this.state.form_equipmentRing2);

        if (this.state.character_edit) {
            formData.append('id', this.state.character_selected);
            fetch(this.state.api + '/' + this.state.character_selected, {method: "POST", body: formData})
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
    reloadHandler(e) {
        this.character_table.fireFetchData();
    }
    changeDialogCharacter = (e, {name, value}) => this.setState({ [name]: value })
    /*
    changeDialogCharacter(event) {
        this.setState({ [event.target.name]: event.target.value });
        //this.state.character_formData[event.target.name] = event.target.value;
       // this.setState({character_formData: Object.assign({}, this.state.character_formData, {[event.target.name]: event.target.value})});
    }
    */
    componentWillUnmount() {
        this.setState({
            optionAccount: [],
            optionEnvironment: [],
            optionClass: [],
            optionRace: [],
            optionBackground: [],
            optionsQuiver: [],
            optionsHelmet: [],
            optionsCape: [],
            optionsNecklace: [],
            optionsWeapon: [],
            optionsOffWeapon: [],
            optionsGloves: [],
            optionsArmor: [],
            optionsBelt: [],
            optionsObject: [],
            optionsBoots: [],
            optionsRing: []
        });
    }
    componentDidMount() {
        fetch('/v2/options/full', {method: "POST"})
                .then(response => response.json())
                .then(data => {
                    this.setState({
                        optionAccount: data.data.listAccount,
                        optionEnvironment: data.data.listEnvironment,
                        optionClass: data.data.listClass,
                        optionRace: data.data.listRace,
                        optionBackground: data.data.listBackground,
                        optionsQuiver: data.data.listQuiver,
                        optionsHelmet: data.data.listHelmet,
                        optionsCape: data.data.listCape,
                        optionsNecklace: data.data.listNecklace,
                        optionsWeapon: data.data.listWeapon,
                        optionsOffWeapon: data.data.listOffWeapon,
                        optionsGloves: data.data.listGloves,
                        optionsArmor: data.data.listArmor,
                        optionsBelt: data.data.listBelt,
                        optionsObject: data.data.listObject,
                        optionsBoots: data.data.listBoots,
                        optionsRing: data.data.listRing
                    });
                });
    }
    render() {
        const chooseAlignment = [
            {value: 0, text: 'Lawful good'},
            {value: 1, text: 'Neutral good'},
            {value: 2, text: 'Chaotic good'},
            {value: 3, text: 'Lawful neutral'},
            {value: 4, text: 'Neutral neutral'},
            {value: 5, text: 'Chaotic neutral'},
            {value: 6, text: 'Lawful evil'},
            {value: 7, text: 'Neutral evil'},
            {value: 8, text: 'Chaotic evil'}
        ];
        const chooseBool = [
            {text: 'Yes', value: '1'},
            {text: 'No', value: '0'},
        ];

        return (
                <Grid>
                    <Grid.Row columns={2}>
                        <Grid.Column>
                            <Header as='h3'>1. Choose a Character</Header>
                            <Segment raised>
                                <ReactTable
                                    ref={(instance) => {
                                            this.character_table = instance;
                                        }}
                                    data={this.state.character_data}
                                    columns={this.state.character_columns}
                                    pages={this.state.character_pages}
                                    pageSize={this.state.character_pageSize}
                                    loading={this.state.character_loading}
                                    manual
                                    onFetchData={(state, instance) => {
                                            this.setState({character_loading: true})
                                            var formData = new FormData();
                                            formData.append('page', state.page);
                                            formData.append('pageSize', state.pageSize);
                                            formData.append('sorted', JSON.stringify(state.sorted));
                                            formData.append('filtered', JSON.stringify(state.filtered));
                                            fetch('/v2/datatable/character', {method: "POST", body: formData})
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        this.setState({
                                                            character_data: data.data,
                                                            character_pages: data.pages,
                                                            character_pageSize: data.pageSize,
                                                            character_loading: false
                                                        })
                                                    });
                                        }}
                                    />
                                <Button fluid color='blue' oid='0' edit='0' onClick={this.openDialogCharacter}><Icon name='plus' />New Character</Button>
                            </Segment>
                        </Grid.Column>
                        <Grid.Column>
                            <Header as='h3'>2. Edit the Inventory</Header>
                            <Segment raised>
                                Name - Count - options
                                <Button fluid color='blue'><Icon name='plus' />New Item</Button>
                            </Segment>
                        </Grid.Column>
                    </Grid.Row>

                    <Modal open={this.state.character_open_dialog} closeOnEscape={true} closeOnDimmerClick={false} >
                        <Modal.Header>{(this.state.character_edit ? 'Edit' : 'Add')} Character</Modal.Header>
                        <Modal.Content>
                            <Form>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='Active' placeholder="Select Option" options={chooseBool} value={this.state.form_active} name="form_active" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Account' placeholder="Select Option" options={this.state.optionAccount} value={this.state.form_accountId} name="form_accountId" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                                <Form.Input fluid label='Character Name' placeholder='Im a unique Name' defaultValue={this.state.form_charname} name="form_charname" onChange={this.changeDialogCharacter} />
                                <Form.Select fluid label='Environment' placeholder='Select Option' options={this.state.optionEnvironment} value={this.state.form_environmentId.toString()} name="form_environmentId" onChange={this.changeDialogCharacter} />
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='Background' placeholder='Select Option' options={this.state.optionBackground} value={this.state.form_backgroundId.toString()} name="form_backgroundId" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Alignment' placeholder='Select Option' options={chooseAlignment} value={this.state.form_alignment} name="form_alignment" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='Race' placeholder='Select Option' options={this.state.optionRace} value={this.state.form_raceId.toString()} name="form_raceId" onChange={this.changeDialogCharacter} />
                                    <Form.Input fluid label='Exp' placeholder='0' defaultValue={this.state.form_exp.name} name="form_exp" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='1. Class' placeholder='Select Option' options={this.state.optionClass} value={this.state.form_class1Id.toString()} name="form_class1Id" onChange={this.changeDialogCharacter} />
                                    <Form.Input fluid label='1. Level' placeholder='0' defaultValue={this.state.form_class1Level.name} name="form_class1Level" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='2. Class' placeholder='Select Option' options={this.state.optionClass} value={this.state.form_class2Id.toString()} name="form_class2Id" onChange={this.changeDialogCharacter} />
                                    <Form.Input fluid label='2. Level' placeholder='0' defaultValue={this.state.form_class2Level.name} name="form_class2Level" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='3. Class' placeholder='Select Option' options={this.state.optionClass} value={this.state.form_class3Id.toString()} name="form_class3Id" onChange={this.changeDialogCharacter} />
                                    <Form.Input fluid label='3. Level' placeholder='0' defaultValue={this.state.form_class3Level.name} name="form_class3Level" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='4. Class' placeholder='Select Option' options={this.state.optionClass} value={this.state.form_class4Id.toString()} name="form_class4Id" onChange={this.changeDialogCharacter} />
                                    <Form.Input fluid label='4. Level' placeholder='0' defaultValue={this.state.form_class4Level} name="form_class4Level" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Input fluid label='Inspiration' placeholder='0' defaultValue={this.state.form_inspiration} name="form_inspiration" onChange={this.changeDialogCharacter} />
                                    <Form.Input fluid label='Initiative' placeholder='0' defaultValue={this.state.form_initiative} name="form_initiative" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Input fluid label='Max HP' placeholder='0' defaultValue={this.state.form_hpMax} name="form_hpMax" onChange={this.changeDialogCharacter} />
                                    <Form.Input fluid label='Current HP' placeholder='0' defaultValue={this.state.form_hpCurrent} name="form_hpCurrent" onChange={this.changeDialogCharacter} />
                                    <Form.Input fluid label='Tmp HP' placeholder='0' defaultValue={this.state.form_hpTemporary} name="form_hpTemporary" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Input fluid label='CP' placeholder='0' defaultValue={this.state.form_cp} name="form_cp" onChange={this.changeDialogCharacter} />
                                    <Form.Input fluid label='SP' placeholder='0' defaultValue={this.state.form_sp} name="form_sp" onChange={this.changeDialogCharacter} />
                                    <Form.Input fluid label='EP' placeholder='0' defaultValue={this.state.form_ep} name="form_ep" onChange={this.changeDialogCharacter} />
                                    <Form.Input fluid label='GP' placeholder='0' defaultValue={this.state.form_gp} name="form_gp" onChange={this.changeDialogCharacter} />
                                    <Form.Input fluid label='PP' placeholder='0' defaultValue={this.state.form_pp} name="form_pp" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Input fluid label='Str' placeholder='0' defaultValue={this.state.form_str} name="form_str" onChange={this.changeDialogCharacter} />
                                    <Form.Input fluid label='Dex' placeholder='0' defaultValue={this.state.form_dex} name="form_dex" onChange={this.changeDialogCharacter} />
                                    <Form.Input fluid label='Con' placeholder='0' defaultValue={this.state.form_con} name="form_con" onChange={this.changeDialogCharacter} />
                                    <Form.Input fluid label='Int' placeholder='0' defaultValue={this.state.form_int} name="form_int" onChange={this.changeDialogCharacter} />
                                    <Form.Input fluid label='Wis' placeholder='0' defaultValue={this.state.form_wis} name="form_wis" onChange={this.changeDialogCharacter} />
                                    <Form.Input fluid label='Cha' placeholder='0' defaultValue={this.state.form_cha} name="form_cha" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='Acrobatics' placeholder="Select Option" options={chooseBool} value={this.state.form_acrobatics} name="form_acrobatics" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Animal Handling' placeholder="Select Option" options={chooseBool} value={this.state.form_animalHandling} name="form_animalHandling" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Arcana' placeholder="Select Option" options={chooseBool} value={this.state.form_arcana} name="form_arcana" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Athletics' placeholder="Select Option" options={chooseBool} value={this.state.form_athletics} name="form_athletics" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='Deception' placeholder="Select Option" options={chooseBool} value={this.state.form_deception} name="form_deception" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='History' placeholder="Select Option" options={chooseBool} value={this.state.form_history} name="form_history" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Insight' placeholder="Select Option" options={chooseBool} value={this.state.form_insight} name="form_insight" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Intimidation' placeholder="Select Option" options={chooseBool} value={this.state.form_intimidation} name="form_intimidation" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='Investigation' placeholder="Select Option" options={chooseBool} value={this.state.form_investigation} name="form_investigation" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Medicine' placeholder="Select Option" options={chooseBool} value={this.state.form_medicine} name="form_medicine" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Nature' placeholder="Select Option" options={chooseBool} value={this.state.form_nature} name="form_nature" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Perception' placeholder="Select Option" options={chooseBool} value={this.state.form_perception} name="form_perception" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='Performance' placeholder="Select Option" options={chooseBool} value={this.state.form_performance} name="form_performance" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Persuasion' placeholder="Select Option" options={chooseBool} value={this.state.form_persuasion} name="form_persuasion" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Religion' placeholder="Select Option" options={chooseBool} value={this.state.form_religion} name="form_religion" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Sleight Of Hand' placeholder="Select Option" options={chooseBool} value={this.state.form_sleightOfHand} name="form_sleightOfHand" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='Stealth' placeholder="Select Option" options={chooseBool} value={this.state.form_stealth} name="form_stealth" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Survival' placeholder="Select Option" options={chooseBool} value={this.state.form_survival} name="form_survival" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                                <Form.Input fluid label='Bonus Modifier' placeholder='0' defaultValue={this.state.form_bonusModifier} name="form_bonusModifier" onChange={this.changeDialogCharacter} />
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='Quiver1' placeholder="Select Option" options={this.state.optionsQuiver} value={this.state.form_equipmentQuiver1} name="form_equipmentQuiver1" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Quiver2' placeholder="Select Option" options={this.state.optionsQuiver} value={this.state.form_equipmentQuiver2} name="form_equipmentQuiver2" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Quiver3' placeholder="Select Option" options={this.state.optionsQuiver} value={this.state.form_equipmentQuiver3} name="form_equipmentQuiver3" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='Helmet' placeholder="Select Option" options={this.state.optionsHelmet} value={this.state.form_equipmentHelmet} name="form_equipmentHelmet" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Cape' placeholder="Select Option" options={this.state.optionsCape} value={this.state.form_equipmentCape} name="form_equipmentCape" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Necklace' placeholder="Select Option" options={this.state.optionsNecklace} value={this.state.form_equipmentNecklace} name="form_equipmentNecklace" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='Weapon1' placeholder="Select Option" options={this.state.optionsWeapon} value={this.state.form_equipmentWeapon1} name="form_equipmentWeapon1" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Weapon2' placeholder="Select Option" options={this.state.optionsWeapon} value={this.state.form_equipmentWeapon2} name="form_equipmentWeapon2" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Weapon3' placeholder="Select Option" options={this.state.optionsWeapon} value={this.state.form_equipmentWeapon3} name="form_equipmentWeapon3" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Off-Weapon' placeholder="Select Option" options={this.state.optionsOffWeapon} value={this.state.form_equipmentOffWeapon} name="form_equipmentOffWeapon" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='Gloves' placeholder="Select Option" options={this.state.optionsGloves} value={this.state.form_equipmentGloves} name="form_equipmentGloves" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Armor' placeholder="Select Option" options={this.state.optionsArmor} value={this.state.form_equipmentArmor} name="form_equipmentArmor" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Belt' placeholder="Select Option" options={this.state.optionsBelt} value={this.state.form_equipmentBelt} name="form_equipmentBelt" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Object' placeholder="Select Option" options={this.state.optionsObject} value={this.state.form_equipmentObject} name="form_equipmentObject" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                                <Form.Group widths='equal'>
                                    <Form.Select fluid label='Boots' placeholder="Select Option" options={this.state.optionsBoots} value={this.state.form_equipmentBoots} name="form_equipmentBoots" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Ring1' placeholder="Select Option" options={this.state.optionsRing} value={this.state.form_equipmentRing1} name="form_equipmentRing1" onChange={this.changeDialogCharacter} />
                                    <Form.Select fluid label='Ring2' placeholder="Select Option" options={this.state.optionsRing} value={this.state.form_equipmentRing2} name="form_equipmentRing2" onChange={this.changeDialogCharacter} />
                                </Form.Group>
                            </Form>
                        </Modal.Content>
                        <Modal.Actions>
                            <Button negative onClick={this.closeDialogCharacter}>Cancel</Button>
                            <Button color='blue' onClick={this.submitDialogCharacter}><Icon name='checkmark' />Submit</Button>
                        </Modal.Actions>
                    </Modal>
                </Grid>
                );
    }
}

export default PageCharacters;
