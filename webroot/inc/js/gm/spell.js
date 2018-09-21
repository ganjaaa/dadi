var dndSpell = {
    init: function (settings) {
        dndSpell.config = {
            ajaxDatatable: '/v2/datatable/spell',
            ajaxAddSpell: '/v2/spell',
            ajaxGetSpell: '/v2/spell/',
            ajaxEditSpell: '/v2/spell/',
            ajaxDelSpell: '/v2/spell/',
            dataTableId: '#datatableSpell',
            addBtnSpellId: '#btnAddSpell',
            editBtnSpellId: '.btnEditSpell',
            delBtnSpellId: '.btnDeleteSpell',
            addSpellForm: '#Spell_addForm',
            editSpellForm: '#Spell_editForm',
            intDataTable: null,
            initSearch: '',
            debug: false
        };

        $.extend(dndSpell.config, settings);

        dndSpell.setup();
    },
    setup: function () {
        dndSpell.setupDatatable();
        dndSpell.setupButtons();
    },
    setupButtons: function () {
        $(document)
                .on('click', dndSpell.config.addBtnSpellId, dndSpell.clickAddSpell)
                .on('click', dndSpell.config.editBtnSpellId, dndSpell.clickEditSpell)
                .on('click', dndSpell.config.delBtnSpellId, dndSpell.clickDelSpell);
    },
    setupDatatable: function () {
        dndSpell.config.intDataTable = $(dndSpell.config.dataTableId).DataTable({
            "jQueryUI": false,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: dndSpell.config.ajaxDatatable,
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
                "search": dndSpell.config.initSearch
            },
            columns: [
                {data: "id"},
                {data: "name"},
                {data: "description"},
                {
                    "orderable": false,
                    "data": "id",
                    "render": function (data, type, row, meta) {
                        var menu = '';
                        menu += '<div class="ui dropdown right pointing icon button">';
                        menu += '  <i class="settings icon"></i>';
                        menu += '  <div class="menu">';
                        menu += '    <div class="btnEditSpell item" data-id="' + data + '"><i class="large setting icon"></i> Bearbeiten</div>';
                        menu += '    <div class="ui divider"></div>';
                        menu += '    <div class="btnDeleteSpell item" data-id="' + data + '"><i class="large trash icon"></i> Löschen</div>';
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
    clickAddSpell: function () {
        dndSpell.ajaxModal(
                dndSpell.config.addSpellForm,
                dndSpell.config.ajaxAddSpell,
                'POST',
                dndSpell.ajaxDefaultCallback
                );
    },
    clickDelSpell: function () {
        if (confirm("Wirklich löschen?")) {
            dndSpell.ajaxRequest(dndSpell.config.ajaxDelSpell + $(this).data('id'), 'DELETE', {}, dndSpell.ajaxDefaultCallback);
        }
    },
    clickEditSpell: function () {
        dndSpell.ajaxRequest(dndSpell.config.ajaxGetSpell + $(this).data('id'), 'GET', {}, function (data) {
            if (data.success) {
                $(dndSpell.config.editSpellForm + '_name').val(data.data.name);
                $(dndSpell.config.editSpellForm + '_description').val(data.data.description);
                $(dndSpell.config.editSpellForm + '_level').val(data.data.level);
                $(dndSpell.config.editSpellForm + '_school').val(data.data.school);
                $(dndSpell.config.editSpellForm + '_time').val(data.data.time);
                $(dndSpell.config.editSpellForm + '_range').val(data.data.range);
                $(dndSpell.config.editSpellForm + '_components').val(data.data.components);
                $(dndSpell.config.editSpellForm + '_duration').val(data.data.duration);
                $(dndSpell.config.editSpellForm + '_classes').val(data.data.classes);
                $(dndSpell.config.editSpellForm + '_roll').val(data.data.roll);
                $(dndSpell.config.editSpellForm + '_ritual').val(data.data.ritual);

                dndSpell.ajaxModal(dndSpell.config.editSpellForm, dndSpell.config.ajaxEditSpell + data.data.id, 'POST', dndSpell.ajaxDefaultCallback);
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
                dndSpell.ajaxRequest(ajaxUrl, ajaxType, $(formId + ' form').serialize(), myCallback);
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
            dndSpell.config.intDataTable.ajax.reload();
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
        if (dndSpell.config.debug) {
            console.log(message);
        }
    }
};
