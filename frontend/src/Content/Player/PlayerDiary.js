import React from 'react';
import Iframe from 'react-iframe'


class PlayerDiary extends React.Component {
  render() {
    return (
      <Iframe url={"http://book.dnd/Player-"+this.props.playerId}  position="absolute" width="100%" id="myDiary" className="myClassname" height="100%"/>
    );
  }
}

export default PlayerDiary;
