var gmRelations = {
    init: function (settings) {
        gmRelations.config = {
            idTreeRelations: '#treeRelations',
            idBtnSaveRelations: '#btnSaveRelations',
            idFieldRelationSearch: '#treeRelationsSearch',
            treeRelationSearch: false,
            treeRelations: null,
            treeDataRelations: [
                {
                    "id": 2,
                    "text": "Classes",
                    "type": "folder_classes",
                    "children": []
                }, {
                    "id": 3,
                    "text": "Races",
                    "type": "folder_races",
                    "children": []
                }, {
                    "id": 4,
                    "text": "Backgrounds",
                    "type": "folder_backgrounds",
                    "children": []
                }
            ],
            idDatatableAccount: '#datatableAccount',
            idDatatableInventory: '#datatableInventory',
            idBtnAddAccount: '#btnNewAccount',
            idBtnEditAccount: '.btnEditAccount',
            idBtnDeleteAccount: '.btnDeleteAccount',
            idFormAddAccount: '#Account_addForm',
            idFormEditAccount: '#Account_editForm',
            ajaxDatatableAccount: '/v2/datatable/account',
            ajaxAccount: '/v2/account',
            filterKnowledge: false,
            datatableAccount: null,
            datatableInventory: null,
            selectedAccount: null,
        };
        $.extend(gmRelations.config, settings);

        gmRelations.setup();
    },
    setup: function () {
        gmRelations.setupTree();
        gmRelations.setupButtons();
        gmRelations.setupDatatableAccount();
    },
    setupButtons: function () {
        $(document)
                .on('keyup', gmRelations.config.idFieldRelationSearch, function () {
                    if (gmRelations.config.treeRelationSearch) {
                        clearTimeout(gmRelations.config.treeRelationSearch);
                    }
                    gmRelations.config.treeRelationSearch = setTimeout(function () {
                        var v = $(gmRelations.config.idFieldRelationSearch).val();
                        $(gmRelations.config.idTreeRelations).jstree(true).search(v);
                    }, 250);
                });
    },
    setupTree: function () {
        gmRelations.config.treeRelations = $(gmRelations.config.idTreeRelations).jstree({
            "core": {
                "animation": 0,
                "check_callback": true,
                'themes': {
                    responsive: true,
                    stripes: true,
                    icons: true,
                    dots: true
                },
                'data': gmRelations.config.treeDataRelations
            },
            "types": {
                "#": {
                    "valid_children": ["folder_classes", "folder_races", "folder_backgrounds"]
                },
                "folder_classes": {
                    "icon": "ui shield alternate icon",
                    "valid_children": ["class"]
                },
                "class": {
                    "icon": "ui shield alternate icon",
                    "valid_children": ["level"]
                },
                "folder_races": {
                    "icon": "ui bug icon",
                    "valid_children": ["race"]
                },
                "race": {
                    "icon": "ui bug icon",
                    "valid_children": ["level"]
                },
                "folder_backgrounds": {
                    "icon": "ui user secret icon",
                    "valid_children": ["background"]
                },
                "background": {
                    "icon": "ui user secret icon",
                    "valid_children": ["trait", "feature"]
                },
                "level": {
                    "icon": "ui level up alternate icon",
                    "valid_children": ["trait", "feature"]
                },
                "trait": {
                    "icon": "ui tag icon",
                    "valid_children": []
                },
                "feature": {
                    "icon": "ui tags icon",
                    "valid_children": []
                },
                "slots": {
                    "icon": "ui chess board icon",
                    "valid_children": []
                }
            },
            "contextmenu": {
                items: function (node) {
                    var items = {
                        'feature': {
                            'label': 'Feature delegieren',
                            'icon': 'ui plus icon',
                            'action': function () {
                                /*$(customerSettings.config.idFormCustomerHotspot).modal({
                                 closable: false,
                                 centered: false,
                                 onApprove: function () {
                                 var newNode = {
                                 "id": Date.now(),
                                 "type": "hotspot",
                                 "data": {
                                 "uid": $(customerSettings.config.idFormCustomerHotspot + '_nasId').val(),
                                 },
                                 "text": $(customerSettings.config.idFormCustomerHotspot + '_nasId option:selected').text()
                                 };
                                 if (newNode.text !== false && newNode.text !== "") {
                                 customerSettings.config.treeRules.jstree("create_node", node.id, newNode, 'last');
                                 }
                                 }
                                 }).modal('show');*/
                            }
                        },
                        'trait': {
                            'label': 'Trait delegieren',
                            'icon': 'ui plus icon',
                            'action': function () {
                            }
                        },
                        'slot': {
                            'label': 'Slot delegieren',
                            'icon': 'ui plus icon',
                            'action': function () {
                            }
                        },
                        'remove': {
                            'label': 'Entfernen',
                            'icon': 'ui trash icon',
                            'action': function () {
                                gmRelations.config.treeRelations.jstree("delete_node", node);
                            }
                        }
                    };

                    if (node.type === 'folder_classes') {
                        return {};
                    } else if (node.type === 'class') {
                        return {};
                    } else if (node.type === 'folder_races') {
                        return {};
                    } else if (node.type === 'race') {
                        return {};
                    } else if (node.type === 'folder_backgrounds') {
                        return {};
                    } else if (node.type === 'background') {
                        delete items.remove;
                    } else if (node.type === 'level') {
                        delete items.remove;
                    } else if (node.type === 'trait') {
                        delete items.feature;
                        delete items.trait;
                        delete items.slot;
                    } else if (node.type === 'feature') {
                        delete items.feature;
                        delete items.trait;
                        delete items.slot;
                    } else if (node.type === 'slots') {
                        delete items.feature;
                        delete items.trait;
                        delete items.slot;
                    }

                    return items;
                }
            },
            "plugins": ['state', 'dnd', 'sort', 'types', 'contextmenu', 'search']
        });
    },
    setupDatatableAccount: function () {
        gmRelations.config.datatableAccount = $(gmRelations.config.idDatatableAccount).DataTable({
            "jQueryUI": false,
            "processing": true,
            "serverSide": true,
            "select": true,
            ajax: {
                url: gmRelations.config.ajaxDatatableAccount,
                dataSrc: 'data',
                type: 'POST'
            },
            "initComplete": function (settings, json) {
                $('.ui.tableitem.dropdown').dropdown();
            },
            "drawCallback": function (settings) {
                $('.ui.tableitem.dropdown').dropdown();
            },
            columns: [
                {
                    "orderable": false,
                    data: "active",
                    render: function (data, type, row, meta) {
                        var txt = '';
                        txt += '<div class="ui toggle ' + (data == 1 ? 'checked' : '') + ' disabled checkbox">';
                        txt += '  <input name="public" type="checkbox" ' + (data == 1 ? 'checked="checked"' : '') + ' disabled=""> ';
                        txt += '  <label></label>';
                        txt += '</div>';
                        return txt;
                    }
                },
                {data: "mail"},
                {data: "lastIp"},
                {data: "lastLogin"},
                {
                    "orderable": false,
                    "data": "id",
                    "render": function (data, type, row, meta) {
                        var menu = '';
                        menu += '<div class="ui tableitem dropdown right pointing icon button">';
                        menu += '  <i class="settings icon"></i>';
                        menu += '  <div class="menu">';
                        menu += '    <div class="btnEditAccount item" data-id="' + data + '"><i class="large setting icon"></i> Bearbeiten</div>';
                        menu += '    <div class="ui divider"></div>';
                        menu += '    <div class="btnDeleteAccount item" data-id="' + data + '"><i class="large trash icon"></i> Löschen</div>';
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

        gmRelations.config.datatableAccount.on('select', function (e, dt, type, indexes) {
            if (type === 'row') {
                var data = gmRelations.config.datatableAccount.rows(indexes).data();
                gmRelations.config.selectedAccount = data[0];
                gmRelations.config.datatableInventory.rows().deselect();
                gmRelations.config.datatableInventory.ajax.reload();
            }
        });
    },
    clickAddAccount: function () {
        gmRelations.ajaxModal(
                gmRelations.config.idFormAddAccount,
                gmRelations.config.ajaxAccount,
                'POST',
                function (data) {
                    if (data.success) {
                        gmRelations.config.datatableAccount.ajax.reload();
                    } else {
                        alert(data.message);
                    }
                }
        );
    },
    clickDelAccount: function () {
        if (confirm("Wirklich löschen?")) {
            gmRelations.ajaxRequest(gmRelations.config.ajaxAccount + '/' + $(this).data('id'), 'DELETE', {}, function (data) {
                if (data.success) {
                    gmRelations.config.datatableAccount.ajax.reload();
                } else {
                    alert(data.message);
                }
            });
        }
    },
    clickEditAccount: function () {
        gmRelations.ajaxRequest(gmRelations.config.ajaxAccount + '/' + $(this).data('id'), 'GET', {}, function (data) {
            if (data.success) {
                $(gmRelations.config.idFormEditAccount).find('.ui.form')[0].reset();
                $(gmRelations.config.idFormEditAccount + '_password').val('');
                $(gmRelations.config.idFormEditAccount + '_id').val(data.data.id);
                $(gmRelations.config.idFormEditAccount + '_mail').val(data.data.mail);
                $(gmRelations.config.idFormEditAccount + '_active').val(data.data.active);
                $(gmRelations.config.idFormEditAccount + '_gm').val(data.data.gm);

                gmRelations.ajaxModal(gmRelations.config.idFormEditAccount, gmRelations.config.ajaxAccount + '/' + data.data.id, 'POST', function (data) {
                    if (data.success) {
                        gmRelations.config.datatableAccount.ajax.reload();
                    } else {
                        alert(data.message);
                    }
                });
            } else {
                alert(data.message);
            }
        });
    },
    ajaxModal: function (formId, ajaxUrl, ajaxType, callback) {
        $(formId).modal({
            onApprove: function () {
                gmRelations.ajaxRequest(ajaxUrl, ajaxType, $(formId + ' form').serialize(), callback);
            }
        }).modal('show');
    },
    ajaxRequest: function (ajaxUrl, ajaxType, ajaxData, callback) {
        $.ajax({
            url: ajaxUrl,
            dataType: 'json',
            type: ajaxType,
            data: ajaxData,
            success: callback
        });
    },
    ajaxDefaultCallback: function (data) {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    },
    returnListItem: function (id, content) {
        return '<div class="item" data-id="' + id + '">' + content + '<i class="right floated edit icon"></i></div>';
    }
};