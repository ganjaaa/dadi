import React from 'react';
import {Route, NavLink, HashRouter} from "react-router-dom";
import { Menu, Icon, Dropdown } from 'semantic-ui-react'

import PageDashboard from "./PageDashboard";
//import PageAccounts from "./PageAccounts";
//import PageCharacters from "./PageCharacters";
//import PageEnvironments from "./PageEnvironments";
//import PageMapsMaps from "./PageMapsMaps";
//import PageObjectsItems from "./PageObjectsItems";
//import PageObjectsSpells from "./PageObjectsSpells";
//import PageObjectsFeatures from "./PageObjectsFeatures";
//import PageObjectsTraits from "./PageObjectsTraits";
//import PageObjectsRaces from "./PageObjectsRaces";
//import PageObjectsClasses from "./PageObjectsClasses";
//import PageObjectsBackgrounds from "./PageObjectsBackgrounds";



class DM extends React.Component {
    render() {
        return(
                <HashRouter>
                    <div id="Start">
                        <Menu inverted className="blue">
                            <Menu.Item as={NavLink}  to="/"><Icon className="dashboard icon" />Dashboard</Menu.Item>
                            <Menu.Item  to="/account" href="/account"><Icon className="user icon" />Accounts</Menu.Item>
                            <Menu.Item  to="/character" href="/character"><Icon className="user icon" />Characters & Inventory</Menu.Item>
                            <Menu.Item  to="/environment" href="/environment"><Icon className="globe icon" />Environments</Menu.Item>
                            <Menu.Item  to="/map" href="/map"><Icon className="map icon" />Map</Menu.Item>

                            <Dropdown item text='Basic Objects'>
                                <Dropdown.Menu>
                                    <Dropdown.Item to="/objects/item" href="/objects/item" icon="cubes" text='Items' />
                                    <Dropdown.Item to="/objects/spell" href="/objects/spell" icon="magic" text='Spells' />
                                    <Dropdown.Item to="/objects/features" href="/objects/features" icon="tag" text='Features' />
                                    <Dropdown.Item to="/objects/traits" href="/objects/traits" icon="cogs" text='Traits' />
                                    <Dropdown.Item to="/objects/races" href="/objects/races" icon="bug" text='Races' />
                                    <Dropdown.Item to="/objects/classes" href="/objects/classes" icon="shield alternate" text='Classes' />
                                    <Dropdown.Item to="/objects/backgrounds" href="/objects/backgrounds" icon="user md" text='Backgrounds' />
                                </Dropdown.Menu>
                            </Dropdown>
                            <div className="right menu">
                                <div className="item">OM_DADI - 0.3.05 alpha</div>
                                <a className="item" href="/logout"><Icon className="sign out" /></a>
                            </div>
                        </Menu>

                        <div className="pusher">
                            <Route exact path="/" component={PageDashboard}/>
                            <Route exact path="/dashboard" component={PageDashboard}/>

                        </div>
                    </div>
                </HashRouter>
                )
    }

}

export default DM;