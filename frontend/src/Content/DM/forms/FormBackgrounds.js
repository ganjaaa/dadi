import React from "react";
import { Form, Button }
from 'semantic-ui-react'



        class FormBackgrounds extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            api: '/v2/entity/items',
            edit: false,
            data: {
                id: null,
                name: "",
                description: "",
                weight: 0,
                price_cp: 0,
                price_sp: 0,
                price_ep: 0,
                price_gp: 0,
                price_pp: 0,
                magic: false,
                type: "$",
                rarity: "",
                ac: 0,
                strength: 0,
                stealth: 0,
                modifier: "",
                roll: "",
                dmg1: "",
                dmg2: "",
                dmg_type: "",
                property: "",
                rang: "",
                wearable: 0,
                cursed: false,
                stackable: true
            }
        };
    }
    componentWillMount() {
        this.setState({
            api: '/v2/entity/items',
            edit: false,
            data: {
                id: null,
                name: "",
                description: "",
                weight: 0,
                price_cp: 0,
                price_sp: 0,
                price_ep: 0,
                price_gp: 0,
                price_pp: 0,
                magic: false,
                type: "$",
                rarity: "",
                ac: 0,
                strength: 0,
                stealth: 0,
                modifier: "",
                roll: "",
                dmg1: "",
                dmg2: "",
                dmg_type: "",
                property: "",
                rang: "",
                wearable: 0,
                cursed: false,
                stackable: true
            }
        });

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

    handleChange = (e, data) => this.setState({data: Object.assign({}, this.state.data, {[data.uid]: data.value})}
        );
            render() {
        const data = this.state.data

        const yesno = [
            {text: 'Yes', value: '1'},
            {text: 'No', value: '0'},
        ];
        const type = [
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
        const rarity = [
            {value: '0', text: 'COMMON'},
            {value: '1', text: 'UNCOMMON'},
            {value: '2', text: 'RARE'},
            {value: '3', text: 'VERY_RARE'},
            {value: '4', text: 'EPIC'},
            {value: '5', text: 'LEGENDARY'},
            {value: '6', text: 'UNIQUE'}
        ];
        const wear = [
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
        return (
                <Form>
                    <Form.Group widths='equal'>
                        <Form.Input fluid label='Name' placeholder='Magisches Background' defaultValue={data.name} uid="name" onChange={this.handleChange} />
                        <Form.Input fluid label='Weight' placeholder='0.0' defaultValue={data.weight} uid="weight" onChange={this.handleChange} />
                    </Form.Group>
                    <Form.TextArea label='Description' placeholder='' defaultValue={data.description} uid="description" onChange={this.handleChange} />
                    <Form.Group widths='equal'>
                        <Form.Input fluid label='Price CP' placeholder='0' defaultValue={data.price_cp} uid="price_cp" onChange={this.handleChange} />
                        <Form.Input fluid label='Price SP' placeholder='0' defaultValue={data.price_sp} uid="price_sp" onChange={this.handleChange} />
                        <Form.Input fluid label='Price EP' placeholder='0' defaultValue={data.price_ep} uid="price_ep" onChange={this.handleChange} />
                        <Form.Input fluid label='Price GP' placeholder='0' defaultValue={data.price_gp} uid="price_gp" onChange={this.handleChange} />
                        <Form.Input fluid label='Price PP' placeholder='0' defaultValue={data.price_pp} uid="price_pp" onChange={this.handleChange} />
                    </Form.Group>
                    <Form.Group widths='equal'>
                        <Form.Select fluid label='Magic' placeholder="Select Option" options={yesno} value={data.magic} uid="magic" onChange={this.handleChange} />
                        <Form.Select fluid label='Type' placeholder="Select Option" options={type} value={data.type} uid="type" onChange={this.handleChange}  />
                        <Form.Select fluid label='Rarity' placeholder="Select Option"  options={rarity} value={data.rarity} uid="rarity" onChange={this.handleChange} />
                        <Form.Input fluid label='AC' placeholder='0' defaultValue={data.ac} uid="ac" onChange={this.handleChange} />
                    </Form.Group>
                    <Form.Group widths='equal'>
                        <Form.Input fluid label='Strength' placeholder='0' defaultValue={data.strength} uid="strength" onChange={this.handleChange} />
                        <Form.Input fluid label='Stealth' placeholder='0' defaultValue={data.stealth} uid="stealth" onChange={this.handleChange} />
                        <Form.Input fluid label='Modifier' placeholder='' defaultValue={data.modifier} uid="modifier" onChange={this.handleChange} />
                    </Form.Group>
                    <Form.Group widths='equal'>
                        <Form.Input fluid label='Roll' placeholder='0' defaultValue={data.roll} uid="roll" onChange={this.handleChange} />
                        <Form.Input fluid label='Dmg1' placeholder='0' defaultValue={data.dmg1} uid="dmg1" onChange={this.handleChange} />
                        <Form.Input fluid label='Dmg2' placeholder='' defaultValue={data.dmg2} uid="dmg2" onChange={this.handleChange} />
                        <Form.Input fluid label='DmgType' placeholder='' defaultValue={data.dmg_type} uid="dmg_type" onChange={this.handleChange} />
                    </Form.Group>
                    <Form.Group widths='equal'>
                        <Form.Input fluid label='Property' placeholder='0' defaultValue={data.property} uid="property" onChange={this.handleChange} />
                        <Form.Input fluid label='Range' placeholder='0' defaultValue={data.rang} uid="rang" onChange={this.handleChange} />
                        <Form.Select fluid label='Wearable' placeholder='Select Option' options={wear} value={data.wearable} uid="wearable" onChange={this.handleChange} />
                        <Form.Select fluid label='Cursed' placeholder='Select Option' options={yesno} value={data.cursed} uid="cursed" onChange={this.handleChange} />
                    </Form.Group>
                    <Form.Group widths='equal'>
                        <Form.Select fluid label='Stackable' placeholder='Select Option' options={yesno} value={data.stackable} uid="stackable" onChange={this.handleChange} />
                    </Form.Group>
                    <Form.Group widths='equal'>
                        <Form.Button fluid color="blue">Submit</Form.Button>
                        <Form.Button fluid negative>Abort</Form.Button>
                    </Form.Group>
                </Form>
                );
    }
}

export default FormBackgrounds;
