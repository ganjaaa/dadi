var dndDashboard = {
    init: function (settings) {
        dndDashboard.config = {
            poll: null,
            idDatatableUser: '#datatableUser',
            idDatatableEnv: '#datatableEnv',
            idUserOptions: '#userOptions',
            idEnvOptions: '#envOptions',
            idEnvOptionsTime: '#envZeit',
            idEnvOptionsDate: '#envDatum',
            idEnvOptionsWeather: '#envWetter',
            idEnvOptionsTemp: '#envTemperatur',
            idEnvOptionsHum: '#envHumidity',
            idEnvOptionsSmog: '#envSmog',
            idBtnDive: '.bdice',
            idBtnAddItem: '#btnAddItems',
            idBtnGlobalReload: '#globalReload',
            idBtnUserReload: '#userReload',
            idBtnGlobalMessage: '#globalMessage',
            idBtnUserMessage: '#userMessage',
            idBtnGlobalMoney: '#globalMoney',
            idBtnUserMoney: '#userMoney',
            idBtnGlobalHP: '#globalHP',
            idBtnUserHP: '#userHP',
            idBtnGlobalFullHP: '#globalFullHP',
            idBtnUserFullHP: '#userFullHP',
            idBtnGlobalExp: '#globalExp',
            idBtnUserExp: '#userExp',
            idBtnEnvZeit: '#btnAddEnvZeit',
            idBtnEnvDate: '#btnAddEnvDatum',
            idBtnEnvWetter: '#btnAddEnvWetter',
            idBtnEnvTemp: '#btnAddEnvTemperatur',
            idBtnEnvHum: '#btnAddEnvHumidity',
            idBtnEnvSmog: '#btnAddEnvSmog',
            idFormMessage: '#modalMessage',
            idFormMoney: '#Money_editForm',
            idFormHp: '#modalHP',
            idFormExp: '#modalExp',
            idBtnGlobalItem: '#globalItem',
            idBtnUserItem: '#userItem',
            idFormAddInventory: '#Inventory_addForm',
            idDiceStatic: '#staticDice',
            ajaxDatatableUser: '/v2/datatable/user',
            ajaxDatatableEnv: '/v2/datatable/environment',
            ajaxDatatablePoll: '/v1/info',
            ajaxShortcutMoney: '/v0/shortcut/money',
            ajaxShortcutHp: '/v0/shortcut/hp',
            ajaxShortcutHpFull: '/v0/shortcut/fullhp',
            ajaxShortcutExp: '/v0/shortcut/exp',
            ajaxAddInventory: '/v0/shortcut/item',
            ajaxDice: '/v0/dice/',
            ajaxEnv: '/v2/environment',
            datatableUser: null,
            datatableEnv: null,
            selectedUser: null,
            selectedEnv: null,
        };
        $.extend(dndDashboard.config, settings);
        dndDashboard.setup();
    },
    setup: function () {
        dndDashboard.setupButtons();
        dndDashboard.setupDatatableUser();
        dndDashboard.setupDatatableEnv();
        $("form").submit(function (e) {
            e.preventDefault();
        });
    },
    setupButtons: function () {
        $(document)
                .on('click', dndDashboard.config.idBtnDive, dndDashboard.clickDice)
                .on('click', dndDashboard.config.idBtnGlobalReload, dndDashboard.clickReloadAll)
                .on('click', dndDashboard.config.idBtnUserReload, dndDashboard.clickReloadUser)
                .on('click', dndDashboard.config.idBtnGlobalMessage, dndDashboard.clickMessageAll)
                .on('click', dndDashboard.config.idBtnUserMessage, dndDashboard.clickMessageUser)
                .on('click', dndDashboard.config.idBtnGlobalMoney, dndDashboard.clickMoneyAll)
                .on('click', dndDashboard.config.idBtnUserMoney, dndDashboard.clickMoneyUser)
                .on('click', dndDashboard.config.idBtnGlobalHP, dndDashboard.clickHPAll)
                .on('click', dndDashboard.config.idBtnUserHP, dndDashboard.clickHPUser)
                .on('click', dndDashboard.config.idBtnGlobalFullHP, dndDashboard.clickFullHPAll)
                .on('click', dndDashboard.config.idBtnUserFullHP, dndDashboard.clickFullHPUser)
                .on('click', dndDashboard.config.idBtnGlobalExp, dndDashboard.clickExpAll)
                .on('click', dndDashboard.config.idBtnUserExp, dndDashboard.clickExpUser)
                .on('click', dndDashboard.config.idBtnEnvZeit, dndDashboard.clickEnvTime)
                .on('click', dndDashboard.config.idBtnEnvDate, dndDashboard.clickEnvDate)
                .on('click', dndDashboard.config.idBtnEnvWetter, dndDashboard.clickEnvWeather)
                .on('click', dndDashboard.config.idBtnEnvTemp, dndDashboard.clickEnvTemp)
                .on('click', dndDashboard.config.idBtnEnvHum, dndDashboard.clickEnvHum)
                .on('click', dndDashboard.config.idBtnEnvSmog, dndDashboard.clickEnvSmog)
                .on('click', dndDashboard.config.idBtnGlobalItem, dndDashboard.clickItemAll)
                .on('click', dndDashboard.config.idBtnUserItem, dndDashboard.clickItemUser);
    },
    setupDatatableUser: function () {
        dndDashboard.config.datatableUser = $(dndDashboard.config.idDatatableUser).DataTable({
            "jQueryUI": false,
            "processing": true,
            "serverSide": true,
            "dom": 't',
            select: true,
            ajax: {
                url: dndDashboard.config.ajaxDatatableUser,
                dataSrc: 'data',
                type: 'POST'
            },
            columns: [
                {data: "mail"},
                {data: "charname"},
            ],
            createdRow: function (row, data, dataIndex) {
                var sec = dndDashboard.compareDate(data['lastActivity']);
                console.log(sec);
                if (sec <= 30) {
                    $(row).css('background-color', '#ccffcc');
                } else {
                    $(row).css('background-color', '#ffcccc');
                }
            },
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
        dndDashboard.config.datatableUser.on('select', function (e, dt, type, indexes) {
            if (type === 'row') {
                var data = dndDashboard.config.datatableUser.rows(indexes).data();
                dndDashboard.config.selectedUser = data[0];
                dndDashboard.config.selectedEnv = null;
                dndDashboard.config.datatableEnv.rows().deselect();
                dndDashboard.updateMenu();
            }
        });
    },
    setupDatatableEnv: function () {
        dndDashboard.config.datatableEnv = $(dndDashboard.config.idDatatableEnv).DataTable({
            "jQueryUI": false,
            "processing": true,
            "serverSide": true,
            "dom": 't',
            select: true,
            ajax: {
                url: dndDashboard.config.ajaxDatatableEnv,
                dataSrc: 'data',
                type: 'POST'
            },
            columns: [
                {data: "name"},
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
        dndDashboard.config.datatableEnv.on('select', function (e, dt, type, indexes) {
            if (type === 'row') {
                var data = dndDashboard.config.datatableEnv.rows(indexes).data();
                dndDashboard.config.selectedEnv = data[0];
                dndDashboard.config.selectedUser = null;
                dndDashboard.config.datatableUser.rows().deselect();
                dndDashboard.updateMenu();
            }
        });
    },
    updateMenu: function () {
        var uid = dndDashboard.config.selectedUser;
        var eid = dndDashboard.config.selectedEnv;

        $(dndDashboard.config.idUserOptions).hide();
        $(dndDashboard.config.idEnvOptions).hide();

        if (uid !== null) {
            var obj = dndDashboard.config.selectedUser;
            $(dndDashboard.config.idUserOptions).show();
            $(dndDashboard.config.idUserOptions).find('.data').html(obj.charname);
        }

        if (eid !== null) {
            var obj = dndDashboard.config.selectedEnv;
            $(dndDashboard.config.idEnvOptions).show();
            $(dndDashboard.config.idEnvOptions).find('.data').html(obj.name);
            $(dndDashboard.config.idEnvOptionsTime).val('loading...');
            $(dndDashboard.config.idEnvOptionsDate).val('loading...');
            $(dndDashboard.config.idEnvOptionsWeather).val('loading...');
            $(dndDashboard.config.idEnvOptionsTemp).val('loading...');
            $(dndDashboard.config.idEnvOptionsHum).val('loading...');
            $(dndDashboard.config.idEnvOptionsSmog).val('loading...');
            dndDashboard.ajaxRequest('/v2/environment/' + obj.id, 'GET', {}, function (data) {
                $(dndDashboard.config.idEnvOptionsTime).val(data.data.time);
                $(dndDashboard.config.idEnvOptionsDate).val(data.data.day + '.' + data.data.month + '.' + data.data.year);
                $(dndDashboard.config.idEnvOptionsWeather).val(data.data.weather);
                $(dndDashboard.config.idEnvOptionsTemp).val(data.data.temperature);
                $(dndDashboard.config.idEnvOptionsHum).val(data.data.humidity);
                $(dndDashboard.config.idEnvOptionsSmog).val(data.data.smog);
            });
        }
    },
    pollMessage: function (userId, message) {
        dndDashboard.ajaxRequest(
                dndDashboard.config.ajaxDatatablePoll + (userId === null ? '' : '/' + userId),
                'POST',
                {message: message},
        function (data) {
            if (!data.success) {
                alert(data.message);
            }
        }
        );
    },
    pollCommand: function (userId, cmd) {
        dndDashboard.ajaxRequest(
                dndDashboard.config.ajaxDatatablePoll + (userId === null ? '' : '/' + userId),
                'POST',
                {command: cmd},
        function (data) {
            if (!data.success) {
                alert(data.message);
            }
        }
        );
    },
    clickDice: function () {
        var id = $(this).data('value');
        dndDashboard.ajaxRequest(
                dndDashboard.config.ajaxDice + id,
                'GET',
                {},
                function (data) {
                    if (data.success) {
                        $(dndDashboard.config.idDiceStatic).html(data.data);
                        dndDashboard.updateDiceHistory("W" + id, data.data);
                    } else {
                        alert(data.message);
                    }
                }
        );
    },
    updateDiceHistory: function (label, value) {
        var i = 0;
        var color = ["#1b1c1d", "#404040", "#696969", "#989898", "#BEBEBE", "#D3D3D3"];
        var cnt = $("#statisticsGroup > div").length;

        if (cnt > 5) {
            $('#statisticsGroup div.statistic:last-child').remove(); // remove last Div
        }
        // Add New Item
        $("#statisticsGroup").prepend('<div class="statistic"><div class="value">' + value + '</div><div class="label">' + label + '</div></div>');
        // Set Colors
        $("#statisticsGroup div.statistic").each(function (index) {
            $(this).find('.label').css('color', color[i]);
            $(this).find('.value').css('color', color[i]);
            i++;
        });
    },
    clickReloadAll: function () {
        dndDashboard.pollCommand(null, $('#modalMessageValue').val());
    },
    clickReloadUser: function () {
        dndDashboard.pollCommand(dndDashboard.config.selectedUser.id, $('#modalMessageValue').val());
    },
    clickMessageAll: function () {
        dndDashboard.modal(dndDashboard.config.idFormMessage, function () {
            dndDashboard.pollMessage(null, $('#modalMessageValue').val());
        });
    },
    clickMessageUser: function () {
        dndDashboard.modal(dndDashboard.config.idFormMessage, function () {
            dndDashboard.pollMessage(dndDashboard.config.selectedUser.id, $('#modalMessageValue').val());
        });
    },
    clickMoneyAll: function () {
        dndDashboard.ajaxModal(
                dndDashboard.config.idFormMoney,
                dndDashboard.config.ajaxShortcutMoney,
                'POST',
                function (data) {
                    if (data.success) {
                        var cp = $(dndDashboard.config.idFormMoney + '_cp').val();
                        var sp = $(dndDashboard.config.idFormMoney + '_sp').val();
                        var ep = $(dndDashboard.config.idFormMoney + '_ep').val();
                        var gp = $(dndDashboard.config.idFormMoney + '_gp').val();
                        var pp = $(dndDashboard.config.idFormMoney + '_pp').val();

                        dndDashboard.pollCommand(null, 'reloadMoney');
                        dndDashboard.pollMessage(null, 'Du hast ' +
                                (cp != "" && cp != 0 ? "<b>" + cp + " CP</b><br>" : "") +
                                (sp != "" && sp != 0 ? "<b>" + sp + " SP</b><br>" : "") +
                                (ep != "" && ep != 0 ? "<b>" + ep + " EP</b><br>" : "") +
                                (gp != "" && gp != 0 ? "<b>" + gp + " GP</b><br>" : "") +
                                (pp != "" && pp != 0 ? "<b>" + pp + " PP</b><br>" : "") +
                                'erhalten!');
                    } else {
                        alert(data.message);
                    }
                });
    },
    clickMoneyUser: function () {
        dndDashboard.ajaxModal(
                dndDashboard.config.idFormMoney,
                dndDashboard.config.ajaxShortcutMoney + '/' + dndDashboard.config.selectedUser.id,
                'POST',
                function (data) {
                    if (data.success) {
                        var cp = $(dndDashboard.config.idFormMoney + '_cp').val();
                        var sp = $(dndDashboard.config.idFormMoney + '_sp').val();
                        var ep = $(dndDashboard.config.idFormMoney + '_ep').val();
                        var gp = $(dndDashboard.config.idFormMoney + '_gp').val();
                        var pp = $(dndDashboard.config.idFormMoney + '_pp').val();

                        dndDashboard.pollCommand(dndDashboard.config.selectedUser.id, 'reloadMoney');
                        dndDashboard.pollMessage(dndDashboard.config.selectedUser.id, 'Du hast ' +
                                (cp != "" && cp != 0 ? "<b>" + cp + " CP</b><br>" : "") +
                                (sp != "" && sp != 0 ? "<b>" + sp + " SP</b><br>" : "") +
                                (ep != "" && ep != 0 ? "<b>" + ep + " EP</b><br>" : "") +
                                (gp != "" && gp != 0 ? "<b>" + gp + " GP</b><br>" : "") +
                                (pp != "" && pp != 0 ? "<b>" + pp + " PP</b><br>" : "") +
                                'erhalten!');
                    } else {
                        alert(data.message);
                    }
                }
        );
    },
    clickHPAll: function () {
        dndDashboard.ajaxModal(
                dndDashboard.config.idFormHp,
                dndDashboard.config.ajaxShortcutHp,
                'POST',
                function (data) {
                    if (data.success) {
                        dndDashboard.pollCommand(null, 'reloadHP');
                        dndDashboard.pollMessage(null, 'Du hast <b>' + $('#modalHPValue').val() + '</b> HP erhalten!');
                    } else {
                        alert(data.message);
                    }
                }
        );
    },
    clickHPUser: function () {
        dndDashboard.ajaxModal(
                dndDashboard.config.idFormHp,
                dndDashboard.config.ajaxShortcutHp + '/' + dndDashboard.config.selectedUser.id,
                'POST',
                function (data) {
                    if (data.success) {
                        dndDashboard.pollCommand(dndDashboard.config.selectedUser.id, 'reloadHP');
                        dndDashboard.pollMessage(dndDashboard.config.selectedUser.id, 'Du hast <b>' + $('#modalHPValue').val() + '</b> HP erhalten!');
                    } else {
                        alert(data.message);
                    }
                }
        );
    },
    clickFullHPAll: function () {
        dndDashboard.ajaxRequest(
                dndDashboard.config.ajaxShortcutHpFull,
                'POST',
                [],
                function (data) {
                    if (data.success) {
                        dndDashboard.pollCommand(null, 'reloadHP');
                        dndDashboard.pollMessage(null, 'Deine HP wurden aufgefüllt!');
                    } else {
                        alert(data.message);
                    }
                }
        );
    },
    clickFullHPUser: function () {
        dndDashboard.ajaxRequest(
                dndDashboard.config.ajaxShortcutHpFull + '/' + dndDashboard.config.selectedUser.id,
                'POST',
                [],
                function (data) {
                    if (data.success) {
                        dndDashboard.pollCommand(dndDashboard.config.selectedUser.id, 'reloadHP');
                        dndDashboard.pollMessage(dndDashboard.config.selectedUser.id, 'Deine HP wurden aufgefüllt!');
                    } else {
                        alert(data.message);
                    }
                }
        );
    },
    clickExpAll: function () {
        dndDashboard.ajaxModal(
                dndDashboard.config.idFormExp,
                dndDashboard.config.ajaxShortcutExp,
                'POST',
                function (data) {
                    if (data.success) {
                        dndDashboard.pollCommand(null, 'reloadExp');
                        dndDashboard.pollMessage(null, 'Du hast <b>' + $('#modalExpValue').val() + '</b> EXP erhalten!');
                    } else {
                        alert(data.message);
                    }
                }
        );
    },
    clickExpUser: function () {
        dndDashboard.ajaxModal(
                dndDashboard.config.idFormExp,
                dndDashboard.config.ajaxShortcutExp + '/' + dndDashboard.config.selectedUser.id,
                'POST',
                function (data) {
                    if (data.success) {
                        dndDashboard.pollCommand(dndDashboard.config.selectedUser.id, 'reloadHP');
                        dndDashboard.pollMessage(dndDashboard.config.selectedUser.id, 'Du hast <b>' + $('#modalExpValue').val() + '</b> EXP erhalten!');
                    } else {
                        alert(data.message);
                    }
                }
        );
    },
    clickEnvTime: function () {
        var eid = dndDashboard.config.selectedEnv.id;
        var val = $(dndDashboard.config.idEnvOptionsTime).val();
        dndDashboard.ajaxRequest(dndDashboard.config.ajaxEnv + '/' + eid, 'POST', {id: eid, time: val}, function () {
            dndDashboard.pollCommand(dndDashboard.config.selectedUser.id, 'reloadEnv');
        });
    },
    clickEnvDate: function () {
        var eid = dndDashboard.config.selectedEnv.id;
        var val = $(dndDashboard.config.idEnvOptionsDate).val();
        var d = val.split(".");
        dndDashboard.ajaxRequest(dndDashboard.config.ajaxEnv + '/' + eid, 'POST', {id: eid, day: d[0], month: d[1], year: d[2]}, function () {
            dndDashboard.pollCommand(dndDashboard.config.selectedUser.id, 'reloadEnv');
        });
    },
    clickEnvWeather: function () {
        var eid = dndDashboard.config.selectedEnv.id;
        var val = $(dndDashboard.config.idEnvOptionsWeather).val();
        dndDashboard.ajaxRequest(dndDashboard.config.ajaxEnv + '/' + eid, 'POST', {id: eid, weather: val}, function () {
            dndDashboard.pollCommand(dndDashboard.config.selectedUser.id, 'reloadEnv');
        });
    },
    clickEnvTemp: function () {
        var eid = dndDashboard.config.selectedEnv.id;
        var val = $(dndDashboard.config.idEnvOptionsTemp).val();
        dndDashboard.ajaxRequest(dndDashboard.config.ajaxEnv + '/' + eid, 'POST', {id: eid, temperature: val}, function () {
            dndDashboard.pollCommand(dndDashboard.config.selectedUser.id, 'reloadEnv');
        });
    },
    clickEnvHum: function () {
        var eid = dndDashboard.config.selectedEnv.id;
        var val = $(dndDashboard.config.idEnvOptionsHum).val();
        dndDashboard.ajaxRequest(dndDashboard.config.ajaxEnv + '/' + eid, 'POST', {id: eid, humidity: val}, function () {
            dndDashboard.pollCommand(dndDashboard.config.selectedUser.id, 'reloadEnv');
        });
    },
    clickEnvSmog: function () {
        var eid = dndDashboard.config.selectedEnv.id;
        var val = $(dndDashboard.config.idEnvOptionsSmog).val();
        dndDashboard.ajaxRequest(dndDashboard.config.ajaxEnv + '/' + eid, 'POST', {id: eid, smog: val}, function () {
            dndDashboard.pollCommand(dndDashboard.config.selectedUser.id, 'reloadEnv');
        });
    },
    clickItemAll: function () {
        dndDashboard.ajaxModal(
                dndDashboard.config.idFormAddInventory,
                dndDashboard.config.ajaxAddInventory,
                'POST',
                function (data) {
                    if (data.success) {
                        dndDashboard.pollMessage(null, 'Du hast ein Item erhalten!');
                    } else {
                        alert(data.message);
                    }
                }
        );
    },
    clickItemUser: function () {
        $(dndDashboard.config.idFormAddInventory + '_characterId').val(dndDashboard.config.selectedUser.id);
        dndDashboard.ajaxModal(
                dndDashboard.config.idFormAddInventory,
                dndDashboard.config.ajaxAddInventory + '/' + dndDashboard.config.selectedUser.id,
                'POST',
                function (data) {
                    if (data.success) {
                        dndDashboard.pollMessage(dndDashboard.config.selectedUser.id, 'Du hast ein Item erhalten!');
                    } else {
                        alert(data.message);
                    }
                }
        );
    },
    modal: function (formId, callback) {
        $(formId).modal({onApprove: callback}).modal('show');
    },
    ajaxModal: function (formId, ajaxUrl, ajaxType, callback) {
        $(formId).modal({
            onApprove: function () {
                dndDashboard.ajaxRequest(ajaxUrl, ajaxType, $(formId + ' form').serialize(), callback);
            }
        }).modal('show');
    },
    ajaxRequest: function (ajaxUrl, ajaxType, ajaxData, callback) {
        $.ajax({url: ajaxUrl, dataType: 'json', type: ajaxType, data: ajaxData, success: callback});
    },
    ajaxDefaultCallback: function (data) {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    },
    ajaxDefaultReloadCallback: function (data) {
        if (data.success) {
            // dndDashboard.cmdReloadAll();
        } else {
            alert(data.message);
        }
    },
    debug: function (msg) {
        if (dndDashboard.config.DEBUG) {
            console.log(msg);
        }
    },
    compareDate: function (date2) {
        var t1 = new Date();
        var t2 = new Date(Date.parse(date2));
        var dif = t1.getTime() - t2.getTime();

        var Seconds_from_T1_to_T2 = dif / 1000;
        return Math.round(Math.abs(Seconds_from_T1_to_T2));
    }
};