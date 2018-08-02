var dndRaces = {
    init: function (settings) {
        dndRaces.config = {
            ajaxDatatable: '/v2/datatable/races',
            ajaxAddRaces: '/v2/races',
            ajaxGetRaces: '/v2/races/',
            ajaxEditRaces: '/v2/races/',
            ajaxDelRaces: '/v2/races/',
            dataTableId: '#datatableRaces',
            addBtnRacesId: '#btnAddRaces',
            editBtnRacesId: '.btnEditRaces',
            delBtnRacesId: '.btnDeleteRaces',
            addRacesForm: '#Races_addForm',
            editRacesForm: '#Races_editForm',
            intDataTable: null,
            initSearch: '',
            debug: false
        };

        $.extend(dndRaces.config, settings);

        dndRaces.setup();
    },
    setup: function () {
        dndRaces.setupDatatable();
        dndRaces.setupButtons();
    },
    setupButtons: function () {
        $(document)
                .on('click', dndRaces.config.addBtnRacesId, dndRaces.clickAddRaces)
                .on('click', dndRaces.config.editBtnRacesId, dndRaces.clickEditRaces)
                .on('click', dndRaces.config.delBtnRacesId, dndRaces.clickDelRaces);
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
    clickAddRaces: function () {
        dndRaces.ajaxModal(
                dndRaces.config.addRacesForm,
                dndRaces.config.ajaxAddRaces,
                'POST',
                dndRaces.ajaxDefaultCallback
                );
    },
    clickDelRaces: function () {
        if (confirm("Wirklich löschen?")) {
            dndRaces.ajaxRequest(dndRaces.config.ajaxDelRaces + $(this).data('id'), 'DELETE', {}, dndRaces.ajaxDefaultCallback);
        }
    },
    clickEditRaces: function () {
        dndRaces.ajaxRequest(dndRaces.config.ajaxGetRaces + $(this).data('id'), 'GET', {}, function (data) {
            if (data.success) {
                $(dndRaces.config.editRacesForm + '_name').val(data.data.name);
                $(dndRaces.config.editRacesForm + '_description').val(data.data.description);
                $(dndRaces.config.editRacesForm + '_weight').val(data.data.weight);
                $(dndRaces.config.editRacesForm + '_priceCP').val(data.data.priceCP);
                $(dndRaces.config.editRacesForm + '_priceSP').val(data.data.priceSP);
                $(dndRaces.config.editRacesForm + '_priceEP').val(data.data.priceEP);
                $(dndRaces.config.editRacesForm + '_priceGP').val(data.data.priceGP);
                $(dndRaces.config.editRacesForm + '_pricePP').val(data.data.pricePP);
                $(dndRaces.config.editRacesForm + '_type').val(data.data.type);
                $(dndRaces.config.editRacesForm + '_magic').val(data.data.magic);
                $(dndRaces.config.editRacesForm + '_rarity').val(data.data.rarity);
                $(dndRaces.config.editRacesForm + '_ac').val(data.data.ac);
                $(dndRaces.config.editRacesForm + '_strength').val(data.data.strength);
                $(dndRaces.config.editRacesForm + '_stealth').val(data.data.stealth);
                $(dndRaces.config.editRacesForm + '_modifier').val(data.data.modifier);
                $(dndRaces.config.editRacesForm + '_roll').val(data.data.roll);
                $(dndRaces.config.editRacesForm + '_dmg1').val(data.data.dmg1);
                $(dndRaces.config.editRacesForm + '_dmg2').val(data.data.dmg2);
                $(dndRaces.config.editRacesForm + '_dmgType').val(data.data.dmgType);
                $(dndRaces.config.editRacesForm + '_property').val(data.data.property);
                $(dndRaces.config.editRacesForm + '_range').val(data.data.range);
                $(dndRaces.config.editRacesForm + '_wearable').val(data.data.wearable);
                $(dndRaces.config.editRacesForm + '_cursed').val(data.data.cursed);

                dndRaces.ajaxModal(dndRaces.config.editRacesForm, dndRaces.config.ajaxEditRaces + data.data.id, 'POST', dndRaces.ajaxDefaultCallback);
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
