import React from 'react';
import { Grid, Table, Icon }
from 'semantic-ui-react';
import Background from '../../Images/CharSheet.jpg';

class UsersheetAbility extends React.Component {
    render() {
        const {title, modifier, value} = this.props;
        const prefixContent = (Number(modifier) >= 0) ? '+' : '';
        return (
                <div className="ui raised segment">
                    <div className="ui small header">{title}</div>
                    <div className="ui header" style={{marginTop: 0, marginBottom: 0}}>{prefixContent}{modifier}</div>
                    <div className="ui bottom right attached label">{value}</div>
                </div>
                );
    }
}

class UsersheetRow extends React.Component {
    render() {
        const {star, title, value} = this.props;
        const starContent = (Number(star) > 0) ? <Icon color="blue" name="star" /> : <div />;
        const prefixContent = (Number(value) >= 0) ? '+' : '';
        return (
                <Table.Row>
                    <Table.Cell style={{padding: "0.3em", fontSize: "1em", lineHeight: "1em"}}>{starContent}{title}</Table.Cell>
                    <Table.Cell style={{padding: "0.3em", fontSize: "1em", lineHeight: "1em"}}>{prefixContent}{value}</Table.Cell>
                </Table.Row>
                );
    }
}

class UsersheetItem extends React.Component {
    render() {
        const {title, item, content} = this.props;
        const x = this.props.x + 'px';
        const y = this.props.y + 'px';
        const imageContent = (item && Number(item) > 0) ? <img src={"/image/" + item} className="ui image" alt="" /> : <div style={{margin: '1em auto', display: 'block', textAlign: 'center', fontSize: '0.9em'}}>{content}</div>;
        return (
                <div className="ui segment" style={{left: x, top: y, position: 'absolute', height: '50px', width: '50px', border: '1px solid black', padding: '0 0 0 0', borderRadius: '3px', backgroundColor: 'rgba(0,0,0,0.4)', margin: 0, color: '#fff'}}>
                    {imageContent}
                    <div className="ui blue bottom right attached label" style={{padding: '0.1em'}}>{title}</div>
                </div>
                );
    }
}

class PlayerUsersheet extends React.Component {
    componentDidMount = () => {
    }
    render() {
        const cellStyle = {padding: "0.3em", fontSize: "1em", lineHeight: "1em"};
        return (
                <Grid columns='equal'>
                    <Grid.Column width={2}>
                        <UsersheetAbility title="Strength" modifier={this.props.charsheet.savingThrows.strength.modifier_raw} value={this.props.charsheet.savingThrows.strength.value} />
                        <UsersheetAbility title="Dexterity" modifier={this.props.charsheet.savingThrows.dexterity.modifier_raw} value={this.props.charsheet.savingThrows.dexterity.value} />
                        <UsersheetAbility title="Constitution" modifier={this.props.charsheet.savingThrows.constitution.modifier_raw} value={this.props.charsheet.savingThrows.constitution.value} />
                        <UsersheetAbility title="Intelligence" modifier={this.props.charsheet.savingThrows.intelligence.modifier_raw} value={this.props.charsheet.savingThrows.intelligence.value} />
                        <UsersheetAbility title="Wisdom" modifier={this.props.charsheet.savingThrows.wisdom.modifier_raw} value={this.props.charsheet.savingThrows.wisdom.value} />
                        <UsersheetAbility title="Charisma" modifier={this.props.charsheet.savingThrows.charisma.modifier_raw} value={this.props.charsheet.savingThrows.charisma.value} />
                    </Grid.Column>
                    <Grid.Column>
                        <Table size="small" striped>
                            <Table.Header></Table.Header>
                            <Table.Body>
                                <Table.Row>
                                    <Table.Cell style={cellStyle}><b>Proficiency:</b> {this.props.charsheet.proficiency}</Table.Cell>
                                    <Table.Cell style={cellStyle}><b>Speed:</b> {this.props.charsheet.speed}</Table.Cell>
                                    <Table.Cell style={cellStyle}><b>Saves:</b></Table.Cell>
                                    <Table.Cell style={cellStyle}><b>HP</b></Table.Cell>
                                    <Table.Cell style={cellStyle}><b>Angriff</b></Table.Cell>
                                </Table.Row>
                                <Table.Row>
                                    <Table.Cell style={cellStyle}><b>Inspiration:</b> {this.props.charsheet.inspiration}</Table.Cell>
                                    <Table.Cell style={cellStyle}><b>AC:</b> {this.props.charsheet.ac}</Table.Cell>
                                    <Table.Cell style={cellStyle}><Icon name="checkmark" />: {this.props.charsheet.deathSaves.success}/3</Table.Cell>
                                    <Table.Cell style={cellStyle}>{this.props.charsheet.hp.now}/{this.props.charsheet.hp.max}+({this.props.charsheet.hp.tmp})</Table.Cell>
                                    <Table.Cell style={cellStyle}></Table.Cell>
                                </Table.Row>
                                <Table.Row>
                                    <Table.Cell style={cellStyle}><b>Initiative:</b> {this.props.charsheet.initiative}</Table.Cell>
                                    <Table.Cell style={cellStyle}></Table.Cell>
                                    <Table.Cell style={cellStyle}><Icon name="remove" />: {this.props.charsheet.deathSaves.failture}/3</Table.Cell>
                                    <Table.Cell style={cellStyle}></Table.Cell>
                                    <Table.Cell style={cellStyle}></Table.Cell>
                                </Table.Row>
                            </Table.Body>
                        </Table>
                        <Grid columns='equal'>
                            <Grid.Column width={5}>
                                <Table size="small" striped>
                                    <Table.Header></Table.Header>
                                    <Table.Body>
                                        <UsersheetRow title="Strength" star={this.props.charsheet.savingThrows.strength.proficiency} value={this.props.charsheet.savingThrows.strength.modifier}></UsersheetRow>
                                        <UsersheetRow title="Dexterity" star={this.props.charsheet.savingThrows.dexterity.proficiency} value={this.props.charsheet.savingThrows.dexterity.modifier}></UsersheetRow>
                                        <UsersheetRow title="Constitution" star={this.props.charsheet.savingThrows.constitution.proficiency} value={this.props.charsheet.savingThrows.constitution.modifier}></UsersheetRow>
                                        <UsersheetRow title="Intelligence" star={this.props.charsheet.savingThrows.intelligence.proficiency} value={this.props.charsheet.savingThrows.intelligence.modifier}></UsersheetRow>
                                        <UsersheetRow title="Wisdom" star={this.props.charsheet.savingThrows.wisdom.proficiency} value={this.props.charsheet.savingThrows.wisdom.modifier}></UsersheetRow>
                                        <UsersheetRow title="Charisma" star={this.props.charsheet.savingThrows.charisma.proficiency} value={this.props.charsheet.savingThrows.charisma.modifier}></UsersheetRow>
                                    </Table.Body>
                                </Table>
                                <Table size="small" striped>
                                    <Table.Header></Table.Header>
                                    <Table.Body>
                                        <UsersheetRow title="Acrobatics (Dex)" star={this.props.charsheet.skills.acrobatics.proficiency} value={this.props.charsheet.skills.acrobatics.value}></UsersheetRow>
                                        <UsersheetRow title="AnimalHandling (Wis)" star={this.props.charsheet.skills.animalHandling.proficiency} value={this.props.charsheet.skills.animalHandling.value}></UsersheetRow>
                                        <UsersheetRow title="Arcana (Int)" star={this.props.charsheet.skills.arcana.proficiency} value={this.props.charsheet.skills.arcana.value}></UsersheetRow>
                                        <UsersheetRow title="Athletics (Str)" star={this.props.charsheet.skills.athletics.proficiency} value={this.props.charsheet.skills.athletics.value}></UsersheetRow>
                                        <UsersheetRow title="Deception (Cha)" star={this.props.charsheet.skills.deception.proficiency} value={this.props.charsheet.skills.deception.value}></UsersheetRow>
                                        <UsersheetRow title="History (Int)" star={this.props.charsheet.skills.history.proficiency} value={this.props.charsheet.skills.history.value}></UsersheetRow>
                                        <UsersheetRow title="Insight (Wis)" star={this.props.charsheet.skills.insight.proficiency} value={this.props.charsheet.skills.insight.value}></UsersheetRow>
                                        <UsersheetRow title="Intimidation (Cha)" star={this.props.charsheet.skills.intimidation.proficiency} value={this.props.charsheet.skills.intimidation.value}></UsersheetRow>
                                        <UsersheetRow title="Investigation (Int)" star={this.props.charsheet.skills.investigation.proficiency} value={this.props.charsheet.skills.investigation.value}></UsersheetRow>
                                        <UsersheetRow title="Medicine (Wis)" star={this.props.charsheet.skills.medicine.proficiency} value={this.props.charsheet.skills.medicine.value}></UsersheetRow>
                                        <UsersheetRow title="Nature (Int)" star={this.props.charsheet.skills.nature.proficiency} value={this.props.charsheet.skills.nature.value}></UsersheetRow>
                                        <UsersheetRow title="Perception (Wis)" star={this.props.charsheet.skills.perception.proficiency} value={this.props.charsheet.skills.perception.value}></UsersheetRow>
                                        <UsersheetRow title="Performance (Cha)" star={this.props.charsheet.skills.performance.proficiency} value={this.props.charsheet.skills.performance.value}></UsersheetRow>
                                        <UsersheetRow title="Persuasion (Cha)" star={this.props.charsheet.skills.persuasion.proficiency} value={this.props.charsheet.skills.persuasion.value}></UsersheetRow>
                                        <UsersheetRow title="Religion (Int)" star={this.props.charsheet.skills.religion.proficiency} value={this.props.charsheet.skills.religion.value}></UsersheetRow>
                                        <UsersheetRow title="Sleight of Hand (Dex)" star={this.props.charsheet.skills.sleightOfHand.proficiency} value={this.props.charsheet.skills.sleightOfHand.value}></UsersheetRow>
                                        <UsersheetRow title="Stealth (Dex)" star={this.props.charsheet.skills.stealth.proficiency} value={this.props.charsheet.skills.stealth.value}></UsersheetRow>
                                        <UsersheetRow title="Survival (Wis)" star={this.props.charsheet.skills.survival.proficiency} value={this.props.charsheet.skills.survival.value}></UsersheetRow>
                                    </Table.Body>
                                </Table>
                            </Grid.Column>
                            <Grid.Column>
                                <div style={{backgroundSize: "100%", backgroundImage: `url(${Background})`, height: "500px", width: "367px", position: "relative"}}>
                                    <div style={{height: "1px", width: "1px"}}></div>
                                    <UsersheetItem title="Quiver" x="317" y="0" item={this.props.charsheet.equipment.quiver1} />
                                    <UsersheetItem title="Quiver" x="317" y="50" item={this.props.charsheet.equipment.quiver2} />
                                    <UsersheetItem title="Quiver" x="317" y="100" item={this.props.charsheet.equipment.quiver3} />
                                    <UsersheetItem title="Helm" x="165" y="30" item={this.props.charsheet.equipment.helmet} />
                                    <UsersheetItem title="Necklace" x="165" y="85" item={this.props.charsheet.equipment.necklace} />
                                    <UsersheetItem title="Cape" x="220" y="85" item={this.props.charsheet.equipment.cape} />
                                    <UsersheetItem title="Armor" x="165" y="140" item={this.props.charsheet.equipment.armor} />
                
                                    <UsersheetItem title="Belt" x="165" y="195" item={this.props.charsheet.equipment.belt} />
                                    <UsersheetItem title="Boots" x="165" y="390" item={this.props.charsheet.equipment.boots} />
                                    <UsersheetItem title="Gloves" x="220" y="195" item={this.props.charsheet.equipment.gloves} />
                                    <UsersheetItem title="Ring" x="275" y="195" item={this.props.charsheet.equipment.ring1} />
                                    <UsersheetItem title="Ring" x="275" y="250" item={this.props.charsheet.equipment.ring2} />
                                    <UsersheetItem title="Weapon" x="110" y="195" item={this.props.charsheet.equipment.weapon1} />
                                    <UsersheetItem title="Weapon" x="110" y="250" item={this.props.charsheet.equipment.weapon2} />
                                    <UsersheetItem title="Weapon" x="110" y="305" item={this.props.charsheet.equipment.weapon3} />
                
                                    <UsersheetItem title="CP" x="0" y="00" content={this.props.charsheet.money.copper} />
                                    <UsersheetItem title="SP" x="0" y="50" content={this.props.charsheet.money.silver} />
                                    <UsersheetItem title="EP" x="0" y="100" content={this.props.charsheet.money.electrum} />
                                    <UsersheetItem title="GP" x="0" y="150" content={this.props.charsheet.money.gold} />
                                    <UsersheetItem title="PP" x="0" y="200" content={this.props.charsheet.money.platinum} />
                                </div>
                            </Grid.Column>
                        </Grid>
                    </Grid.Column>
                </Grid>
                );
    }
}

export default PlayerUsersheet;