var dndBackgrounds = {
    init: function (settings) {
        dndBackgrounds.config = {
            ajaxDatatable: '/v2/datatable/backgrounds',
            ajaxAddBackgrounds: '/v2/backgrounds',
            ajaxGetBackgrounds: '/v2/backgrounds/',
            ajaxEditBackgrounds: '/v2/backgrounds/',
            ajaxDelBackgrounds: '/v2/backgrounds/',
            dataTableId: '#datatableBackgrounds',
            addBtnBackgroundsId: '#btnAddBackgrounds',
            editBtnBackgroundsId: '.btnEditBackgrounds',
            delBtnBackgroundsId: '.btnDeleteBackgrounds',
            addBackgroundsForm: '#Backgrounds_addForm',
            editBackgroundsForm: '#Backgrounds_editForm',
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
    },
    setupButtons: function () {
        $(document)
                .on('click', dndBackgrounds.config.addBtnBackgroundsId, dndBackgrounds.clickAddBackgrounds)
                .on('click', dndBackgrounds.config.editBtnBackgroundsId, dndBackgrounds.clickEditBackgrounds)
                .on('click', dndBackgrounds.config.delBtnBackgroundsId, dndBackgrounds.clickDelBackgrounds);
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
                {data: "id"},
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
    clickAddBackgrounds: function () {
        dndBackgrounds.ajaxModal(
                dndBackgrounds.config.addBackgroundsForm,
                dndBackgrounds.config.ajaxAddBackgrounds,
                'POST',
                dndBackgrounds.ajaxDefaultCallback
                );
    },
    clickDelBackgrounds: function () {
        if (confirm("Wirklich löschen?")) {
            dndBackgrounds.ajaxRequest(dndBackgrounds.config.ajaxDelBackgrounds + $(this).data('id'), 'DELETE', {}, dndBackgrounds.ajaxDefaultCallback);
        }
    },
    clickEditBackgrounds: function () {
        dndBackgrounds.ajaxRequest(dndBackgrounds.config.ajaxGetBackgrounds + $(this).data('id'), 'GET', {}, function (data) {
            if (data.success) {
                $(dndBackgrounds.config.editBackgroundsForm + '_name').val(data.data.name);
                $(dndBackgrounds.config.editBackgroundsForm + '_proficiency').val(data.data.proficiency);

                dndBackgrounds.ajaxModal(dndBackgrounds.config.editBackgroundsForm, dndBackgrounds.config.ajaxEditBackgrounds + data.data.id, 'POST', dndBackgrounds.ajaxDefaultCallback);
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
    }
};
