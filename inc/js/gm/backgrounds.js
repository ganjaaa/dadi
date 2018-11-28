var dndBackgrounds = {
    init: function (settings) {
        dndBackgrounds.config = {
            ajaxDatatable: '/v2/datatable/backgrounds',
            ajaxBackgrounds: '/v2/backgrounds',
            ajaxBackgroundsTraits: '/v2/backgroundstraits',
            dataTableId: '#datatableBackgrounds',
            addBtnBackgroundsId: '#btnAddBackgrounds',
            editBtnBackgroundsId: '.btnEditBackgrounds',
            delBtnBackgroundsId: '.btnDeleteBackgrounds',
            addBackgroundsForm: '#Backgrounds_addForm',
            editBackgroundsForm: '#Backgrounds_editForm',
            addBackgroundsTraitsForm: '#BackgroundsTraits_chooseForm',
            addBtnBackgroundsTraitsId: '.btnAddBackgroundsTraits',
            delBtnBackgroundsTraitsId: '.btnDeleteBackgroundsTraits',
            intDataTable: null,
            initSearch: '',
            debug: false
        };

        $.extend(dndBackgrounds.config, settings);

        dndBackgrounds.setup();
    },
    setup: function () {
        dndBackgrounds.setupDatatable();
        dndBackgrounds.setupButtons();
        dndBackgrounds.setupDetailsControl();
    },
    setupButtons: function () {
        $(document)
                .on('click', dndBackgrounds.config.addBtnBackgroundsId, dndBackgrounds.clickAddBackgrounds)
                .on('click', dndBackgrounds.config.editBtnBackgroundsId, dndBackgrounds.clickEditBackgrounds)
                .on('click', dndBackgrounds.config.delBtnBackgroundsId, dndBackgrounds.clickDelBackgrounds)
                .on('click', dndBackgrounds.config.addBtnBackgroundsTraitsId, dndBackgrounds.clickAddBackgroundsTraits)
                .on('click', dndBackgrounds.config.delBtnBackgroundsTraitsId, dndBackgrounds.clickDelBackgroundsTraits);
    },
    setupDatatable: function () {
        dndBackgrounds.config.intDataTable = $(dndBackgrounds.config.dataTableId).DataTable({
            "jQueryUI": false,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: dndBackgrounds.config.ajaxDatatable,
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
                "search": dndBackgrounds.config.initSearch
            },
            columns: [
                {
                    "className": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": ' '
                },
                {data: "name"},
                {data: "proficiency"},
                {
                    "orderable": false,
                    "data": "id",
                    "render": function (data, type, row, meta) {
                        var menu = '';
                        menu += '<div class="ui dropdown right pointing icon button">';
                        menu += '  <i class="settings icon"></i>';
                        menu += '  <div class="menu">';
                        menu += '    <div class="btnEditBackgrounds item" data-id="' + data + '"><i class="large setting icon"></i> Bearbeiten</div>';
                        menu += '    <div class="ui divider"></div>';
                        menu += '    <div class="btnDeleteBackgrounds item" data-id="' + data + '"><i class="large trash icon"></i> Löschen</div>';
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
        $(dndBackgrounds.config.dataTableId + ' tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dndBackgrounds.config.intDataTable.row(tr);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                row.child(dndBackgrounds.showTableData(row.data())).show();
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
                    '           <div class="btnDeleteBackgroundsTraits item" data-id="' + value.id + '"><i class="large trash icon"></i> Löschen</div>' +
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
                '<div class="btnAddBackgroundsTraits ui fluid blue icon button" data-id="' + d.id + '" ><i class="ui plus icon"></i> Add</div>'
        '</div>';
    },
    clickAddBackgrounds: function () {
        dndBackgrounds.ajaxModal(
                dndBackgrounds.config.addBackgroundsForm,
                dndBackgrounds.config.ajaxBackgrounds,
                'POST',
                dndBackgrounds.ajaxDefaultCallback
                );
    },
    clickEditBackgrounds: function () {
        dndBackgrounds.ajaxRequest(dndBackgrounds.config.ajaxBackgrounds + '/' + $(this).data('id'), 'GET', {}, function (data) {
            if (data.success) {
                $(dndBackgrounds.config.editBackgroundsForm + '_name').val(data.data.name);
                $(dndBackgrounds.config.editBackgroundsForm + '_proficiency').val(data.data.proficiency);

                dndBackgrounds.ajaxModal(dndBackgrounds.config.editBackgroundsForm, dndBackgrounds.config.ajaxBackgrounds + '/' + data.data.id, 'POST', dndBackgrounds.ajaxDefaultCallback);
            } else {
                alert(data.message);
            }
        });
    },
    clickDelBackgrounds: function () {
        if (confirm("Wirklich löschen?")) {
            dndBackgrounds.ajaxRequest(dndBackgrounds.config.ajaxBackgrounds + '/' + $(this).data('id'), 'DELETE', {}, dndBackgrounds.ajaxDefaultCallback);
        }
    },
    clickAddBackgroundsTraits: function () {
        var bid = $(this).data('id');
        $(dndBackgrounds.config.addBackgroundsTraitsForm + '_backgroundId').val(bid);
        dndBackgrounds.ajaxModal(
                dndBackgrounds.config.addBackgroundsTraitsForm,
                dndBackgrounds.config.ajaxBackgroundsTraits,
                'POST',
                dndBackgrounds.ajaxDefaultCallback
                );
    },
    clickDelBackgroundsTraits: function () {
        if (confirm("Wirklich löschen?")) {
            dndBackgrounds.ajaxRequest(dndBackgrounds.config.ajaxBackgroundsTraits + '/' + $(this).data('id'), 'DELETE', {}, dndBackgrounds.ajaxDefaultCallback);
        }
    },
    ajaxModal: function (formId, ajaxUrl, ajaxType, myCallback) {
        console.log(formId);
        $(formId).modal({
            closable: false,
            onApprove: function () {
                dndBackgrounds.ajaxRequest(ajaxUrl, ajaxType, $(formId + ' form').serialize(), myCallback);
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
            dndBackgrounds.config.intDataTable.ajax.reload();
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
        if (dndBackgrounds.config.debug) {
            console.log(message);
        }
    },
    getId: function () {
        var now = new Date();
        return now.getMilliseconds();
    },
};
