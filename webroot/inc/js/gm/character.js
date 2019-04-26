var gmCharacter = {
    init: function (settings) {
        gmCharacter.config = {
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
        $.extend(gmCharacter.config, settings);
        gmCharacter.setup();
    },
    setup: function () {
        gmCharacter.setupButtons();
        gmCharacter.setupDatatableCharacter();
        gmCharacter.setupDatatableInventory();
    },
    setupButtons: function () {
        $(document)
                .on('click', gmCharacter.config.idBtnAddCharacter, gmCharacter.clickAddCharacter)
                .on('click', gmCharacter.config.idBtnEditCharacter, gmCharacter.clickEditCharacter)
                .on('click', gmCharacter.config.idBtnDeleteCharacter, gmCharacter.clickDelCharacter)
                .on('click', gmCharacter.config.idBtnAddInventory, gmCharacter.clickAddInventory)
                .on('click', gmCharacter.config.idBtnEditInventory, gmCharacter.clickEditInventory)
                .on('click', gmCharacter.config.idBtnDeleteInventory, gmCharacter.clickDelInventory);
    },
    setupDatatableCharacter: function () {
        gmCharacter.config.datatableCharacter = $(gmCharacter.config.idDatatableCharacter).DataTable({
            "jQueryUI": false,
            "processing": true,
            "serverSide": true,
            "select": true,
            ajax: {
                url: gmCharacter.config.ajaxDatatableCharacter,
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
                {data: "rname"},
                {
                    data: "class1Id",
                    "render": function (data, type, row, meta) {
                        var x = '';
                        x += row.c1name + ' (' + row.class1Level + ')';
                        if (row.class2Level > 0) {
                            x += '<br>' + row.c2name + ' (' + row.class2Level + ')';
                        }
                        if (row.class3Level > 0) {
                            x += '<br>' + row.c3name + ' (' + row.class3Level + ')';
                        }
                        if (row.class4Level > 0) {
                            x += '<br>' + row.c4name + ' (' + row.class4Level + ')';
                        }
                        return x;
                    }
                },
                {
                    "orderable": false,
                    "data": "id",
                    "render": function (data, type, row, meta) {
                        var menu = '';
                        menu += '<div class="btnEditCharacter item" data-id="' + data + '"><i class="large setting icon"></i> Bearbeiten</div>';
                        menu += '<div class="btnDeleteCharacter item" data-id="' + data + '"><i class="large trash icon"></i> Löschen</div>';

                        //menu += '<div class="ui tableitem dropdown right pointing icon button">';
                        //menu += '  <i class="settings icon"></i>';
                        //menu += '  <div class="menu">';
                        //menu += '    <div class="btnEditCharacter item" data-id="' + data + '"><i class="large setting icon"></i> Bearbeiten</div>';
                        //menu += '    <div class="ui divider"></div>';
                        //menu += '    <div class="btnDeleteCharacter item" data-id="' + data + '"><i class="large trash icon"></i> Löschen</div>';
                        //menu += '  </div>';
                        //menu += '</div>';
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
        gmCharacter.config.datatableCharacter.on('select', function (e, dt, type, indexes) {
            if (type === 'row') {
                var data = gmCharacter.config.datatableCharacter.rows(indexes).data();
                gmCharacter.config.selectedCharacter = data[0];
                gmCharacter.config.datatableInventory.rows().deselect();
                gmCharacter.config.datatableInventory.ajax.reload();
            }
        }).on('deselect', function (e, dt, type, indexes) {
            if (type === 'row') {
                gmCharacter.config.selectedCharacter = null;
                gmCharacter.config.datatableInventory.rows().deselect();
                gmCharacter.config.datatableInventory.ajax.reload();
            }
        });
    },
    setupDatatableInventory: function () {
        gmCharacter.config.datatableInventory = $(gmCharacter.config.idDatatableInventory).DataTable({
            "jQueryUI": false,
            "processing": true,
            "serverSide": true,
            "dom": "<'ui stackable grid'" +
                    "<'row'" +
                    "<'eight wide column'l>" +
                    '<"#filter">' +
                    "<'right aligned eight wide column'f>" +
                    ">" +
                    "<'row dt-table'" +
                    "<'sixteen wide column'tr>" +
                    ">" +
                    "<'row'" +
                    "<'seven wide column'i>" +
                    "<'right aligned nine wide column'p>" +
                    ">" +
                    ">",
            ajax: {
                url: gmCharacter.config.ajaxDatatableInventory,
                dataSrc: 'data',
                type: 'POST',
                data: function (d) {
                    d.knowledge = (gmCharacter.config.filterKnowledge === true) ? 1 : 0, d.characterId = (gmCharacter.config.selectedCharacter !== null) ? gmCharacter.config.selectedCharacter.id : null
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
                    gmCharacter.config.filterKnowledge = !gmCharacter.config.filterKnowledge;
                    gmCharacter.config.datatableInventory.ajax.reload();
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
        gmCharacter.config.datatableInventory.on('select', function (e, dt, type, indexes) {
            if (type === 'row') {
                var data = gmCharacter.config.datatableInventory.rows(indexes).data();
                //gmCharacter.config.selectedEnv = data[0];
                //gmCharacter.config.selectedCharacter = null;
                //gmCharacter.config.datatableCharacter.rows().deselect();
                //gmCharacter.updateMenu();
            }
        });
    },
    clickAddCharacter: function () {
        gmCharacter.ajaxModal(
                gmCharacter.config.idFormAddCharacter,
                gmCharacter.config.ajaxAddCharacter,
                'POST',
                function (data) {
                    if (data.success) {
                        gmCharacter.config.datatableCharacter.ajax.reload();
                    } else {
                        alert(data.message);
                    }
                }
        );
    },
    clickDelCharacter: function () {
        if (confirm("Wirklich löschen?")) {
            gmCharacter.ajaxRequest(gmCharacter.config.ajaxDelCharacter + $(this).data('id'), 'DELETE', {}, function (data) {
                if (data.success) {
                    gmCharacter.config.datatableCharacter.ajax.reload();
                } else {
                    alert(data.message);
                }
            });
        }
    },
    clickEditCharacter: function () {
        gmCharacter.ajaxRequest(gmCharacter.config.ajaxGetCharacter + $(this).data('id'), 'GET', {}, function (data) {
            if (data.success) {
                $(gmCharacter.config.idFormEditCharacter).find('.ui.form')[0].reset();
                $(gmCharacter.config.idFormEditCharacter + '_id').val(data.data.id);
                $(gmCharacter.config.idFormEditCharacter + '_active').val(data.data.active);
                $(gmCharacter.config.idFormEditCharacter + '_accountId').val(data.data.accountId);
                $(gmCharacter.config.idFormEditCharacter + '_accountId').dropdown('set value', data.data.accountId);
                $(gmCharacter.config.idFormEditCharacter + '_charname').val(data.data.charname);
                $(gmCharacter.config.idFormEditCharacter + '_environmentId').val(data.data.environmentId);
                $(gmCharacter.config.idFormEditCharacter + '_environmentId').dropdown('set value', data.data.environmentId);
                $(gmCharacter.config.idFormEditCharacter + '_raceId').val(data.data.raceId);
                $(gmCharacter.config.idFormEditCharacter + '_raceId').dropdown('set value', data.data.raceId);
                $(gmCharacter.config.idFormEditCharacter + '_backgroundId').val(data.data.backgroundId);
                $(gmCharacter.config.idFormEditCharacter + '_backgroundId').dropdown('set value', data.data.backgroundId);
                $(gmCharacter.config.idFormEditCharacter + '_alignment').val(data.data.alignment);
                $(gmCharacter.config.idFormEditCharacter + '_alignment').dropdown('set value', data.data.alignment);
                $(gmCharacter.config.idFormEditCharacter + '_exp').val(data.data.exp);
                $(gmCharacter.config.idFormEditCharacter + '_initiative').val(data.data.initiative);
                $(gmCharacter.config.idFormEditCharacter + '_inspiration').val(data.data.inspiration);
                $(gmCharacter.config.idFormEditCharacter + '_proficiency').val(data.data.proficiency);
                $(gmCharacter.config.idFormEditCharacter + '_class1Id').val(data.data.class1Id);
                $(gmCharacter.config.idFormEditCharacter + '_class1Id').dropdown('set value', data.data.class1Id);
                $(gmCharacter.config.idFormEditCharacter + '_class1Level').val(data.data.class1Level);
                $(gmCharacter.config.idFormEditCharacter + '_class2Id').val(data.data.class2Id);
                $(gmCharacter.config.idFormEditCharacter + '_class2Id').dropdown('set value', data.data.class2Id);
                $(gmCharacter.config.idFormEditCharacter + '_class2Level').val(data.data.class2Level);
                $(gmCharacter.config.idFormEditCharacter + '_class3Id').val(data.data.class3Id);
                $(gmCharacter.config.idFormEditCharacter + '_class3Id').dropdown('set value', data.data.class3Id);
                $(gmCharacter.config.idFormEditCharacter + '_class3Level').val(data.data.class3Level);
                $(gmCharacter.config.idFormEditCharacter + '_class4Id').val(data.data.class4Id);
                $(gmCharacter.config.idFormEditCharacter + '_class4Id').dropdown('set value', data.data.class4Id);
                $(gmCharacter.config.idFormEditCharacter + '_class4Level').val(data.data.class4Level);
                $(gmCharacter.config.idFormEditCharacter + '_ac').val(data.data.ac);
                if (!data.data.hp) {
                    data.data.hp = '0;0;0';
                }
                var mm = data.data.hp.split(";");
                $(gmCharacter.config.idFormEditCharacter + '_hpMax').val(mm[0]);
                $(gmCharacter.config.idFormEditCharacter + '_hpCurrent').val(mm[1]);
                $(gmCharacter.config.idFormEditCharacter + '_hpTemporary').val(mm[2]);
                if (!data.data.money) {
                    data.data.money = '0;0;0;0;0';
                }
                var mm = data.data.money.split(";");
                $(gmCharacter.config.idFormEditCharacter + '_cp').val(mm[0]);
                $(gmCharacter.config.idFormEditCharacter + '_sp').val(mm[1]);
                $(gmCharacter.config.idFormEditCharacter + '_ep').val(mm[2]);
                $(gmCharacter.config.idFormEditCharacter + '_gp').val(mm[3]);
                $(gmCharacter.config.idFormEditCharacter + '_pp').val(mm[4]);
                if (!data.data.savingThrows) {
                    data.data.savingThrows = '0;0;0;0;0;0';
                }
                var st = data.data.savingThrows.split(";");
                $(gmCharacter.config.idFormEditCharacter + '_str').val(st[0]);
                $(gmCharacter.config.idFormEditCharacter + '_dex').val(st[1]);
                $(gmCharacter.config.idFormEditCharacter + '_con').val(st[2]);
                $(gmCharacter.config.idFormEditCharacter + '_int').val(st[3]);
                $(gmCharacter.config.idFormEditCharacter + '_wis').val(st[4]);
                $(gmCharacter.config.idFormEditCharacter + '_cha').val(st[5]);
                if (!data.data.skills) {
                    data.data.skills = '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0';
                }
                var sk = data.data.skills.split(";");
                gmCharacter.setDropdown(gmCharacter.config.idFormEditCharacter + '_acrobatics', sk[0]);
                gmCharacter.setDropdown(gmCharacter.config.idFormEditCharacter + '_acrobatics', sk[0]);
                gmCharacter.setDropdown(gmCharacter.config.idFormEditCharacter + '_animalHandling', sk[1]);
                gmCharacter.setDropdown(gmCharacter.config.idFormEditCharacter + '_arcana', sk[2]);
                gmCharacter.setDropdown(gmCharacter.config.idFormEditCharacter + '_athletics', sk[3]);
                gmCharacter.setDropdown(gmCharacter.config.idFormEditCharacter + '_deception', sk[4]);
                gmCharacter.setDropdown(gmCharacter.config.idFormEditCharacter + '_history', sk[5]);
                gmCharacter.setDropdown(gmCharacter.config.idFormEditCharacter + '_insight', sk[6]);
                gmCharacter.setDropdown(gmCharacter.config.idFormEditCharacter + '_intimidation', sk[7]);
                gmCharacter.setDropdown(gmCharacter.config.idFormEditCharacter + '_investigation', sk[8]);
                gmCharacter.setDropdown(gmCharacter.config.idFormEditCharacter + '_medicine', sk[9]);
                gmCharacter.setDropdown(gmCharacter.config.idFormEditCharacter + '_nature', sk[10]);
                gmCharacter.setDropdown(gmCharacter.config.idFormEditCharacter + '_perception', sk[11]);
                gmCharacter.setDropdown(gmCharacter.config.idFormEditCharacter + '_performance', sk[12]);
                gmCharacter.setDropdown(gmCharacter.config.idFormEditCharacter + '_persuasion', sk[13]);
                gmCharacter.setDropdown(gmCharacter.config.idFormEditCharacter + '_religion', sk[14]);
                gmCharacter.setDropdown(gmCharacter.config.idFormEditCharacter + '_sleightOfHand', sk[15]);
                gmCharacter.setDropdown(gmCharacter.config.idFormEditCharacter + '_stealth', sk[16]);
                gmCharacter.setDropdown(gmCharacter.config.idFormEditCharacter + '_survival', sk[17]);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentQuiver1').val(data.data.equipmentQuiver1);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentQuiver1').dropdown('set value', data.data.equipmentQuiver1);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentQuiver2').val(data.data.equipmentQuiver2);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentQuiver2').dropdown('set value', data.data.equipmentQuiver2);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentQuiver3').val(data.data.equipmentQuiver3);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentQuiver3').dropdown('set value', data.data.equipmentQuiver3);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentHelmet').val(data.data.equipmentHelmet);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentHelmet').dropdown('set value', data.data.equipmentHelmet);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentCape').val(data.data.equipmentCape);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentCape').dropdown('set value', data.data.equipmentCape);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentNecklace').val(data.data.equipmentNecklace);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentNecklace').dropdown('set value', data.data.equipmentNecklace);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentWeapon1').val(data.data.equipmentWeapon1);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentWeapon1').dropdown('set value', data.data.equipmentWeapon1);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentWeapon2').val(data.data.equipmentWeapon2);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentWeapon2').dropdown('set value', data.data.equipmentWeapon2);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentWeapon3').val(data.data.equipmentWeapon3);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentWeapon3').dropdown('set value', data.data.equipmentWeapon3);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentOffWeapon').val(data.data.equipmentOffWeapon);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentOffWeapon').dropdown('set value', data.data.equipmentOffWeapon);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentGloves').val(data.data.equipmentGloves);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentGloves').dropdown('set value', data.data.equipmentGloves);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentArmor').val(data.data.equipmentArmor);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentArmor').dropdown('set value', data.data.equipmentArmor);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentObject').val(data.data.equipmentObject);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentObject').dropdown('set value', data.data.equipmentObject);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentBelt').val(data.data.equipmentBelt);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentBelt').dropdown('set value', data.data.equipmentBelt);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentBoots').val(data.data.equipmentBoots);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentBoots').dropdown('set value', data.data.equipmentBoots);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentRing1').val(data.data.equipmentRing1);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentRing1').dropdown('set value', data.data.equipmentRing1);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentRing2').val(data.data.equipmentRing2);
                $(gmCharacter.config.idFormEditCharacter + '_equipmentRing2').dropdown('set value', data.data.equipmentRing2);
                $(gmCharacter.config.idFormEditCharacter + '_bonusModifier').val(data.data.bonusModifier);
                gmCharacter.ajaxModal(gmCharacter.config.idFormEditCharacter, gmCharacter.config.ajaxEditCharacter + data.data.id, 'POST', function (data) {
                    if (data.success) {
                        gmCharacter.config.datatableCharacter.ajax.reload();
                    } else {
                        alert(data.message);
                    }
                });
            } else {
                alert(data.message);
            }
        });
    },
    setDropdown: function (id, value) {
        $(id).val(value);
        $(id).dropdown('set value', value);
    },
    clickAddInventory: function () {
        $(gmCharacter.config.idFormAddInventory + '_characterId').val(gmCharacter.config.selectedCharacter.id);
        gmCharacter.ajaxModal(
                gmCharacter.config.idFormAddInventory,
                gmCharacter.config.ajaxAddInventory,
                'POST',
                function (data) {
                    if (data.success) {
                        gmCharacter.config.datatableInventory.ajax.reload();
                    } else {
                        alert(data.message);
                    }
                }
        );
    },
    clickDelInventory: function () {
        if (confirm("Wirklich löschen?")) {
            gmCharacter.ajaxRequest(gmCharacter.config.ajaxDelInventory + $(this).data('id'), 'DELETE', {}, function (data) {
                if (data.success) {
                    gmCharacter.config.datatableInventory.ajax.reload();
                } else {
                    alert(data.message);
                }
            });
        }
    },
    clickEditInventory: function () {
        gmCharacter.ajaxRequest(gmCharacter.config.ajaxGetInventory + $(this).data('id'), 'GET', {}, function (data) {
            if (data.success) {
                $(gmCharacter.config.idFormEditInventory + '_id').val(data.data.id);
                $(gmCharacter.config.idFormEditInventory + '_characterId').val(data.data.characterId);
                $(gmCharacter.config.idFormEditInventory + '_itemId').val(data.data.itemId);
                $(gmCharacter.config.idFormEditInventory + '_itemId').parent().dropdown('set selected', data.data.itemId);
                $(gmCharacter.config.idFormEditInventory + '_amount').val(data.data.amount);
                $(gmCharacter.config.idFormEditInventory + '_knowledge').val(data.data.knowledge);
                gmCharacter.ajaxModal(gmCharacter.config.idFormEditInventory, gmCharacter.config.ajaxEditInventory + data.data.id, 'POST', function (data) {
                    if (data.success) {
                        gmCharacter.config.datatableInventory.ajax.reload();
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
                gmCharacter.ajaxRequest(ajaxUrl, ajaxType, $(formId + ' form').serialize(), callback);
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
