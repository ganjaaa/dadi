import React from 'react';
import { Grid, Header, List, Segment } from 'semantic-ui-react';


class PlayerTraits extends React.Component {
    render() {
        return (
                <Grid columns='equal'>
                    <Grid.Column >
                        <Segment raised>
                            <Header as="h3" className="centered">Race Traits</Header>
                            <List style={{maxHeight: '36em', overflowY: 'scroll', overflowX: 'hidden'}}>
                            {this.props.traits.race.map((obj, i) => {
                                    return (
                                        <List.Item key={i}>
                                            <List.Header>{obj.name}</List.Header>
                                            {obj.description}
                                        </List.Item>
                                            )
                                })}
                            </List>
                        </Segment>
                    </Grid.Column>
                    <Grid.Column >
                        <Segment raised>
                            <Header as="h3" className="centered">Class Traits</Header>
                            <List>
                            {this.props.traits.class.map((obj, i) => {
                                    return (
                                        <List.Item key={i}>
                                            <List.Header>{obj.name}</List.Header>
                                            {obj.description}
                                        </List.Item>
                                            )
                                })}
                            </List>
                        </Segment>

                    </Grid.Column>
                    <Grid.Column >
                        <Segment raised>
                            <Header as="h3" className="centered">Other Proficiencies</Header>
                            <List>
                            {this.props.traits.background.map((obj, i) => {
                                    return (
                                        <List.Item key={i}>
                                            <List.Header>{obj.name}</List.Header>
                                            {obj.description}
                                        </List.Item>
                                            )
                                })}
                            </List>
                        </Segment>

                    </Grid.Column>
                    <Grid.Column >
                        <Segment raised>
                            <Header as="h3" className="centered">Languages</Header>
                            <List>
                            {this.props.traits.languages.map((obj, i) => {
                                    return (
                                        <List.Item key={i}>
                                            <List.Header>{obj.name}</List.Header>
                                            {obj.description}
                                        </List.Item>
                                            )
                                })}
                            </List>
                        </Segment>

                    </Grid.Column>

                </Grid>
                );
    }
}

export default PlayerTraits;
