var gmAccount = {
    init: function (settings) {
        gmAccount.config = {
            idDatatableUser: '#datatableUser',
            idDatatableInventory: '#datatableInventory',
            idBtnAddUser: '#btnNewUser',
            idBtnEditUser: '.btnEditUser',
            idBtnDeleteUser: '.btnDeleteUser',
            idFormAddUser: '#User_addForm',
            idFormEditUser: '#User_editForm',
            idBtnAddInventory: '#btnNewInventory',
            idBtnEditInventory: '.btnEditInventory',
            idBtnDeleteInventory: '.btnDeleteInventory',
            idFormAddInventory: '#Inventory_addForm',
            idFormEditInventory: '#Inventory_editForm',
            ajaxDatatableUser: '/v2/datatable/user',
            ajaxDatatableInventory: '/v2/datatable/inventory',
            ajaxAddUser: '/v2/user',
            ajaxGetUser: '/v2/user/',
            ajaxEditUser: '/v2/user/',
            ajaxDelUser: '/v2/user/',
            ajaxAddInventory: '/v2/inventory',
            ajaxGetInventory: '/v2/inventory/',
            ajaxEditInventory: '/v2/inventory/',
            ajaxDelInventory: '/v2/inventory/',
            filterKnowledge: false,
            datatableUser: null,
            datatableInventory: null,
            selectedUser: null,
        };
        $.extend(gmAccount.config, settings);

        gmAccount.setup();
    },
    setup: function () {
        gmAccount.setupButtons();
        gmAccount.setupDatatableUser();
        gmAccount.setupDatatableInventory();
    },
    setupButtons: function () {
        $(document)
                .on('click', gmAccount.config.idBtnAddUser, gmAccount.clickAddUser)
                .on('click', gmAccount.config.idBtnEditUser, gmAccount.clickEditUser)
                .on('click', gmAccount.config.idBtnDeleteUser, gmAccount.clickDelUser)
                .on('click', gmAccount.config.idBtnAddInventory, gmAccount.clickAddInventory)
                .on('click', gmAccount.config.idBtnEditInventory, gmAccount.clickEditInventory)
                .on('click', gmAccount.config.idBtnDeleteInventory, gmAccount.clickDelInventory);
    },
    setupDatatableUser: function () {
        gmAccount.config.datatableUser = $(gmAccount.config.idDatatableUser).DataTable({
            "jQueryUI": false,
            "processing": true,
            "serverSide": true,
            "select": true,
            ajax: {
                url: gmAccount.config.ajaxDatatableUser,
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
                {data: "mail"},
                {data: "charname"},
                {
                    "orderable": false,
                    "data": "id",
                    "render": function (data, type, row, meta) {
                        var menu = '';
                        menu += '<div class="ui tableitem dropdown right pointing icon button">';
                        menu += '  <i class="settings icon"></i>';
                        menu += '  <div class="menu">';
                        menu += '    <div class="btnEditUser item" data-id="' + data + '"><i class="large setting icon"></i> Bearbeiten</div>';
                        menu += '    <div class="ui divider"></div>';
                        menu += '    <div class="btnDeleteUser item" data-id="' + data + '"><i class="large trash icon"></i> Löschen</div>';
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

        gmAccount.config.datatableUser.on('select', function (e, dt, type, indexes) {
            if (type === 'row') {
                var data = gmAccount.config.datatableUser.rows(indexes).data();
                gmAccount.config.selectedUser = data[0];
                gmAccount.config.datatableInventory.rows().deselect();
                gmAccount.config.datatableInventory.ajax.reload();
            }
        });
    },
    setupDatatableInventory: function () {
        gmAccount.config.datatableInventory = $(gmAccount.config.idDatatableInventory).DataTable({
            "dom": 'l<"#filter">frtip',
            "jQueryUI": false,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: gmAccount.config.ajaxDatatableInventory,
                dataSrc: 'data',
                type: 'POST',
                data: function (d) {
                    d.knowledge = (gmAccount.config.filterKnowledge=== true) ? 1 : 0,
                    d.characterId = (gmAccount.config.selectedUser !== null) ? gmAccount.config.selectedUser.id : null
                }
            },
            "initComplete": function (settings, json) {
                $('.ui.tableitem.dropdown').dropdown();
                $('#filter')
                        .css('float', 'right')
                        .css('margin-top', '15px')
                        .css('line-height', '10px')
                        .css('padding', '0 15px')
                        .html('No Empty: <input id="filterbox" type="checkbox">');
                $('#filterbox').change(function(){
                    gmAccount.config.filterKnowledge = !gmAccount.config.filterKnowledge;
                    gmAccount.config.datatableInventory.ajax.reload();
                });
            },
            "drawCallback": function (settings) {
                $('.ui.tableitem.dropdown').dropdown();
            },
            columns: [
                {data: "name"},
                {data: "amount"},
                {
                    "orderable": false,
                    "data": "id",
                    "render": function (data, type, row, meta) {
                        var menu = '';
                        menu += '<div class="ui tableitem dropdown right pointing icon button">';
                        menu += '  <i class="settings icon"></i>';
                        menu += '  <div class="menu">';
                        menu += '    <div class="btnEditInventory item" data-id="' + data + '"><i class="large setting icon"></i> Bearbeiten</div>';
                        menu += '    <div class="ui divider"></div>';
                        menu += '    <div class="btnDeleteInventory item" data-id="' + data + '"><i class="large trash icon"></i> Löschen</div>';
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
        gmAccount.config.datatableInventory.on('select', function (e, dt, type, indexes) {
            if (type === 'row') {
                var data = gmAccount.config.datatableInventory.rows(indexes).data();
                //gmAccount.config.selectedEnv = data[0];
                //gmAccount.config.selectedUser = null;
                //gmAccount.config.datatableUser.rows().deselect();
                //gmAccount.updateMenu();
            }
        });
    },
    clickAddUser: function () {
        gmAccount.ajaxModal(
                gmAccount.config.idFormAddUser,
                gmAccount.config.ajaxAddUser,
                'POST',
                function (data) {
                    if (data.success) {
                        gmAccount.config.datatableUser.ajax.reload();
                    } else {
                        alert(data.message);
                    }
                }
        );
    },
    clickDelUser: function () {
        if (confirm("Wirklich löschen?")) {
            gmAccount.ajaxRequest(gmAccount.config.ajaxDelUser + $(this).data('id'), 'DELETE', {}, function (data) {
                if (data.success) {
                    gmAccount.config.datatableUser.ajax.reload();
                } else {
                    alert(data.message);
                }
            });
        }
    },
    clickEditUser: function () {
        gmAccount.ajaxRequest(gmAccount.config.ajaxGetUser + $(this).data('id'), 'GET', {}, function (data) {
            if (data.success) {
                $(gmAccount.config.idFormEditUser).find('.ui.form')[0].reset();
                $(gmAccount.config.idFormEditUser + '_password').val('');
                $(gmAccount.config.idFormEditUser + '_id').val(data.data.id);
                $(gmAccount.config.idFormEditUser + '_mail').val(data.data.mail);
                $(gmAccount.config.idFormEditUser + '_active').val(data.data.active);
                $(gmAccount.config.idFormEditUser + '_gm').val(data.data.gm);
                $(gmAccount.config.idFormEditUser + '_id').val(data.data.id);
                $(gmAccount.config.idFormEditUser + '_environmentId').val(data.data.environmentId);
                $(gmAccount.config.idFormEditUser + '_environmentId').dropdown('set value', data.data.environmentId);
                $(gmAccount.config.idFormEditUser + '_charname').val(data.data.charname);
                $(gmAccount.config.idFormEditUser + '_race').val(data.data.race);
                $(gmAccount.config.idFormEditUser + '_class').val(data.data.class);
                $(gmAccount.config.idFormEditUser + '_background').val(data.data.background);
                $(gmAccount.config.idFormEditUser + '_alignment').val(data.data.alignment);
                $(gmAccount.config.idFormEditUser + '_level').val(data.data.level);
                $(gmAccount.config.idFormEditUser + '_exp').val(data.data.exp);
                $(gmAccount.config.idFormEditUser + '_inspiration').val(data.data.inspiration);
                $(gmAccount.config.idFormEditUser + '_proficiency').val(data.data.proficiency);
                $(gmAccount.config.idFormEditUser + '_initiative').val(data.data.initiative);

                $(gmAccount.config.idFormEditUser + '_equipmentQuiver1').val(data.data.equipmentQuiver1);
                $(gmAccount.config.idFormEditUser + '_equipmentQuiver2').val(data.data.equipmentQuiver2);
                $(gmAccount.config.idFormEditUser + '_equipmentQuiver3').val(data.data.equipmentQuiver3);
                $(gmAccount.config.idFormEditUser + '_equipmentHelmet').val(data.data.equipmentHelmet);
                $(gmAccount.config.idFormEditUser + '_equipmentCape').val(data.data.equipmentCape);
                $(gmAccount.config.idFormEditUser + '_equipmentNecklace').val(data.data.equipmentNecklace);
                $(gmAccount.config.idFormEditUser + '_equipmentWeapon1').val(data.data.equipmentWeapon1);
                $(gmAccount.config.idFormEditUser + '_equipmentWeapon2').val(data.data.equipmentWeapon2);
                $(gmAccount.config.idFormEditUser + '_equipmentWeapon3').val(data.data.equipmentWeapon3);
                $(gmAccount.config.idFormEditUser + '_equipmentOffWeapon').val(data.data.equipmentOffWeapon);
                $(gmAccount.config.idFormEditUser + '_equipmentGloves').val(data.data.equipmentGloves);
                $(gmAccount.config.idFormEditUser + '_equipmentArmor').val(data.data.equipmentArmor);
                $(gmAccount.config.idFormEditUser + '_equipmentObject').val(data.data.equipmentObject);
                $(gmAccount.config.idFormEditUser + '_equipmentBelt').val(data.data.equipmentBelt);
                $(gmAccount.config.idFormEditUser + '_equipmentBoots').val(data.data.equipmentBoots);
                $(gmAccount.config.idFormEditUser + '_equipmentRing1').val(data.data.equipmentRing1);
                $(gmAccount.config.idFormEditUser + '_equipmentRing2').val(data.data.equipmentRing2);



                //$(gmAccount.config.idFormEditUser + '_money').val(data.data.money);
                //$(gmAccount.config.idFormEditUser + '_savingThrows').val(data.data.savingThrows);
                //$(gmAccount.config.idFormEditUser + '_skills').val(data.data.skills);
                var mm = data.data.hp.split(";");
                $(gmAccount.config.idFormEditUser + '_hpMax').val(mm[0]);
                $(gmAccount.config.idFormEditUser + '_hpCurrent').val(mm[1]);
                $(gmAccount.config.idFormEditUser + '_hpTemporary').val(mm[2]);
                var mm = data.data.money.split(";");
                $(gmAccount.config.idFormEditUser + '_cp').val(mm[0]);
                $(gmAccount.config.idFormEditUser + '_sp').val(mm[1]);
                $(gmAccount.config.idFormEditUser + '_ep').val(mm[2]);
                $(gmAccount.config.idFormEditUser + '_gp').val(mm[3]);
                $(gmAccount.config.idFormEditUser + '_pp').val(mm[4]);
                var st = data.data.savingThrows.split(";");
                $(gmAccount.config.idFormEditUser + '_str').val(st[0]);
                $(gmAccount.config.idFormEditUser + '_dex').val(st[1]);
                $(gmAccount.config.idFormEditUser + '_con').val(st[2]);
                $(gmAccount.config.idFormEditUser + '_int').val(st[3]);
                $(gmAccount.config.idFormEditUser + '_wis').val(st[4]);
                $(gmAccount.config.idFormEditUser + '_cha').val(st[5]);
                var sk = data.data.skills.split(";");
                $(gmAccount.config.idFormEditUser + '_acrobatics').val(sk[0]);
                $(gmAccount.config.idFormEditUser + '_animalHandling').val(sk[1]);
                $(gmAccount.config.idFormEditUser + '_arcana').val(sk[2]);
                $(gmAccount.config.idFormEditUser + '_athletics').val(sk[3]);
                $(gmAccount.config.idFormEditUser + '_deception').val(sk[4]);
                $(gmAccount.config.idFormEditUser + '_history').val(sk[5]);
                $(gmAccount.config.idFormEditUser + '_insight').val(sk[6]);
                $(gmAccount.config.idFormEditUser + '_intimidation').val(sk[7]);
                $(gmAccount.config.idFormEditUser + '_investigation').val(sk[8]);
                $(gmAccount.config.idFormEditUser + '_medicine').val(sk[9]);
                $(gmAccount.config.idFormEditUser + '_nature').val(sk[10]);
                $(gmAccount.config.idFormEditUser + '_perception').val(sk[11]);
                $(gmAccount.config.idFormEditUser + '_performance').val(sk[12]);
                $(gmAccount.config.idFormEditUser + '_persuasion').val(sk[13]);
                $(gmAccount.config.idFormEditUser + '_religion').val(sk[14]);
                $(gmAccount.config.idFormEditUser + '_sleightOfHand').val(sk[15]);
                $(gmAccount.config.idFormEditUser + '_stealth').val(sk[16]);
                $(gmAccount.config.idFormEditUser + '_survival').val(sk[17]);
                $(gmAccount.config.idFormEditUser + '_bonusModifier').val(data.data.bonusModifier);


                gmAccount.ajaxModal(gmAccount.config.idFormEditUser, gmAccount.config.ajaxEditUser + data.data.id, 'POST', function (data) {
                    if (data.success) {
                        gmAccount.config.datatableUser.ajax.reload();
                    } else {
                        alert(data.message);
                    }
                });
            } else {
                alert(data.message);
            }
        });
    },
    clickAddInventory: function () {
        $(gmAccount.config.idFormAddInventory + '_characterId').val(gmAccount.config.selectedUser.id);
        gmAccount.ajaxModal(
                gmAccount.config.idFormAddInventory,
                gmAccount.config.ajaxAddInventory,
                'POST',
                function (data) {
                    if (data.success) {
                        gmAccount.config.datatableInventory.ajax.reload();
                    } else {
                        alert(data.message);
                    }
                }
        );
    },
    clickDelInventory: function () {
        if (confirm("Wirklich löschen?")) {
            gmAccount.ajaxRequest(gmAccount.config.ajaxDelInventory + $(this).data('id'), 'DELETE', {}, function (data) {
                if (data.success) {
                    gmAccount.config.datatableInventory.ajax.reload();
                } else {
                    alert(data.message);
                }
            });
        }
    },
    clickEditInventory: function () {
        gmAccount.ajaxRequest(gmAccount.config.ajaxGetInventory + $(this).data('id'), 'GET', {}, function (data) {
            if (data.success) {
                $(gmAccount.config.idFormEditInventory + '_id').val(data.data.id);
                $(gmAccount.config.idFormEditInventory + '_characterId').val(data.data.characterId);
                $(gmAccount.config.idFormEditInventory + '_itemId').val(data.data.itemId);
                $(gmAccount.config.idFormEditInventory + '_itemId').parent().dropdown('set selected', data.data.itemId);
                $(gmAccount.config.idFormEditInventory + '_amount').val(data.data.amount);
                $(gmAccount.config.idFormEditInventory + '_knowledge').val(data.data.knowledge);

                gmAccount.ajaxModal(gmAccount.config.idFormEditInventory, gmAccount.config.ajaxEditInventory + data.data.id, 'POST', function (data) {
                    if (data.success) {
                        gmAccount.config.datatableInventory.ajax.reload();
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
                gmAccount.ajaxRequest(ajaxUrl, ajaxType, $(formId + ' form').serialize(), callback);
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

$(document).ready(gmAccount.init);