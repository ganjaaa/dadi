var dndTraits = {
    init: function (settings) {
        dndTraits.config = {
            ajaxDatatable: '/v2/datatable/traits',
            ajaxAddTraits: '/v2/traits',
            ajaxGetTraits: '/v2/traits/',
            ajaxEditTraits: '/v2/traits/',
            ajaxDelTraits: '/v2/traits/',
            dataTableId: '#datatableTraits',
            addBtnTraitsId: '#btnAddTraits',
            editBtnTraitsId: '.btnEditTraits',
            delBtnTraitsId: '.btnDeleteTraits',
            addTraitsForm: '#Traits_addForm',
            editTraitsForm: '#Traits_editForm',
            intDataTable: null,
            initSearch: '',
            debug: false
        };

        $.extend(dndTraits.config, settings);

        dndTraits.setup();
    },
    setup: function () {
        dndTraits.setupDatatable();
        dndTraits.setupButtons();
    },
    setupButtons: function () {
        $(document)
                .on('click', dndTraits.config.addBtnTraitsId, dndTraits.clickAddTraits)
                .on('click', dndTraits.config.editBtnTraitsId, dndTraits.clickEditTraits)
                .on('click', dndTraits.config.delBtnTraitsId, dndTraits.clickDelTraits);
    },
    setupDatatable: function () {
        dndTraits.config.intDataTable = $(dndTraits.config.dataTableId).DataTable({
            "jQueryUI": false,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: dndTraits.config.ajaxDatatable,
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
                "search": dndTraits.config.initSearch
            },
            columns: [
                {data: "id"},
                {data: "name"},
                {data: "description"},
                {data: "modifier"},
                {
                    "orderable": false,
                    "data": "id",
                    "render": function (data, type, row, meta) {
                        var menu = '';
                        menu += '<div class="ui dropdown right pointing icon button">';
                        menu += '  <i class="settings icon"></i>';
                        menu += '  <div class="menu">';
                        menu += '    <div class="btnEditTraits item" data-id="' + data + '"><i class="large setting icon"></i> Bearbeiten</div>';
                        menu += '    <div class="ui divider"></div>';
                        menu += '    <div class="btnDeleteTraits item" data-id="' + data + '"><i class="large trash icon"></i> Löschen</div>';
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
    clickAddTraits: function () {
        dndTraits.ajaxModal(
                dndTraits.config.addTraitsForm,
                dndTraits.config.ajaxAddTraits,
                'POST',
                dndTraits.ajaxDefaultCallback
                );
    },
    clickDelTraits: function () {
        if (confirm("Wirklich löschen?")) {
            dndTraits.ajaxRequest(dndTraits.config.ajaxDelTraits + $(this).data('id'), 'DELETE', {}, dndTraits.ajaxDefaultCallback);
        }
    },
    clickEditTraits: function () {
        dndTraits.ajaxRequest(dndTraits.config.ajaxGetTraits + $(this).data('id'), 'GET', {}, function (data) {
            if (data.success) {
                $(dndTraits.config.editTraitsForm + '_name').val(data.data.name);
                $(dndTraits.config.editTraitsForm + '_description').val(data.data.description);
                $(dndTraits.config.editTraitsForm + '_modifier').val(data.data.modifier);

                dndTraits.ajaxModal(dndTraits.config.editTraitsForm, dndTraits.config.ajaxEditTraits + data.data.id, 'POST', dndTraits.ajaxDefaultCallback);
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
                dndTraits.ajaxRequest(ajaxUrl, ajaxType, $(formId + ' form').serialize(), myCallback);
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
            dndTraits.config.intDataTable.ajax.reload();
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
        if (dndTraits.config.debug) {
            console.log(message);
        }
    }
};
