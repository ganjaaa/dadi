var dndItems = {
    init: function (settings) {
        dndItems.config = {
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

        $.extend(dndItems.config, settings);

        dndItems.setup();
    },
    setup: function () {
        dndItems.setupDatatable();
        dndItems.setupButtons();
    },
    setupButtons: function () {
        $(document)
                .on('click', dndItems.config.addBtnItemsId, dndItems.clickAddItems)
                .on('click', dndItems.config.editBtnItemsId, dndItems.clickEditItems)
                .on('click', dndItems.config.delBtnItemsId, dndItems.clickDelItems);
    },
    setupDatatable: function () {
        dndItems.config.intDataTable = $(dndItems.config.dataTableId).DataTable({
            "jQueryUI": false,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: dndItems.config.ajaxDatatable,
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
                "search": dndItems.config.initSearch
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
        dndItems.ajaxModal(
                dndItems.config.addItemsForm,
                dndItems.config.ajaxAddItems,
                'POST',
                dndItems.ajaxDefaultCallback
                );
    },
    clickDelItems: function () {
        if (confirm("Wirklich löschen?")) {
            dndItems.ajaxRequest(dndItems.config.ajaxDelItems + $(this).data('id'), 'DELETE', {}, dndItems.ajaxDefaultCallback);
        }
    },
    clickEditItems: function () {
        dndItems.ajaxRequest(dndItems.config.ajaxGetItems + $(this).data('id'), 'GET', {}, function (data) {
            if (data.success) {
                $(dndItems.config.editItemsForm + '_name').val(data.data.name);
                $(dndItems.config.editItemsForm + '_description').val(data.data.description);
                $(dndItems.config.editItemsForm + '_weight').val(data.data.weight);
                $(dndItems.config.editItemsForm + '_priceCP').val(data.data.priceCP);
                $(dndItems.config.editItemsForm + '_priceSP').val(data.data.priceSP);
                $(dndItems.config.editItemsForm + '_priceEP').val(data.data.priceEP);
                $(dndItems.config.editItemsForm + '_priceGP').val(data.data.priceGP);
                $(dndItems.config.editItemsForm + '_pricePP').val(data.data.pricePP);
                $(dndItems.config.editItemsForm + '_type').val(data.data.type);
                $(dndItems.config.editItemsForm + '_magic').val(data.data.magic);
                $(dndItems.config.editItemsForm + '_rarity').val(data.data.rarity);
                $(dndItems.config.editItemsForm + '_ac').val(data.data.ac);
                $(dndItems.config.editItemsForm + '_strength').val(data.data.strength);
                $(dndItems.config.editItemsForm + '_stealth').val(data.data.stealth);
                $(dndItems.config.editItemsForm + '_modifier').val(data.data.modifier);
                $(dndItems.config.editItemsForm + '_roll').val(data.data.roll);
                $(dndItems.config.editItemsForm + '_dmg1').val(data.data.dmg1);
                $(dndItems.config.editItemsForm + '_dmg2').val(data.data.dmg2);
                $(dndItems.config.editItemsForm + '_dmgType').val(data.data.dmgType);
                $(dndItems.config.editItemsForm + '_property').val(data.data.property);
                $(dndItems.config.editItemsForm + '_range').val(data.data.range);
                $(dndItems.config.editItemsForm + '_wearable').val(data.data.wearable);
                $(dndItems.config.editItemsForm + '_cursed').val(data.data.cursed);
                $(dndItems.config.editItemsForm + '_stackable').val(data.data.stackable);

                dndItems.ajaxModal(dndItems.config.editItemsForm, dndItems.config.ajaxEditItems + data.data.id, 'POST', dndItems.ajaxDefaultCallback);
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
                dndItems.ajaxRequest(ajaxUrl, ajaxType, $(formId + ' form').serialize(), myCallback);
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
            dndItems.config.intDataTable.ajax.reload();
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
        if (dndItems.config.debug) {
            console.log(message);
        }
    }
};
