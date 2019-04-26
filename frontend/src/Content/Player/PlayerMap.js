import React from 'react';
import { Segment, Image } from 'semantic-ui-react';


class PlayerMap extends React.Component {
    render() {
        return (
                <Segment raised>
                    <Image alt="Map" src={this.props.map} style={{margin: '0 auto'}} /> 
                </Segment>
                );
    }
}

export default PlayerMap;
