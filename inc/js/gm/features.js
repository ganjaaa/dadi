var dndFeatures = {
    init: function (settings) {
        dndFeatures.config = {
            ajaxDatatable: '/v2/datatable/features',
            ajaxAddFeatures: '/v2/features',
            ajaxGetFeatures: '/v2/features/',
            ajaxEditFeatures: '/v2/features/',
            ajaxDelFeatures: '/v2/features/',
            dataTableId: '#datatableFeatures',
            addBtnFeaturesId: '#btnAddFeatures',
            editBtnFeaturesId: '.btnEditFeatures',
            delBtnFeaturesId: '.btnDeleteFeatures',
            addFeaturesForm: '#Features_addForm',
            editFeaturesForm: '#Features_editForm',
            intDataTable: null,
            initSearch: '',
            debug: false
        };

        $.extend(dndFeatures.config, settings);

        dndFeatures.setup();
    },
    setup: function () {
        dndFeatures.setupDatatable();
        dndFeatures.setupButtons();
    },
    setupButtons: function () {
        $(document)
                .on('click', dndFeatures.config.addBtnFeaturesId, dndFeatures.clickAddFeatures)
                .on('click', dndFeatures.config.editBtnFeaturesId, dndFeatures.clickEditFeatures)
                .on('click', dndFeatures.config.delBtnFeaturesId, dndFeatures.clickDelFeatures);
    },
    setupDatatable: function () {
        dndFeatures.config.intDataTable = $(dndFeatures.config.dataTableId).DataTable({
            "jQueryUI": false,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: dndFeatures.config.ajaxDatatable,
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
                "search": dndFeatures.config.initSearch
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
                        menu += '    <div class="btnEditFeatures item" data-id="' + data + '"><i class="large setting icon"></i> Bearbeiten</div>';
                        menu += '    <div class="ui divider"></div>';
                        menu += '    <div class="btnDeleteFeatures item" data-id="' + data + '"><i class="large trash icon"></i> Löschen</div>';
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
    clickAddFeatures: function () {
        dndFeatures.ajaxModal(
                dndFeatures.config.addFeaturesForm,
                dndFeatures.config.ajaxAddFeatures,
                'POST',
                dndFeatures.ajaxDefaultCallback
                );
    },
    clickDelFeatures: function () {
        if (confirm("Wirklich löschen?")) {
            dndFeatures.ajaxRequest(dndFeatures.config.ajaxDelFeatures + $(this).data('id'), 'DELETE', {}, dndFeatures.ajaxDefaultCallback);
        }
    },
    clickEditFeatures: function () {
        dndFeatures.ajaxRequest(dndFeatures.config.ajaxGetFeatures + $(this).data('id'), 'GET', {}, function (data) {
            if (data.success) {
                $(dndFeatures.config.editFeaturesForm + '_name').val(data.data.name);
                $(dndFeatures.config.editFeaturesForm + '_description').val(data.data.description);
                $(dndFeatures.config.editFeaturesForm + '_modifier').val(data.data.modifier);

                dndFeatures.ajaxModal(dndFeatures.config.editFeaturesForm, dndFeatures.config.ajaxEditFeatures + data.data.id, 'POST', dndFeatures.ajaxDefaultCallback);
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
                dndFeatures.ajaxRequest(ajaxUrl, ajaxType, $(formId + ' form').serialize(), myCallback);
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
            dndFeatures.config.intDataTable.ajax.reload();
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
        if (dndFeatures.config.debug) {
            console.log(message);
        }
    }
};
