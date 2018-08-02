var dndRaces = {
    init: function (settings) {
        dndRaces.config = {
            ajaxDatatable: '/v2/datatable/item',
            ajaxAddItems: '/v2/item',
            ajaxGetItems: '/v2/item/',
            ajaxEditItems: '/v2/item/',
            ajaxDelItems: '/v2/item/',
            dataTableId: '#datatableItems',
            addBtnItemsId: '#btnAddItems',
            editBtnItemsId: '.btnEditItems',
            delBtnItemsId: '.btnDeleteItems',
            addItemsForm: '#Item_addForm',
            editItemsForm: '#Item_editForm',
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
                .on('click', dndRaces.config.addBtnItemsId, dndRaces.clickAddItems)
                .on('click', dndRaces.config.editBtnItemsId, dndRaces.clickEditItems)
                .on('click', dndRaces.config.delBtnItemsId, dndRaces.clickDelItems);
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
                        menu += '    <div class="btnEditItems item" data-id="' + data + '"><i class="large setting icon"></i> Bearbeiten</div>';
                        menu += '    <div class="ui divider"></div>';
                        menu += '    <div class="btnDeleteItems item" data-id="' + data + '"><i class="large trash icon"></i> Löschen</div>';
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
    clickAddItems: function () {
        dndRaces.ajaxModal(
                dndRaces.config.addItemsForm,
                dndRaces.config.ajaxAddItems,
                'POST',
                dndRaces.ajaxDefaultCallback
                );
    },
    clickDelItems: function () {
        if (confirm("Wirklich löschen?")) {
            dndRaces.ajaxRequest(dndRaces.config.ajaxDelItems + $(this).data('id'), 'DELETE', {}, dndRaces.ajaxDefaultCallback);
        }
    },
    clickEditItems: function () {
        dndRaces.ajaxRequest(dndRaces.config.ajaxGetItems + $(this).data('id'), 'GET', {}, function (data) {
            if (data.success) {
                $(dndRaces.config.editItemsForm + '_name').val(data.data.name);
                $(dndRaces.config.editItemsForm + '_description').val(data.data.description);
                $(dndRaces.config.editItemsForm + '_weight').val(data.data.weight);
                $(dndRaces.config.editItemsForm + '_priceCP').val(data.data.priceCP);
                $(dndRaces.config.editItemsForm + '_priceSP').val(data.data.priceSP);
                $(dndRaces.config.editItemsForm + '_priceEP').val(data.data.priceEP);
                $(dndRaces.config.editItemsForm + '_priceGP').val(data.data.priceGP);
                $(dndRaces.config.editItemsForm + '_pricePP').val(data.data.pricePP);
                $(dndRaces.config.editItemsForm + '_type').val(data.data.type);
                $(dndRaces.config.editItemsForm + '_magic').val(data.data.magic);
                $(dndRaces.config.editItemsForm + '_rarity').val(data.data.rarity);
                $(dndRaces.config.editItemsForm + '_ac').val(data.data.ac);
                $(dndRaces.config.editItemsForm + '_strength').val(data.data.strength);
                $(dndRaces.config.editItemsForm + '_stealth').val(data.data.stealth);
                $(dndRaces.config.editItemsForm + '_modifier').val(data.data.modifier);
                $(dndRaces.config.editItemsForm + '_roll').val(data.data.roll);
                $(dndRaces.config.editItemsForm + '_dmg1').val(data.data.dmg1);
                $(dndRaces.config.editItemsForm + '_dmg2').val(data.data.dmg2);
                $(dndRaces.config.editItemsForm + '_dmgType').val(data.data.dmgType);
                $(dndRaces.config.editItemsForm + '_property').val(data.data.property);
                $(dndRaces.config.editItemsForm + '_range').val(data.data.range);
                $(dndRaces.config.editItemsForm + '_wearable').val(data.data.wearable);
                $(dndRaces.config.editItemsForm + '_cursed').val(data.data.cursed);

                dndRaces.ajaxModal(dndRaces.config.editItemsForm, dndRaces.config.ajaxEditItems + data.data.id, 'POST', dndRaces.ajaxDefaultCallback);
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
