import React from "react";
import { Segment } from 'semantic-ui-react';
import ReactTable from "react-table";


class PlayerLog extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            ajax: '/api/v1/datatable/log',
            loading: false,
            pages: '-1',
            pageSize: 10,
            sorted: [],
            filtered: [],
            data: [],
        };

        this.reloadHandler = this.reloadHandler.bind(this);
    }

    reloadHandler(e) {
        this.table.fireFetchData();
    }

    render() {
        const columns = [{
                Header: 'Date',
                accessor: 'date',
                filterable: true,
                sortable: true
            }, {
                Header: 'Message',
                accessor: 'message',
                filterable: true
            }];

        return  (
                <Segment>
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
                
                        />
                </Segment>
                )
    }
}

export default PlayerLog;
