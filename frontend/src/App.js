import 'semantic-ui-css-offline/semantic.min.css';
import 'react-table/react-table.css'
import './style.css'
import React from 'react';
import { Button, Form, Grid, Header, Segment, Message } from 'semantic-ui-react'

import Player from './Content/Player/Player';
import DM from './Content/DM/DM';


class App extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            data: {
                formUser: '',
                formPassword: ''
            },
            userId: 0,
            dm: false,
            message: <div></div>
        };

        this.handleClick = this.handleClick.bind(this);
    }

    checkLogin() {
        fetch('/api/v0/check', {method: "GET"})
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.setState({
                            userId: data.data.id,
                            dm: data.data.admin,
                        })
                    }
                });
    }

    handleClick() {
        var formData = new FormData();
        formData.append('username', this.state.data.formUser);
        formData.append('password', this.state.data.formPassword);
        fetch('/api/v0/login', {method: "POST", body: formData})
                .then(response => response.json())
                .then(data => {
                    this.checkLogin();
                    this.setState({
                        message: (<Message negative><Message.Header>Error</Message.Header>{data.message}</Message>)
                    });
                });
    }

    handleChange = (e, data) => this.setState({data: Object.assign({}, this.state.data, {[data.uid]: data.value})}
        )


    componentWillMount() {
        this.checkLogin();
    }

    render() {
        const {userId, dm} = this.state;
        if (userId > 0) {
            if (dm) {
                return (<DM />);
            } else {
                return (<Player />);
            }
        } else {
            const data = this.state.data;

            return (
                    <div className='login-form'>
                        <style>{` body > div,body > div > div, body > div > div > div.login-form {  height: 100%; } `}</style>
                        <Grid textAlign='center' verticalAlign="middle" style={{height: '100%'}}>
                            <Grid.Column style={{maxWidth: 450}}>
                                <Header as='h2' color='blue' textAlign='center'>Log-in to your account</Header>
                                <Form size='large'>
                                    <Segment>
                                        <Form.Input fluid icon='user' iconPosition='left' placeholder='E-mail address' uid="formUser" defaultValue={data.formUser} onChange={this.handleChange} />
                                        <Form.Input fluid icon='lock' iconPosition='left' placeholder='Password' type='password' uid="formPassword"  defaultValue={data.formPassword} onChange={this.handleChange} />
                                        <Button color='blue' fluid size='large' onClick={this.handleClick}>Login</Button>
                                    </Segment>
                                </Form>
                                {this.state.message}
                            </Grid.Column>
                        </Grid>
                    </div>
                    );
        }
    }
}

export default App;
