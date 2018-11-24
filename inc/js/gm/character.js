var gmAccount = {
    init: function (settings) {
        gmAccount.config = {
            idDatatableCharacter: '#datatableCharacter',
            idDatatableInventory: '#datatableInventory',
            idBtnAddCharacter: '#btnNewCharacter',
            idBtnEditCharacter: '.btnEditCharacter',
            idBtnDeleteCharacter: '.btnDeleteCharacter',
            idFormAddCharacter: '#Character_addForm',
            idFormEditCharacter: '#Character_editForm',
            idBtnAddInventory: '#btnNewInventory',
            idBtnEditInventory: '.btnEditInventory',
            idBtnDeleteInventory: '.btnDeleteInventory',
            idFormAddInventory: '#Inventory_addForm',
            idFormEditInventory: '#Inventory_editForm',
            ajaxDatatableCharacter: '/v2/datatable/character',
            ajaxDatatableInventory: '/v2/datatable/inventory',
            ajaxAddCharacter: '/v2/character',
            ajaxGetCharacter: '/v2/character/',
            ajaxEditCharacter: '/v2/character/',
            ajaxDelCharacter: '/v2/character/',
            ajaxAddInventory: '/v2/inventory',
            ajaxGetInventory: '/v2/inventory/',
            ajaxEditInventory: '/v2/inventory/',
            ajaxDelInventory: '/v2/inventory/',
            filterKnowledge: false,
            datatableCharacter: null,
            datatableInventory: null,
            selectedCharacter: null,
        };
        $.extend(gmAccount.config, settings);

        gmAccount.setup();
    },
    setup: function () {
        gmAccount.setupButtons();
        gmAccount.setupDatatableCharacter();
        gmAccount.setupDatatableInventory();
    },
    setupButtons: function () {
        $(document)
                .on('click', gmAccount.config.idBtnAddCharacter, gmAccount.clickAddCharacter)
                .on('click', gmAccount.config.idBtnEditCharacter, gmAccount.clickEditCharacter)
                .on('click', gmAccount.config.idBtnDeleteCharacter, gmAccount.clickDelCharacter)
                .on('click', gmAccount.config.idBtnAddInventory, gmAccount.clickAddInventory)
                .on('click', gmAccount.config.idBtnEditInventory, gmAccount.clickEditInventory)
                .on('click', gmAccount.config.idBtnDeleteInventory, gmAccount.clickDelInventory);
    },
    setupDatatableCharacter: function () {
        gmAccount.config.datatableCharacter = $(gmAccount.config.idDatatableCharacter).DataTable({
            "jQueryUI": false,
            "processing": true,
            "serverSide": true,
            "select": true,
            ajax: {
                url: gmAccount.config.ajaxDatatableCharacter,
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
                {data: "charname"},
                {data: "raceId"},
                {data: "class1ID"},
                {
                    "orderable": false,
                    "data": "id",
                    "render": function (data, type, row, meta) {
                        var menu = '';
                        menu += '<div class="ui tableitem dropdown right pointing icon button">';
                        menu += '  <i class="settings icon"></i>';
                        menu += '  <div class="menu">';
                        menu += '    <div class="btnEditCharacter item" data-id="' + data + '"><i class="large setting icon"></i> Bearbeiten</div>';
                        menu += '    <div class="ui divider"></div>';
                        menu += '    <div class="btnDeleteCharacter item" data-id="' + data + '"><i class="large trash icon"></i> Löschen</div>';
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

        gmAccount.config.datatableCharacter.on('select', function (e, dt, type, indexes) {
            if (type === 'row') {
                var data = gmAccount.config.datatableCharacter.rows(indexes).data();
                gmAccount.config.selectedCharacter = data[0];
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
                    d.knowledge = (gmAccount.config.filterKnowledge === true) ? 1 : 0,
                            d.characterId = (gmAccount.config.selectedCharacter !== null) ? gmAccount.config.selectedCharacter.id : null
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
                $('#filterbox').change(function () {
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
                //gmAccount.config.selectedCharacter = null;
                //gmAccount.config.datatableCharacter.rows().deselect();
                //gmAccount.updateMenu();
            }
        });
    },
    clickAddCharacter: function () {
        gmAccount.ajaxModal(
                gmAccount.config.idFormAddCharacter,
                gmAccount.config.ajaxAddCharacter,
                'POST',
                function (data) {
                    if (data.success) {
                        gmAccount.config.datatableCharacter.ajax.reload();
                    } else {
                        alert(data.message);
                    }
                }
        );
    },
    clickDelCharacter: function () {
        if (confirm("Wirklich löschen?")) {
            gmAccount.ajaxRequest(gmAccount.config.ajaxDelCharacter + $(this).data('id'), 'DELETE', {}, function (data) {
                if (data.success) {
                    gmAccount.config.datatableCharacter.ajax.reload();
                } else {
                    alert(data.message);
                }
            });
        }
    },
    clickEditCharacter: function () {
        gmAccount.ajaxRequest(gmAccount.config.ajaxGetCharacter + $(this).data('id'), 'GET', {}, function (data) {
            if (data.success) {
                $(gmAccount.config.idFormEditCharacter).find('.ui.form')[0].reset();
                $(gmAccount.config.idFormEditCharacter + '_password').val('');
                $(gmAccount.config.idFormEditCharacter + '_id').val(data.data.id);
                $(gmAccount.config.idFormEditCharacter + '_mail').val(data.data.mail);
                $(gmAccount.config.idFormEditCharacter + '_active').val(data.data.active);
                $(gmAccount.config.idFormEditCharacter + '_gm').val(data.data.gm);
                $(gmAccount.config.idFormEditCharacter + '_id').val(data.data.id);
                $(gmAccount.config.idFormEditCharacter + '_environmentId').val(data.data.environmentId);
                $(gmAccount.config.idFormEditCharacter + '_environmentId').dropdown('set value', data.data.environmentId);
                $(gmAccount.config.idFormEditCharacter + '_charname').val(data.data.charname);
                $(gmAccount.config.idFormEditCharacter + '_race').val(data.data.race);
                $(gmAccount.config.idFormEditCharacter + '_class').val(data.data.class);
                $(gmAccount.config.idFormEditCharacter + '_background').val(data.data.background);
                $(gmAccount.config.idFormEditCharacter + '_alignment').val(data.data.alignment);
                $(gmAccount.config.idFormEditCharacter + '_level').val(data.data.level);
                $(gmAccount.config.idFormEditCharacter + '_exp').val(data.data.exp);
                $(gmAccount.config.idFormEditCharacter + '_inspiration').val(data.data.inspiration);
                $(gmAccount.config.idFormEditCharacter + '_proficiency').val(data.data.proficiency);
                $(gmAccount.config.idFormEditCharacter + '_initiative').val(data.data.initiative);

                $(gmAccount.config.idFormEditCharacter + '_equipmentQuiver1').val(data.data.equipmentQuiver1);
                $(gmAccount.config.idFormEditCharacter + '_equipmentQuiver2').val(data.data.equipmentQuiver2);
                $(gmAccount.config.idFormEditCharacter + '_equipmentQuiver3').val(data.data.equipmentQuiver3);
                $(gmAccount.config.idFormEditCharacter + '_equipmentHelmet').val(data.data.equipmentHelmet);
                $(gmAccount.config.idFormEditCharacter + '_equipmentCape').val(data.data.equipmentCape);
                $(gmAccount.config.idFormEditCharacter + '_equipmentNecklace').val(data.data.equipmentNecklace);
                $(gmAccount.config.idFormEditCharacter + '_equipmentWeapon1').val(data.data.equipmentWeapon1);
                $(gmAccount.config.idFormEditCharacter + '_equipmentWeapon2').val(data.data.equipmentWeapon2);
                $(gmAccount.config.idFormEditCharacter + '_equipmentWeapon3').val(data.data.equipmentWeapon3);
                $(gmAccount.config.idFormEditCharacter + '_equipmentOffWeapon').val(data.data.equipmentOffWeapon);
                $(gmAccount.config.idFormEditCharacter + '_equipmentGloves').val(data.data.equipmentGloves);
                $(gmAccount.config.idFormEditCharacter + '_equipmentArmor').val(data.data.equipmentArmor);
                $(gmAccount.config.idFormEditCharacter + '_equipmentObject').val(data.data.equipmentObject);
                $(gmAccount.config.idFormEditCharacter + '_equipmentBelt').val(data.data.equipmentBelt);
                $(gmAccount.config.idFormEditCharacter + '_equipmentBoots').val(data.data.equipmentBoots);
                $(gmAccount.config.idFormEditCharacter + '_equipmentRing1').val(data.data.equipmentRing1);
                $(gmAccount.config.idFormEditCharacter + '_equipmentRing2').val(data.data.equipmentRing2);



                //$(gmAccount.config.idFormEditCharacter + '_money').val(data.data.money);
                //$(gmAccount.config.idFormEditCharacter + '_savingThrows').val(data.data.savingThrows);
                //$(gmAccount.config.idFormEditCharacter + '_skills').val(data.data.skills);
                var mm = data.data.hp.split(";");
                $(gmAccount.config.idFormEditCharacter + '_hpMax').val(mm[0]);
                $(gmAccount.config.idFormEditCharacter + '_hpCurrent').val(mm[1]);
                $(gmAccount.config.idFormEditCharacter + '_hpTemporary').val(mm[2]);
                var mm = data.data.money.split(";");
                $(gmAccount.config.idFormEditCharacter + '_cp').val(mm[0]);
                $(gmAccount.config.idFormEditCharacter + '_sp').val(mm[1]);
                $(gmAccount.config.idFormEditCharacter + '_ep').val(mm[2]);
                $(gmAccount.config.idFormEditCharacter + '_gp').val(mm[3]);
                $(gmAccount.config.idFormEditCharacter + '_pp').val(mm[4]);
                var st = data.data.savingThrows.split(";");
                $(gmAccount.config.idFormEditCharacter + '_str').val(st[0]);
                $(gmAccount.config.idFormEditCharacter + '_dex').val(st[1]);
                $(gmAccount.config.idFormEditCharacter + '_con').val(st[2]);
                $(gmAccount.config.idFormEditCharacter + '_int').val(st[3]);
                $(gmAccount.config.idFormEditCharacter + '_wis').val(st[4]);
                $(gmAccount.config.idFormEditCharacter + '_cha').val(st[5]);
                var sk = data.data.skills.split(";");
                $(gmAccount.config.idFormEditCharacter + '_acrobatics').val(sk[0]);
                $(gmAccount.config.idFormEditCharacter + '_animalHandling').val(sk[1]);
                $(gmAccount.config.idFormEditCharacter + '_arcana').val(sk[2]);
                $(gmAccount.config.idFormEditCharacter + '_athletics').val(sk[3]);
                $(gmAccount.config.idFormEditCharacter + '_deception').val(sk[4]);
                $(gmAccount.config.idFormEditCharacter + '_history').val(sk[5]);
                $(gmAccount.config.idFormEditCharacter + '_insight').val(sk[6]);
                $(gmAccount.config.idFormEditCharacter + '_intimidation').val(sk[7]);
                $(gmAccount.config.idFormEditCharacter + '_investigation').val(sk[8]);
                $(gmAccount.config.idFormEditCharacter + '_medicine').val(sk[9]);
                $(gmAccount.config.idFormEditCharacter + '_nature').val(sk[10]);
                $(gmAccount.config.idFormEditCharacter + '_perception').val(sk[11]);
                $(gmAccount.config.idFormEditCharacter + '_performance').val(sk[12]);
                $(gmAccount.config.idFormEditCharacter + '_persuasion').val(sk[13]);
                $(gmAccount.config.idFormEditCharacter + '_religion').val(sk[14]);
                $(gmAccount.config.idFormEditCharacter + '_sleightOfHand').val(sk[15]);
                $(gmAccount.config.idFormEditCharacter + '_stealth').val(sk[16]);
                $(gmAccount.config.idFormEditCharacter + '_survival').val(sk[17]);
                $(gmAccount.config.idFormEditCharacter + '_bonusModifier').val(data.data.bonusModifier);


                gmAccount.ajaxModal(gmAccount.config.idFormEditCharacter, gmAccount.config.ajaxEditCharacter + data.data.id, 'POST', function (data) {
                    if (data.success) {
                        gmAccount.config.datatableCharacter.ajax.reload();
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
        $(gmAccount.config.idFormAddInventory + '_characterId').val(gmAccount.config.selectedCharacter.id);
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