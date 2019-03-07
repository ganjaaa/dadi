var dndEnvironment = {
    init: function (settings) {
        dndEnvironment.config = {
            ajaxDatatable: '/v2/datatable/environment',
            ajaxAddEnvironment: '/v2/environment',
            ajaxGetEnvironment: '/v2/environment/',
            ajaxEditEnvironment: '/v2/environment/',
            ajaxDelEnvironment: '/v2/environment/',
            dataTableId: '#datatableEnvironment',
            addBtnEnvironmentId: '#btnAddEnvironment',
            editBtnEnvironmentId: '.btnEditEnvironment',
            delBtnEnvironmentId: '.btnDeleteEnvironment',
            addEnvironmentForm: '#Environment_addForm',
            editEnvironmentForm: '#Environment_editForm',
            intDataTable: null,
            initSearch: '',
            debug: false
        };

        $.extend(dndEnvironment.config, settings);

        dndEnvironment.setup();
    },
    setup: function () {
        dndEnvironment.setupDatatable();
        dndEnvironment.setupButtons();
    },
    setupButtons: function () {
        $(document)
                .on('click', dndEnvironment.config.addBtnEnvironmentId, dndEnvironment.clickAddEnvironment)
                .on('click', dndEnvironment.config.editBtnEnvironmentId, dndEnvironment.clickEditEnvironment)
                .on('click', dndEnvironment.config.delBtnEnvironmentId, dndEnvironment.clickDelEnvironment);
    },
    setupDatatable: function () {
        dndEnvironment.config.intDataTable = $(dndEnvironment.config.dataTableId).DataTable({
            "jQueryUI": false,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: dndEnvironment.config.ajaxDatatable,
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
                "search": dndEnvironment.config.initSearch
            },
            columns: [
                {data: "id"},
                {data: "name"},
                {data: "modifier"},
                {
                    "orderable": false,
                    "data": "id",
                    "render": function (data, type, row, meta) {
                        var menu = '';
                        menu += '<div class="ui dropdown right pointing icon button">';
                        menu += '  <i class="settings icon"></i>';
                        menu += '  <div class="menu">';
                        menu += '    <div class="btnEditEnvironment item" data-id="' + data + '"><i class="large setting icon"></i> Bearbeiten</div>';
                        menu += '    <div class="ui divider"></div>';
                        menu += '    <div class="btnDeleteEnvironment item" data-id="' + data + '"><i class="large trash icon"></i> Löschen</div>';
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
    clickAddEnvironment: function () {
        dndEnvironment.ajaxModal(
                dndEnvironment.config.addEnvironmentForm,
                dndEnvironment.config.ajaxAddEnvironment,
                'POST',
                dndEnvironment.ajaxDefaultCallback
                );
    },
    clickDelEnvironment: function () {
        if (confirm("Wirklich löschen?")) {
            dndEnvironment.ajaxRequest(dndEnvironment.config.ajaxDelEnvironment + $(this).data('id'), 'DELETE', {}, dndEnvironment.ajaxDefaultCallback);
        }
    },
    clickEditEnvironment: function () {
        dndEnvironment.ajaxRequest(dndEnvironment.config.ajaxGetEnvironment + $(this).data('id'), 'GET', {}, function (data) {
            if (data.success) {
                $(dndEnvironment.config.editEnvironmentForm + '_name').val(data.data.name);
                $(dndEnvironment.config.editEnvironmentForm + '_time').val(data.data.time);
                $(dndEnvironment.config.editEnvironmentForm + '_day').val(data.data.day);
                $(dndEnvironment.config.editEnvironmentForm + '_month').val(data.data.month);
                $(dndEnvironment.config.editEnvironmentForm + '_year').val(data.data.year);
                $(dndEnvironment.config.editEnvironmentForm + '_weather').val(data.data.weather);
                $(dndEnvironment.config.editEnvironmentForm + '_temperature').val(data.data.temperature);
                $(dndEnvironment.config.editEnvironmentForm + '_humidity').val(data.data.humidity);
                $(dndEnvironment.config.editEnvironmentForm + '_smog').val(data.data.smog);
                $(dndEnvironment.config.editEnvironmentForm + '_modifier').val(data.data.modifier);
                dndEnvironment.ajaxModal(dndEnvironment.config.editEnvironmentForm, dndEnvironment.config.ajaxEditEnvironment + data.data.id, 'POST', dndEnvironment.ajaxDefaultCallback);
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
                dndEnvironment.ajaxRequest(ajaxUrl, ajaxType, $(formId + ' form').serialize(), myCallback);
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
            dndEnvironment.config.intDataTable.ajax.reload();
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
        if (dndEnvironment.config.debug) {
            console.log(message);
        }
    }
};
