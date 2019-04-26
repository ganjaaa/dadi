var dndClasses = {
    init: function (settings) {
        dndClasses.config = {
            ajaxDatatable: '/v2/datatable/classes',
            ajaxAddClasses: '/v2/classes',
            ajaxGetClasses: '/v2/classes/',
            ajaxEditClasses: '/v2/classes/',
            ajaxDelClasses: '/v2/classes/',
            dataTableId: '#datatableClasses',
            addBtnClassesId: '#btnAddClasses',
            editBtnClassesId: '.btnEditClasses',
            delBtnClassesId: '.btnDeleteClasses',
            addClassesForm: '#Classes_addForm',
            editClassesForm: '#Classes_editForm',
            intDataTable: null,
            initSearch: '',
            debug: false
        };

        $.extend(dndClasses.config, settings);

        dndClasses.setup();
    },
    setup: function () {
        dndClasses.setupDatatable();
        dndClasses.setupDetailsControl();
        dndClasses.setupButtons();
    },
    setupButtons: function () {
        $(document)
                .on('click', dndClasses.config.addBtnClassesId, dndClasses.clickAddClasses)
                .on('click', dndClasses.config.editBtnClassesId, dndClasses.clickEditClasses)
                .on('click', dndClasses.config.delBtnClassesId, dndClasses.clickDelClasses);
    },
    setupDatatable: function () {
        dndClasses.config.intDataTable = $(dndClasses.config.dataTableId).DataTable({
            "jQueryUI": false,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: dndClasses.config.ajaxDatatable,
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
                "search": dndClasses.config.initSearch
            },
            columns: [
                {
                    "className": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": ' '
                },
                {data: "name"},
                {data: "hd"},
                {
                    data: "proficiency",
                    "render": function (data, type, row, meta) {
                        return row.cleanProficiency;
                    }
                },
                {data: "spellAbility"},
                {
                    "orderable": false,
                    "data": "id",
                    "render": function (data, type, row, meta) {
                        var menu = '';
                        menu += '<div class="ui dropdown right pointing icon button">';
                        menu += '  <i class="settings icon"></i>';
                        menu += '  <div class="menu">';
                        menu += '    <div class="btnEditClasses item" data-id="' + data + '"><i class="large setting icon"></i> Bearbeiten</div>';
                        menu += '    <div class="ui divider"></div>';
                        menu += '    <div class="btnDeleteClasses item" data-id="' + data + '"><i class="large trash icon"></i> Löschen</div>';
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
        $(dndClasses.config.dataTableId + ' tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dndClasses.config.intDataTable.row(tr);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                row.child(dndClasses.showTableData(row.data())).show();
                tr.addClass('shown');
                $('.ui.dropdown').dropdown();
                $('.menu .item').tab();
            }
        });
    },
    showTableData: function (d) {
        var changeFirst = '1';
        var menu =
                '<div class="ui top attached tabular menu">' +
                '<a class="active item" data-tab="tabulator1">1</a>';
        var body =
                '<div class="ui bottom attached active tab segment" data-tab="tabulator1">' +
                '<table class="ui compact striped table" style="">' +
                '<thead><tr><th>Kind</th><th>Name</th><th>Description</th><th>Options</th></tr></thead>' +
                '<tbody>';

        $.each(d.levels, function (key, value) {
            if (changeFirst != value.level) {
                changeFirst = value.level;
                menu += '<a class="item" data-tab="tabulator' + value.level + '">' + value.level + '</a>';
                body += '</tbody>' +
                        '</table>' +
                        '</div>' +
                        '<div class="ui bottom attached tab segment" data-tab="tabulator' + value.level + '">' +
                        '<table class="ui compact striped table" style="">' +
                        '<thead><tr><th>ID</th><th>Kind</th><th>Name</th><th>Description</th><th>Options</th></tr></thead>' +
                        '<tbody>';
            }

            body +=
                    '<tr>' +
                    '<td>' + value.clean.id + '</td>' +
                    '<td>' + value.cleanKind + '</td>' +
                    '<td>' + value.clean.name + '</td>' +
                    '<td>' + value.clean.description + '</td>' +
                    '<td>' +
                    '   <div class="ui blue datatablemenu dropdown right pointing icon button">' +
                    '       <i class="settings icon"></i>' +
                    '       <div class="menu">' +
                    '           <div class="btnDeleteClassLevel item" data-id="' + value.id + '"><i class="large trash icon"></i> Löschen</div>' +
                    '       </div>' +
                    '   </div>' +
                    '</td>' +
                    '</tr>';
        });

        menu += '</tbody>' +
                '</table>' +
                '</div>';
        body += '</div>';
        return menu + body;



        var tableData = '';
        var changeFirst = 'X';
        var changeSecond = 'X';
        $.each(d.levels, function (key, value) {
            tableData += '' +
                    '<tr>' +
                    '<td>' + (changeFirst == value.level ? '' : value.level) + '</td>' +
                    '<td>' + value.cleanKind + '</td>' +
                    '<td>' + value.clean.id + '</td>' +
                    '<td>' + value.clean.name + '</td>' +
                    '<td>' +
                    '   <div class="ui blue datatablemenu dropdown right pointing icon button">' +
                    '       <i class="settings icon"></i>' +
                    '       <div class="menu">' +
                    '           <div class="btnDeleteClassLevel item" data-id="' + value.id + '"><i class="large trash icon"></i> Löschen</div>' +
                    '       </div>' +
                    '   </div>' +
                    '</td>' +
                    '</tr>';
            if (changeFirst != value.level)
                changeFirst = value.level;
            if (changeSecond != value.cleanKind)
                changeSecond = value.cleanKind;
        });
        return '<div class="ui stackable grid" style="margin: 10px">' +
                '<div class="column">' +
                '<h3>Traits</h3>' +
                '<table class="ui compact striped table" style="">' +
                '<thead><tr><th>Level</th><th>Typ</th><th>ID</th><th>Name</th><th>Options</th></tr></thead>' +
                '<tbody>' + tableData + '</tbody>' +
                '</table>' +
                '<div class="btnAddBackgroundsTraits ui fluid blue icon button" data-id="' + d.id + '" ><i class="ui plus icon"></i> Add</div>'
        '</div>';
    },
    clickAddClasses: function () {
        dndClasses.ajaxModal(
                dndClasses.config.addClassesForm,
                dndClasses.config.ajaxAddClasses,
                'POST',
                dndClasses.ajaxDefaultCallback
                );
    },
    clickDelClasses: function () {
        if (confirm("Wirklich löschen?")) {
            dndClasses.ajaxRequest(dndClasses.config.ajaxDelClasses + $(this).data('id'), 'DELETE', {}, dndClasses.ajaxDefaultCallback);
        }
    },
    clickEditClasses: function () {
        dndClasses.ajaxRequest(dndClasses.config.ajaxGetClasses + $(this).data('id'), 'GET', {}, function (data) {
            if (data.success) {
                $(dndClasses.config.editClassesForm + '_name').val(data.data.name);
                $(dndClasses.config.editClassesForm + '_hd').val(data.data.hd);
                $(dndClasses.config.editClassesForm + '_spellAbility').val(data.data.spellAbility);

                if (!data.data.proficiency) {
                    data.data.proficiency = '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0';
                }
                var sk = data.data.proficiency.split(";");
                dndClasses.setDropdown(dndClasses.config.editClassesForm + '_acrobatics', sk[0]);
                dndClasses.setDropdown(dndClasses.config.editClassesForm + '_acrobatics', sk[0]);
                dndClasses.setDropdown(dndClasses.config.editClassesForm + '_animalHandling', sk[1]);
                dndClasses.setDropdown(dndClasses.config.editClassesForm + '_arcana', sk[2]);
                dndClasses.setDropdown(dndClasses.config.editClassesForm + '_athletics', sk[3]);
                dndClasses.setDropdown(dndClasses.config.editClassesForm + '_deception', sk[4]);
                dndClasses.setDropdown(dndClasses.config.editClassesForm + '_history', sk[5]);
                dndClasses.setDropdown(dndClasses.config.editClassesForm + '_insight', sk[6]);
                dndClasses.setDropdown(dndClasses.config.editClassesForm + '_intimidation', sk[7]);
                dndClasses.setDropdown(dndClasses.config.editClassesForm + '_investigation', sk[8]);
                dndClasses.setDropdown(dndClasses.config.editClassesForm + '_medicine', sk[9]);
                dndClasses.setDropdown(dndClasses.config.editClassesForm + '_nature', sk[10]);
                dndClasses.setDropdown(dndClasses.config.editClassesForm + '_perception', sk[11]);
                dndClasses.setDropdown(dndClasses.config.editClassesForm + '_performance', sk[12]);
                dndClasses.setDropdown(dndClasses.config.editClassesForm + '_persuasion', sk[13]);
                dndClasses.setDropdown(dndClasses.config.editClassesForm + '_religion', sk[14]);
                dndClasses.setDropdown(dndClasses.config.editClassesForm + '_sleightOfHand', sk[15]);
                dndClasses.setDropdown(dndClasses.config.editClassesForm + '_stealth', sk[16]);
                dndClasses.setDropdown(dndClasses.config.editClassesForm + '_survival', sk[17]);

                dndClasses.ajaxModal(dndClasses.config.editClassesForm, dndClasses.config.ajaxEditClasses + data.data.id, 'POST', dndClasses.ajaxDefaultCallback);
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
                dndClasses.ajaxRequest(ajaxUrl, ajaxType, $(formId + ' form').serialize(), myCallback);
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
            dndClasses.config.intDataTable.ajax.reload();
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
        if (dndClasses.config.debug) {
            console.log(message);
        }
    },
    setDropdown: function (id, value) {
        $(id).val(value);
        $(id).dropdown('set value', value);
    },
};
