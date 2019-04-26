import React from "react";
import { Form, Button } from 'semantic-ui-react';


class FormAccount extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            api: '/v2/account',
            edit: false,
            data: {
                id: null,
                active: 0,
                mail: '',
                password: '',
                gm: 0
            }
        };
    }
    componentWillMount() {
        this.setState({
            api: '/v2/account',
            edit: false,
            data: {
                id: null,
                active: 0,
                mail: '',
                password: '',
                gm: 0
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
        const data = this.state.data;

        const chooseBool = [
            {text: 'Yes', value: '1'},
            {text: 'No', value: '0'},
        ];

        return (
                <Form>
                    <Form.Group widths='equal'>
                        <Form.Select fluid label='Active' placeholder="Select Option" options={chooseBool} value={data.magic} uid="active" onChange={this.handleChange} />
                        <Form.Select fluid label='Admin' placeholder="Select Option" options={chooseBool} value={data.magic} uid="gm" onChange={this.handleChange} />
                    </Form.Group>
                    <Form.Group widths='equal'>
                        <Form.Input fluid label='E-Mail' placeholder='0' defaultValue={data.price_cp} uid="mail" onChange={this.handleChange} />
                        <Form.Input fluid label='Password' placeholder='0' defaultValue={data.price_sp} uid="password" onChange={this.handleChange} />
                    </Form.Group>
                    <Form.Group widths='equal'>
                        <Form.Button fluid color="blue">Submit</Form.Button>
                        <Form.Button fluid negative>Abort</Form.Button>
                    </Form.Group>
                </Form>
                );
    }
}

export default FormAccount;
