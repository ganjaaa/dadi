import React from 'react';
import { Menu, Tab, Button, Icon, Header, Segment, Comment } from 'semantic-ui-react';
import PlayerQuestlog from './PlayerQuestlog';
import PlayerDiary from './PlayerDiary';
import PlayerUsersheet from './PlayerUsersheet';
import PlayerBackpack from './PlayerBackpack';
import PlayerMagic from './PlayerMagic';
import PlayerTraits from './PlayerTraits';
import PlayerMap from './PlayerMap';
import PlayerLog from './PlayerLog';
import iMoon1 from '../../Images/moon_decreasing.png';
import iMoon2 from '../../Images/moon_full.png';
import iMoon3 from '../../Images/moon_increasing.png';
import iMoon4 from '../../Images/moon_new.png';

class DisplayMoon extends React.Component {
    render() {
        if (this.props.moon === 'decreasing') {
            return <img src={iMoon1} alt={this.props.moon} title={this.props.moon} style={{height: '2em', width: '2em'}} />;
        }
        if (this.props.moon === 'full') {
            return <img src={iMoon2} alt={this.props.moon} title={this.props.moon} style={{height: '2em', width: '2em'}} />;
        }
        if (this.props.moon === 'increasing') {
            return<img src={iMoon3} alt={this.props.moon} title={this.props.moon} style={{height: '2em', width: '2em'}} />;
        }
        return <img src={iMoon4} alt={this.props.moon} title={this.props.moon} style={{height: '2em', width: '2em'}}/>;
    }
}

class Player extends React.Component {
    constructor(props) {
        super(props);
        this.updatePoll = this.updatePoll.bind(this);
        this.updateInformations = this.updateInformations.bind(this);
    }
    state = {
        userId: null,
        intervalId: null,
        displayPopup: 'none',
        popupText: [],
        timeoutId: null,
        userlist: [],
        environment: {
            "day": "11", "month": "11", "year": "1189", "time": "00:00", "weather": "Wetter", "temperature": "22", "humidity": "30", "smog": "0"
            , "date": {
                "time": "00:00", "day": "11", "month": "11", "monthWord": "Ludnar", "year": "1189", "moon1": "decreasing", "moon2": "increasing"}
        },
        charsheet: {
            "charname": "Mustmann",
            "race": "Dragonborn",
            "class": "Barbarian",
            "background": "Soldier",
            "alignment": "Neutral neutral",
            "inspiration": 0,
            "proficiency": 0,
            "initiative": 0,
            "speed": 0,
            "ac": 0
            , "hp": {
                "max": 0, "now": "0", "tmp": "0"}
            , "deathSaves": {
                "success": "", "failture": 0}
            , "level": {
                "level": 0, "exp": "0", "expCap": 0, "levelup": 1}
            , "money": {
                "copper": "0", "silver": "0", "electrum": "0", "gold": "0", "platinum": "0"}
            , "savingThrows": {
                "strength": {
                    "value": 10, "modifier": 0, "modifier_raw": 0, "_value": "10", "_valueBonus": 0, "_mod": 0, "_modBonus": 0, "proficiency": "0"}
                , "dexterity": {
                    "value": 10, "modifier": 0, "modifier_raw": 0, "_value": "10", "_valueBonus": 0, "_mod": 0, "_modBonus": 0, "proficiency": "0"}
                , "constitution": {
                    "value": 10, "modifier": 0, "modifier_raw": 0, "_value": "10", "_valueBonus": 0, "_mod": 0, "_modBonus": 0, "proficiency": "0"}
                , "intelligence": {
                    "value": 10, "modifier": 0, "modifier_raw": 0, "_value": "10", "_valueBonus": 0, "_mod": 0, "_modBonus": 0, "proficiency": "0"}
                , "wisdom": {
                    "value": 10, "modifier": 0, "modifier_raw": 0, "_value": "10", "_valueBonus": 0, "_mod": 0, "_modBonus": 0, "proficiency": "0"}
                , "charisma": {
                    "value": 10, "modifier": 0, "modifier_raw": 0, "_value": "10", "_valueBonus": 0, "_mod": 0, "_modBonus": 0, "proficiency": "0"}
            }
            , "skills": {
                "acrobatics": {
                    "value": 0, "_value": 0, "_valueBonus": 0, "proficiency": "0"}
                , "animalHandling": {
                    "value": 0, "_value": 0, "_valueBonus": 0, "proficiency": "0"}
                , "arcana": {
                    "value": 0, "_value": 0, "_valueBonus": 0, "proficiency": "0"}
                , "athletics": {
                    "value": 0, "_value": 0, "_valueBonus": 0, "proficiency": "0"}
                , "deception": {
                    "value": 0, "_value": 0, "_valueBonus": 0, "proficiency": "0"}
                , "history": {
                    "value": 0, "_value": 0, "_valueBonus": 0, "proficiency": "0"}
                , "insight": {
                    "value": 0, "_value": 0, "_valueBonus": 0, "proficiency": "0"}
                , "intimidation": {
                    "value": 0, "_value": 0, "_valueBonus": 0, "proficiency": "0"}
                , "investigation": {
                    "value": 0, "_value": 0, "_valueBonus": 0, "proficiency": "0"}
                , "medicine": {
                    "value": 0, "_value": 0, "_valueBonus": 0, "proficiency": "0"}
                , "nature": {
                    "value": 0, "_value": 0, "_valueBonus": 0, "proficiency": "0"}
                , "perception": {
                    "value": 0, "_value": 0, "_valueBonus": 0, "proficiency": "0"}
                , "performance": {
                    "value": 0, "_value": 0, "_valueBonus": 0, "proficiency": "0"}
                , "persuasion": {
                    "value": 0, "_value": 0, "_valueBonus": 0, "proficiency": "0"}
                , "religion": {
                    "value": 0, "_value": 0, "_valueBonus": 0, "proficiency": "0"}
                , "sleightOfHand": {
                    "value": 0, "_value": 0, "_valueBonus": 0, "proficiency": "0"}
                , "stealth": {
                    "value": 0, "_value": 0, "_valueBonus": 0, "proficiency": "0"}
                , "survival": {
                    "value": 0, "_value": 0, "_valueBonus": 0, "proficiency": "0"}
            }
            , "equipment": {
                "quiver1": 0, "quiver2": 0, "quiver3": 0, "helmet": 0, "cape": 0, "necklace": 0, "weapon1": 0, "weapon2": 0, "weapon3": 0, "offweapon": 0, "gloves": 0, "armor": 0, "object": 0, "belt": 0, "boots": 0, "ring1": 0, "ring2": 0}

        },
        magic: {
            "modifier": null, "slots": [0]
        },
        traits: {
            race: [],
            class: [],
            background: [],
            languages: []
        },
        map: '',
    }

    componentDidMount = () => {
        this.updateInformations();
        var intervalId = setInterval(this.updatePoll, 5000);
        this.setState({intervalId: intervalId});
    }

    componentWillUnmount = () => {
        clearInterval(this.state.intervalId);
    }

    updatePoll() {
        fetch('/api/v1/info/poll', {method: "GET"})
                .then(response => response.json())
                .then(data => {
                    if (data.data.message.length > 0) {
                        this.setState({
                            displayPopup: 'block',
                            popupText: data.data.messages
                        });
                        
                        if(this.state.timeoutId !== null){
                            clearTimeout(this.state.timeoutId);
                        }
                        var timeoutId = setTimeout(function () {
                            this.setState({
                                displayPopup: 'none'
                            });
                        }.bind(this), (10 * 1000));
                        this.setState({timeoutId: timeoutId});
                    }
                    if (data.data.reload === 1) {
                        this.updateInformations();
                    }
                });
    }

    updateInformations() {
        fetch('/api/v1/info/charsheet', {method: "GET"})
                .then(response => response.json())
                .then(data => {
                    var ulist = data.data.Userlist.map(function (usr) {
                        return {text: usr.charname, value: usr.id};
                    });

                    this.setState({
                        userId: data.data.UserId,
                        traits: data.data.Traits,
                        charsheet: data.data.Charsheet,
                        environment: data.data.Enviroment,
                        magic: data.data.Magic,
                        userlist: ulist,
                        map: data.data.Map
                    });
                });
    }

    render() {
        const panes = [
            {menuItem: 'Charsheet', render: () => <PlayerUsersheet charsheet={this.state.charsheet} />},
            {menuItem: 'Backpack', render: () => <PlayerBackpack userlist={this.state.userlist} refreshInfos={this.updateInformations} />},
            {menuItem: 'Magic', render: () => <PlayerMagic magic={this.state.magic} />},
            {menuItem: 'Traits', render: () => <PlayerTraits traits={this.state.traits} />},
            {menuItem: 'Questlog', render: () => <PlayerQuestlog />},
            {menuItem: 'Diary', render: () => <PlayerDiary playerId={this.state.userId} />},
            {menuItem: 'Map', render: () => <PlayerMap map={this.state.map} />},
            {menuItem: 'Log', render: () => <PlayerLog />}
        ];

        return (
                <div>
                    <Menu inverted size="small" color="blue" style={{marginBottom: '5px'}}>
                        <Menu.Item>{this.state.environment.date.time}</Menu.Item>
                        <Menu.Item>{this.state.environment.date.day}.{this.state.environment.date.month}.{this.state.environment.date.year} - {this.state.environment.date.monthWord}</Menu.Item>
                        <Menu.Item>{this.state.environment.weater} (Temp: {this.state.environment.temperature}°C Hum: {this.state.environment.humidity}%)</Menu.Item>
                        <Menu.Item><DisplayMoon moon={this.state.environment.date.moon1} /> <DisplayMoon moon={this.state.environment.date.moon2} /></Menu.Item>
                        <Menu.Item>Smog: {this.state.environment.smog}%</Menu.Item>
                        <Menu.Menu position='right'>
                            <Menu.Item>{this.state.charsheet.charname} Lvl {this.state.charsheet.level.level} ({this.state.charsheet.level.exp}/{this.state.charsheet.level.expCap})</Menu.Item>
                            <Menu.Item><Button as="a" inverted icon href="/logout" ><Icon name="sign-out" /></Button></Menu.Item>
                        </Menu.Menu>
                    </Menu>
                    <div style={{padding: '5px'}}>
                        <Tab panes={panes} />
                    </div>
                    <div style={{display: this.state.displayPopup, position: 'fixed', zIndex: '9999', bottom: 0, right: 0, height: '50%', width: '33%'}}>
                        <Header as="h3" attached='top'>Message <Icon name='link remove' style={{float: 'right'}} /></Header>
                        <Segment attached='bottom' style={{height: '100%'}}>
                            <Comment.Group>
                                {this.state.popupText.map((obj, i) => {
                                        return (
                                        <Comment key={i}>
                                            <Comment.Content>
                                                <Comment.Author as='b'>Dadi</Comment.Author>
                                                <Comment.Metadata>
                                                    <div>{obj.date}</div>
                                                </Comment.Metadata>
                                                <Comment.Text dangerouslySetInnerHTML={{__html: obj.message}}></Comment.Text>
                                            </Comment.Content>
                                        </Comment>
                                                )
                                    })}
                            </Comment.Group>
                
                        </Segment>
                    </div>
                </div>
                );
    }
}

export default Player;