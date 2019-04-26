import React from 'react';
import Iframe from 'react-iframe'


class PlayerQuestlog extends React.Component {
  render() {
    return (
      <Iframe url="http://book.dnd/GlobalQuestlog"
            position="absolute"
            width="100%"
            id="myQuestlog"
            className="myClassname"
            height="100%"/>
    );
  }
}

export default PlayerQuestlog;
