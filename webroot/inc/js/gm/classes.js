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
                {data: "id"},
                {data: "name"},
                {data: "hd"},
                {data: "proficiency"},
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
                $(dndClasses.config.editClassesForm + '_proficiency').val(data.data.proficiency);
                $(dndClasses.config.editClassesForm + '_spellAbility').val(data.data.spellAbility);
             
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
    }
};
