import React from 'react';
import { Accordion, Grid, Icon, Button, Header } from 'semantic-ui-react';
import ReactTable from "react-table";



class PlayerMagic extends React.Component {
    state = {
        activeIndex: 0,
        ajax: '/api/v1/datatable/spell',
        loading: false,
        pages: '-1',
        pageSize: 10,
        sorted: [],
        filtered: [],
        data: [],
    }

    handleClick = (e, titleProps) => {
        const {index} = titleProps
        const {activeIndex} = this.state
        const newIndex = activeIndex === index ? -1 : index
        if (newIndex === -1 || (this.props.magic[1].slots[newIndex] && this.props.magic[1].slots[newIndex] > 0)) {
            this.setState({activeIndex: newIndex});
        }
    }

    reloadHandler = e => {
        this.table.fireFetchData();
    }

    render() {
        const {activeIndex} = this.state

        const columns = [{
                Header: 'Name',
                accessor: 'name',
                filterable: true
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
                            </Button.Group>
                            )
            }];


        return (
                <div>
        DoTo: Spells Auf die Klasse Limitieren (momentan sind alle drinnen), Funktionen von Mount, Verbrauch etc, Multiklassen erweiterung (Regeln anlesen) Spell Ability Ausschreiben
                    <Header as="h3" className="centered" style={{paddingTop: '10px'}}>Your Spell Ability: {this.props.magic[1].modifier}</Header>
                    <Grid columns='equal'>
                        <Grid.Column width={9}>
                            <Accordion fluid styled>
                                <Accordion.Title active={activeIndex === 0} index={0} onClick={this.handleClick}>
                                    <Icon name='dropdown' /> 0/{this.props.magic[1].slots[0]} - Cantrips Level
                                </Accordion.Title>
                                <Accordion.Content active={activeIndex === 0}>
                                    -- Leer
                                </Accordion.Content>
                                <Accordion.Title active={activeIndex === 1} index={1} onClick={this.handleClick}>
                                    <Icon name='dropdown' /> 0/{this.props.magic[1].slots[1]} - Level 1
                                </Accordion.Title>
                                <Accordion.Content active={activeIndex === 1}>
                                    -- Leer
                                </Accordion.Content>
                                <Accordion.Title active={activeIndex === 2} index={2} onClick={this.handleClick}>
                                    <Icon name='dropdown' /> 0/{this.props.magic[1].slots[2]} - Level 2
                                </Accordion.Title>
                                <Accordion.Content active={activeIndex === 2}>
                                    -- Leer
                                </Accordion.Content>
                                <Accordion.Title active={activeIndex === 3} index={3} onClick={this.handleClick}>
                                    <Icon name='dropdown' /> 0/{this.props.magic[1].slots[3]} - Level 3
                                </Accordion.Title>
                                <Accordion.Content active={activeIndex === 3}>
                                    -- Leer
                                </Accordion.Content>
                                <Accordion.Title active={activeIndex === 4} index={4} onClick={this.handleClick}>
                                    <Icon name='dropdown' /> 0/{this.props.magic[1].slots[4]} - Level 4
                                </Accordion.Title>
                                <Accordion.Content active={activeIndex === 4}>
                                    -- Leer
                                </Accordion.Content>
                                <Accordion.Title active={activeIndex === 5} index={5} onClick={this.handleClick}>
                                    <Icon name='dropdown' /> 0/{this.props.magic[1].slots[5]} - Level 5
                                </Accordion.Title>
                                <Accordion.Content active={activeIndex === 5}>
                                    -- Leer
                                </Accordion.Content>
                                <Accordion.Title active={activeIndex === 6} index={6} onClick={this.handleClick}>
                                    <Icon name='dropdown' /> 0/{this.props.magic[1].slots[6]} - Level 6
                                </Accordion.Title>
                                <Accordion.Content active={activeIndex === 6}>
                                    -- Leer
                                </Accordion.Content>
                                <Accordion.Title active={activeIndex === 7} index={7} onClick={this.handleClick}>
                                    <Icon name='dropdown' /> 0/{this.props.magic[1].slots[7]} - Level 7
                                </Accordion.Title>
                                <Accordion.Content active={activeIndex === 7}>
                                    -- Leer
                                </Accordion.Content>
                                <Accordion.Title active={activeIndex === 8} index={8} onClick={this.handleClick}>
                                    <Icon name='dropdown' /> 0/{this.props.magic[1].slots[8]} - Level 8
                                </Accordion.Title>
                                <Accordion.Content active={activeIndex === 8}>
                                    -- Leer
                                </Accordion.Content>
                                <Accordion.Title active={activeIndex === 9} index={9} onClick={this.handleClick}>
                                    <Icon name='dropdown' /> 0/{this.props.magic[1].slots[9]} - Level 9
                                </Accordion.Title>
                                <Accordion.Content active={activeIndex === 9}>
                                    -- Leer
                                </Accordion.Content>
                            </Accordion>
                        </Grid.Column>
                        <Grid.Column width={7}>
                
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
                                SubComponent={row => {
                                    return (<div style={{whiteSpace: 'pre-wrap', padding: '5px'}}>{row.original.description}</div> );
                                    }}
                
                                />
                
                        </Grid.Column>
                    </Grid>
                </div>
                );
    }
}

export default PlayerMagic;
