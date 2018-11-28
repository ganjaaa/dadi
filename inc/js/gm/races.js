var dndRaces = {
    init: function (settings) {
        dndRaces.config = {
            ajaxDatatable: '/v2/datatable/races',
            ajaxRaces: '/v2/races',
            ajaxRacesTraits: '/v2/racestraits',
            dataTableId: '#datatableRaces',
            addBtnRacesId: '#btnAddRaces',
            editBtnRacesId: '.btnEditRaces',
            delBtnRacesId: '.btnDeleteRaces',
            addRacesForm: '#Races_addForm',
            editRacesForm: '#Races_editForm',
            addRacesTraitsForm: '#RacesTraits_chooseForm',
            addBtnRacesTraitsId: '.btnAddRacesTraits',
            delBtnRacesTraitsId: '.btnDeleteRacesTraits',
            intDataTable: null,
            initSearch: '',
            debug: false
        };

        $.extend(dndRaces.config, settings);

        dndRaces.setup();
    },
    setup: function () {
        dndRaces.setupDatatable();
        dndRaces.setupDetailsControl();
        dndRaces.setupButtons();
    },
    setupButtons: function () {
        $(document)
                .on('click', dndRaces.config.addBtnRacesId, dndRaces.clickAddRaces)
                .on('click', dndRaces.config.editBtnRacesId, dndRaces.clickEditRaces)
                .on('click', dndRaces.config.delBtnRacesId, dndRaces.clickDelRaces)
                .on('click', dndRaces.config.addBtnRacesTraitsId, dndRaces.clickAddRacesTraits)
                .on('click', dndRaces.config.delBtnRacesTraitsId, dndRaces.clickDelRacesTraits);
    },
    setupDatatable: function () {
        dndRaces.config.intDataTable = $(dndRaces.config.dataTableId).DataTable({
            "jQueryUI": false,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: dndRaces.config.ajaxDatatable,
                dataSrc: 'data',
                type: 'POST'
            },
            "initComplete": function (settings, json) {
                $('.ui.dropdown').dropdown();
            },
            "drawCallback": function (settings) {
                $('.ui.dropdown').dropdown();
            },
            "search": {
                "search": dndRaces.config.initSearch
            },
            columns: [
                {
                    "className": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": ' '
                },
                {data: "name"},
                {data: "size"},
                {data: "speed"},
                {data: "ability"},
                {data: "proficiency"},
                {
                    "orderable": false,
                    "data": "id",
                    "render": function (data, type, row, meta) {
                        var menu = '';
                        menu += '<div class="ui dropdown right pointing icon button">';
                        menu += '  <i class="settings icon"></i>';
                        menu += '  <div class="menu">';
                        menu += '    <div class="btnEditRaces item" data-id="' + data + '"><i class="large setting icon"></i> Bearbeiten</div>';
                        menu += '    <div class="ui divider"></div>';
                        menu += '    <div class="btnDeleteRaces item" data-id="' + data + '"><i class="large trash icon"></i> Löschen</div>';
                        menu += '  </div>';
                        menu += '</div>';
                        return menu;
                    }
                },
            ],
            "oLanguage": {
                "sEmptyTable": "Keine Daten in der Tabelle vorhanden",
                "sInfo": "_START_ bis _END_ von _TOTAL_ ",
                "sInfoEmpty": "0 bis 0 von 0 Einträgen",
                "sInfoFiltered": "(gefiltert von _MAX_ Einträgen)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ Einträge anzeigen",
                "sLoadingRecords": "Wird geladen...",
                "sProcessing": "Bitte warten...",
                "sSearchPlaceholder": " ",
                "sSearch": "<div class='ui fluid field' style='width:100%'>_INPUT_</div>",
                "sZeroRecords": "Keine Einträge vorhanden.",
                "oPaginate": {
                    "sFirst": "Erste",
                    "sPrevious": "Zurück",
                    "sNext": "Nächste",
                    "sLast": "Letzte"
                },
                "oAria": {
                    "sSortAscending": ": aktivieren, um Spalte aufsteigend zu sortieren",
                    "sSortDescending": ": aktivieren, um Spalte absteigend zu sortieren"
                }
            }
        });
    },    
    setupDetailsControl: function () {
        $(dndRaces.config.dataTableId + ' tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dndRaces.config.intDataTable.row(tr);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                row.child(dndRaces.showTableData(row.data())).show();
                tr.addClass('shown');
                $('.ui.dropdown').dropdown();
            }
        });
    },
    showTableData: function (d) {
        var tableData = '';
        $.each(d.traits, function (key, value) {
            tableData += '' +
                    '<tr>' +
                    '<td>0</td>' +
                    '<td>' + value.trait.name + '</td>' +
                    '<td>' + value.trait.description + '</td>' +
                    '<td>' + value.trait.modifier + '</td>' +
                    '<td>' +
                    '   <div class="ui blue datatablemenu dropdown right pointing icon button">' +
                    '       <i class="settings icon"></i>' +
                    '       <div class="menu">' +
                    '           <div class="btnDeleteRacesTraits item" data-id="' + value.id + '"><i class="large trash icon"></i> Löschen</div>' +
                    '       </div>' +
                    '   </div>' +
                    '</td>' +
                    '</tr>';
        });
        return '<div class="ui stackable grid" style="margin: 10px">' +
                '<div class="column">' +
                '<h3>Traits</h3>' +
                '<table class="ui compact striped table" style="">' +
                '<thead><tr><th>Level</th><th>Name</th><th>Description</th><th>Modifier</th><th>Options</th></tr></thead>' +
                '<tbody>' + tableData + '</tbody>' +
                '</table>' +
                '<div class="btnAddRacesTraits ui fluid blue icon button" data-id="' + d.id + '" ><i class="ui plus icon"></i> Add</div>'
        '</div>';
    },
    clickAddRaces: function () {
        dndRaces.ajaxModal(
                dndRaces.config.addRacesForm,
                dndRaces.config.ajaxRaces,
                'POST',
                dndRaces.ajaxDefaultCallback
                );
    },
    clickDelRaces: function () {
        if (confirm("Wirklich löschen?")) {
            dndRaces.ajaxRequest(dndRaces.config.ajaxRaces + '/' + $(this).data('id'), 'DELETE', {}, dndRaces.ajaxDefaultCallback);
        }
    },
     clickAddRacesTraits: function () {
        var bid = $(this).data('id');
        $(dndRaces.config.addRacesTraitsForm + '_raceId').val(bid);
        dndRaces.ajaxModal(
                dndRaces.config.addRacesTraitsForm,
                dndRaces.config.ajaxRacesTraits,
                'POST',
                dndRaces.ajaxDefaultCallback
                );
    },
    clickDelRacesTraits: function () {
        if (confirm("Wirklich löschen?")) {
            dndRaces.ajaxRequest(dndRaces.config.ajaxRacesTraits + '/' + $(this).data('id'), 'DELETE', {}, dndRaces.ajaxDefaultCallback);
        }
    },
    clickEditRaces: function () {
        dndRaces.ajaxRequest(dndRaces.config.ajaxRaces + '/' + $(this).data('id'), 'GET', {}, function (data) {
            if (data.success) {
                $(dndRaces.config.editRacesForm + '_name').val(data.data.name);
                $(dndRaces.config.editRacesForm + '_size').val(data.data.size);
                $(dndRaces.config.editRacesForm + '_speed').val(data.data.speed);
                $(dndRaces.config.editRacesForm + '_ability').val(data.data.ability);
                $(dndRaces.config.editRacesForm + '_proficiency').val(data.data.proficiency);

                dndRaces.ajaxModal(dndRaces.config.editRacesForm, dndRaces.config.ajaxRaces + '/' + data.data.id, 'POST', dndRaces.ajaxDefaultCallback);
            } else {
                alert(data.message);
            }
        });
    },
    ajaxModal: function (formId, ajaxUrl, ajaxType, myCallback) {
        console.log(formId);
        $(formId).modal({
            closable: false,
            onApprove: function () {
                dndRaces.ajaxRequest(ajaxUrl, ajaxType, $(formId + ' form').serialize(), myCallback);
            }
        }).modal('show');
    },
    ajaxRequest: function (ajaxUrl, ajaxType, ajaxData, myCallback) {
        $.ajax({
            url: ajaxUrl,
            dataType: 'json',
            type: ajaxType,
            data: ajaxData,
            success: myCallback
        });
    },
    ajaxDefaultCallback: function (data) {
        if (data.success) {
            dndRaces.config.intDataTable.ajax.reload();
        } else {
            alert(data.message);
        }
    },
    doReload: function () {
        location.reload();
    },
    getZeit: function () {
        var now = new Date();
        return now.getUTCHours() + ":" + now.getUTCMinutes() + ":" + now.getUTCSeconds();
    },
    printDebug: function (message) {
        if (dndRaces.config.debug) {
            console.log(message);
        }
    }
};
