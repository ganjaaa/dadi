import React from "react";
import { Grid, Segment, Button, Header, Icon, Modal, Form } from 'semantic-ui-react';

class FormCharacter extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            ajax: '/v2/datatable/backgrounds',
            api: '/v2/backgrounds',
            formData: {
                id: null,
            },
            defaultFormData: {
                id: null,
            },
            table: null,
            openDialog: false,
            openDeleteDialog: false,
            selectedID: null,
            edit: false
        };
        this.closeDialog = this.closeDialog.bind(this);
        this.submitDialog = this.submitDialog.bind(this);


    }
    openDialog() {

        if (this.props.edit == "true") {
            this.state.data.id = this.props.oid;
            fetch(this.state.api + '/' + this.props.oid, {method: "GET"})
                    .then(response => response.json())
                    .then(data => {
                        this.setState({
                            data: data
                        })
                    });
        }
    }
    closeDialog() {

    }
    submitDialog() {

    }
    handleCChange(e, data) {
        this.setState({formData: Object.assign({}, this.state.formData, {[data.uid]: data.value})});
    }
    render() {
        const optionsBool = [
            {text: 'Yes', value: '1'},
            {text: 'No', value: '0'},
        ];

        return (
                <Modal open={this.state.openDialog} closeOnEscape={true} closeOnDimmerClick={false} >
                    <Modal.Header>{(this.state.edit ? 'Edit' : 'Add')} Character</Modal.Header>
                    <Modal.Content>
                        <Form>
                            <Form.Group widths='equal'>
                                <Form.Select fluid label='Active' placeholder="Select Option" options={optionsBool} value={this.state.formData.active} uid="active" onChange={this.handleChange} />
                                <Form.Select fluid label='Account' placeholder="Select Option" options={optionsBool} value={this.state.formData.accountId} uid="accountId" onChange={this.handleChange} />
                            </Form.Group>
                            <Form.Input fluid label='Character Name' placeholder='Im a unique Name' defaultValue={this.state.formData.charname} uid="charname" onChange={this.handleChange} />
                            <Form.Select fluid label='Environment' placeholder='Select Option' options={optionsBool} value={this.state.formData.environmentId.toString()} uid="environmentId" onChange={this.handleChange} />
                            <Form.Group widths='equal'>
                                <Form.Select fluid label='Background' placeholder='Select Option' options={optionsBool} value={this.state.formData.backgroundId.toString()} uid="backgroundId" onChange={this.handleChange} />
                                <Form.Select fluid label='Alignment' placeholder='Select Option' options={optionsBool} value={this.state.formData.alignment.toString()} uid="alignment" onChange={this.handleChange} />
                            </Form.Group>
                            <Form.Group widths='equal'>
                                <Form.Select fluid label='Race' placeholder='Select Option' options={optionsBool} value={this.state.formData.raceId.toString()} uid="raceId" onChange={this.handleChange} />
                                <Form.Input fluid label='Exp' placeholder='0' defaultValue={this.state.formData.exp.name} uid="exp" onChange={this.handleChange} />
                            </Form.Group>
                            <Form.Group widths='equal'>
                                <Form.Select fluid label='1. Class' placeholder='Select Option' options={optionsBool} value={this.state.formData.class1Id.toString()} uid="class1Id" onChange={this.handleChange} />
                                <Form.Input fluid label='1. Level' placeholder='0' defaultValue={this.state.formData.class1Level.name} uid="class1Level" onChange={this.handleChange} />
                            </Form.Group>
                            <Form.Group widths='equal'>
                                <Form.Select fluid label='2. Class' placeholder='Select Option' options={optionsBool} value={this.state.formData.class2Id.toString()} uid="class2Id" onChange={this.handleChange} />
                                <Form.Input fluid label='2. Level' placeholder='0' defaultValue={this.state.formData.class2Level.name} uid="class2Level" onChange={this.handleChange} />
                            </Form.Group>
                            <Form.Group widths='equal'>
                                <Form.Select fluid label='3. Class' placeholder='Select Option' options={optionsBool} value={this.state.formData.class3Id.toString()} uid="class3Id" onChange={this.handleChange} />
                                <Form.Input fluid label='3. Level' placeholder='0' defaultValue={this.state.formData.class3Level.name} uid="class3Level" onChange={this.handleChange} />
                            </Form.Group>
                            <Form.Group widths='equal'>
                                <Form.Select fluid label='4. Class' placeholder='Select Option' options={optionsBool} value={this.state.formData.class4Id.toString()} uid="class4Id" onChange={this.handleChange} />
                                <Form.Input fluid label='4. Level' placeholder='0' defaultValue={this.state.formData.class4Level} uid="class4Level" onChange={this.handleChange} />
                            </Form.Group>
                            <Form.Group widths='equal'>
                                <Form.Input fluid label='Inspiration' placeholder='0' defaultValue={this.state.formData.inspiration} uid="inspiration" onChange={this.handleChange} />
                                <Form.Input fluid label='Initiative' placeholder='0' defaultValue={this.state.formData.initiative} uid="initiative" onChange={this.handleChange} />
                            </Form.Group>
                            <Form.Group widths='equal'>
                                <Form.Input fluid label='Max HP' placeholder='0' defaultValue={this.state.formData.hpMax} uid="hpMax" onChange={this.handleChange} />
                                <Form.Input fluid label='Current HP' placeholder='0' defaultValue={this.state.formData.hpCurrent} uid="hpCurrent" onChange={this.handleChange} />
                                <Form.Input fluid label='Tmp HP' placeholder='0' defaultValue={this.state.formData.hpTemporary} uid="hpTemporary" onChange={this.handleChange} />
                            </Form.Group>
                            <Form.Group widths='equal'>
                                <Form.Input fluid label='CP' placeholder='0' defaultValue={this.state.formData.cp} uid="cp" onChange={this.handleChange} />
                                <Form.Input fluid label='SP' placeholder='0' defaultValue={this.state.formData.sp} uid="sp" onChange={this.handleChange} />
                                <Form.Input fluid label='EP' placeholder='0' defaultValue={this.state.formData.ep} uid="ep" onChange={this.handleChange} />
                                <Form.Input fluid label='GP' placeholder='0' defaultValue={this.state.formData.gp} uid="gp" onChange={this.handleChange} />
                                <Form.Input fluid label='PP' placeholder='0' defaultValue={this.state.formData.pp} uid="pp" onChange={this.handleChange} />
                            </Form.Group>
                            <Form.Group widths='equal'>
                                <Form.Input fluid label='Str' placeholder='0' defaultValue={this.state.formData.str} uid="str" onChange={this.handleChange} />
                                <Form.Input fluid label='Dex' placeholder='0' defaultValue={this.state.formData.dex} uid="dex" onChange={this.handleChange} />
                                <Form.Input fluid label='Con' placeholder='0' defaultValue={this.state.formData.con} uid="con" onChange={this.handleChange} />
                                <Form.Input fluid label='Int' placeholder='0' defaultValue={this.state.formData.int} uid="int" onChange={this.handleChange} />
                                <Form.Input fluid label='Wis' placeholder='0' defaultValue={this.state.formData.wis} uid="wis" onChange={this.handleChange} />
                                <Form.Input fluid label='Cha' placeholder='0' defaultValue={this.state.formData.cha} uid="cha" onChange={this.handleChange} />
                            </Form.Group>
                            <Form.Group widths='equal'>
                                <Form.Select fluid label='Acrobatics' placeholder="Select Option" options={optionsBool} value={this.state.formData.acrobatics} uid="acrobatics" onChange={this.handleChange} />
                                <Form.Select fluid label='Animal Handling' placeholder="Select Option" options={optionsBool} value={this.state.formData.animalHandling} uid="animalHandling" onChange={this.handleChange} />
                                <Form.Select fluid label='Arcana' placeholder="Select Option" options={optionsBool} value={this.state.formData.arcana} uid="arcana" onChange={this.handleChange} />
                                <Form.Select fluid label='Athletics' placeholder="Select Option" options={optionsBool} value={this.state.formData.athletics} uid="athletics" onChange={this.handleChange} />
                            </Form.Group>
                            <Form.Group widths='equal'>
                                <Form.Select fluid label='Deception' placeholder="Select Option" options={optionsBool} value={this.state.formData.deception} uid="deception" onChange={this.handleChange} />
                                <Form.Select fluid label='History' placeholder="Select Option" options={optionsBool} value={this.state.formData.history} uid="history" onChange={this.handleChange} />
                                <Form.Select fluid label='Insight' placeholder="Select Option" options={optionsBool} value={this.state.formData.insight} uid="insight" onChange={this.handleChange} />
                                <Form.Select fluid label='Intimidation' placeholder="Select Option" options={optionsBool} value={this.state.formData.intimidation} uid="intimidation" onChange={this.handleChange} />
                            </Form.Group>
                            <Form.Group widths='equal'>
                                <Form.Select fluid label='Investigation' placeholder="Select Option" options={optionsBool} value={this.state.formData.investigation} uid="investigation" onChange={this.handleChange} />
                                <Form.Select fluid label='Medicine' placeholder="Select Option" options={optionsBool} value={this.state.formData.medicine} uid="medicine" onChange={this.handleChange} />
                                <Form.Select fluid label='Nature' placeholder="Select Option" options={optionsBool} value={this.state.formData.nature} uid="nature" onChange={this.handleChange} />
                                <Form.Select fluid label='Perception' placeholder="Select Option" options={optionsBool} value={this.state.formData.perception} uid="perception" onChange={this.handleChange} />
                            </Form.Group>
                            <Form.Group widths='equal'>
                                <Form.Select fluid label='Performance' placeholder="Select Option" options={optionsBool} value={this.state.formData.performance} uid="performance" onChange={this.handleChange} />
                                <Form.Select fluid label='Persuasion' placeholder="Select Option" options={optionsBool} value={this.state.formData.persuasion} uid="persuasion" onChange={this.handleChange} />
                                <Form.Select fluid label='Religion' placeholder="Select Option" options={optionsBool} value={this.state.formData.religion} uid="religion" onChange={this.handleChange} />
                                <Form.Select fluid label='Sleight Of Hand' placeholder="Select Option" options={optionsBool} value={this.state.formData.sleightOfHand} uid="sleightOfHand" onChange={this.handleChange} />
                            </Form.Group>
                            <Form.Group widths='equal'>
                                <Form.Select fluid label='Stealth' placeholder="Select Option" options={optionsBool} value={this.state.formData.stealth} uid="stealth" onChange={this.handleChange} />
                                <Form.Select fluid label='Survival' placeholder="Select Option" options={optionsBool} value={this.state.formData.survival} uid="survival" onChange={this.handleChange} />
                            </Form.Group>
                            <Form.Input fluid label='Bonus Modifier' placeholder='0' defaultValue={this.state.formData.bonusModifier} uid="bonusModifier" onChange={this.handleChange} />
                            <Form.Group widths='equal'>
                                <Form.Select fluid label='Quiver1' placeholder="Select Option" options={optionsBool} value={this.state.formData.equipmentQuiver1} uid="equipmentQuiver1" onChange={this.handleChange} />
                                <Form.Select fluid label='Quiver2' placeholder="Select Option" options={optionsBool} value={this.state.formData.equipmentQuiver2} uid="equipmentQuiver2" onChange={this.handleChange} />
                                <Form.Select fluid label='Quiver3' placeholder="Select Option" options={optionsBool} value={this.state.formData.equipmentQuiver3} uid="equipmentQuiver3" onChange={this.handleChange} />
                            </Form.Group>
                            <Form.Group widths='equal'>
                                <Form.Select fluid label='Helmet' placeholder="Select Option" options={optionsBool} value={this.state.formData.equipmentHelmet} uid="equipmentHelmet" onChange={this.handleChange} />
                                <Form.Select fluid label='Cape' placeholder="Select Option" options={optionsBool} value={this.state.formData.equipmentCape} uid="equipmentCape" onChange={this.handleChange} />
                                <Form.Select fluid label='Necklace' placeholder="Select Option" options={optionsBool} value={this.state.formData.equipmentNecklace} uid="equipmentNecklace" onChange={this.handleChange} />
                            </Form.Group>
                            <Form.Group widths='equal'>
                                <Form.Select fluid label='Weapon1' placeholder="Select Option" options={optionsBool} value={this.state.formData.equipmentWeapon1} uid="equipmentWeapon1" onChange={this.handleChange} />
                                <Form.Select fluid label='Weapon2' placeholder="Select Option" options={optionsBool} value={this.state.formData.equipmentWeapon2} uid="equipmentWeapon2" onChange={this.handleChange} />
                                <Form.Select fluid label='Weapon3' placeholder="Select Option" options={optionsBool} value={this.state.formData.equipmentWeapon3} uid="equipmentWeapon3" onChange={this.handleChange} />
                                <Form.Select fluid label='Off-Weapon' placeholder="Select Option" options={optionsBool} value={this.state.formData.equipmentOffWeapon} uid="equipmentOffWeapon" onChange={this.handleChange} />
                            </Form.Group>
                            <Form.Group widths='equal'>
                                <Form.Select fluid label='Gloves' placeholder="Select Option" options={optionsBool} value={this.state.formData.equipmentGloves} uid="equipmentGloves" onChange={this.handleChange} />
                                <Form.Select fluid label='Armor' placeholder="Select Option" options={optionsBool} value={this.state.formData.equipmentArmor} uid="equipmentArmor" onChange={this.handleChange} />
                                <Form.Select fluid label='Belt' placeholder="Select Option" options={optionsBool} value={this.state.formData.equipmentBelt} uid="equipmentBelt" onChange={this.handleChange} />
                                <Form.Select fluid label='Object' placeholder="Select Option" options={optionsBool} value={this.state.formData.equipmentObject} uid="equipmentObject" onChange={this.handleChange} />
                            </Form.Group>
                            <Form.Group widths='equal'>
                                <Form.Select fluid label='Boots' placeholder="Select Option" options={optionsBool} value={this.state.formData.equipmentBoots} uid="equipmentBoots" onChange={this.handleChange} />
                                <Form.Select fluid label='Ring1' placeholder="Select Option" options={optionsBool} value={this.state.formData.equipmentRing1} uid="equipmentRing1" onChange={this.handleChange} />
                                <Form.Select fluid label='Ring2' placeholder="Select Option" options={optionsBool} value={this.state.formData.equipmentRing2} uid="equipmentRing2" onChange={this.handleChange} />
                            </Form.Group>
                        </Form>
                    </Modal.Content>
                    <Modal.Actions>
                        <Button negative onClick={this.closeDialog}>Cancel</Button>
                        <Button color='blue' onClick={this.submitDialog}><Icon name='checkmark' />Submit</Button>
                    </Modal.Actions>
                </Modal>
                );
    }
}

export default FormCharacter;