var dndUsersheet = {
    init: function (settings) {
        dndUsersheet.config = {
            poll: null,
            idMenuTab: '#tabMenu .item',
            idDatatableLog: '#datatableLog',
            idDatatableIventory: '#datatableInventory',
            idDatatableSpellbook: '#datatableSpellbook',
            idDiary: '#tinyDiary',
            idHpBar: '#hpBar',
            idUpdateHP: '#vHP',
            idUpdateCP: '#vCP',
            idUpdateSP: '#vSP',
            idUpdateEP: '#vEP',
            idUpdateGP: '#vGP',
            idUpdatePP: '#vPP',
            idUpdate: '#vENV',
            idUpdateEnv1: '#vENV1',
            idUpdateEnv2: '#vENV2',
            idUpdateEnv3: '#vENV3',
            idUpdateEnv4: '#vENV4',
            idUpdateEnv5: '#vENV5',
            idUpdateEnv6: '#vENV6',
            idUpdateChar: '#vChar',
            idButtonEquipt: '.equiptItem',
            idButtonUnequipt: '.unequiptItem',
            idButtonTrade: '.tradeItem',
            idButtonRemove: '.removeItem',
            ajaxEditDiary: '/v0/diary',
            ajaxDatatableLog: '/v0/datatable/info',
            ajaxDatatableInventory: '/v0/datatable/inventory',
            ajaxDatatableSpellbook: '/v0/datatable/spellbook',
            ajaxPoll: '/v1/info',
            ajaxData: '/v1/data',
            ajaxEquipt: '/v0/shortcut/equipt',
            ajaxUnquipt: '/v0/shortcut/unequipt',
            ajaxTrade: '/v0/shortcut/trade',
            ajaxDrop: '/v0/shortcut/drop',
            datatableLog: null,
            datatableInventory: null,
            datatableSpellbook: null,
            HPBar: null,
            Tab: null,
            CodeMirror: null,
            Firepad: null,
            idFirepad: 'firepad-container',
            idFirepadDiv: null,
            idFirepadRef: null,
            timeoutDiary: null,
            timeoutMessage: null,
            idPopupMessage: '#popupMessage',
            idPopupMessageClose: '#popupMessageCancel',
            idPopupMessageContent: '#popupMessageContent',
            popupLoading: '<i class="notched circle loading icon green"></i> wait...',
            popupItems: $('.tooltip.paperslot'),
            popupTarget: '#pupx',
            popupLoadingEmpty: 'Leer',
            firepadConfig: {
                apiKey: '',
                authDomain: '',
                databaseURL: '',
                projectId: '',
                storageBucket: '',
                messagingSenderId: '',
            }
        };
        $.extend(dndUsersheet.config, settings);
        dndUsersheet.setup();
    },
    setup: function () {
        dndUsersheet.setupPoll();
        dndUsersheet.setupTab();
        dndUsersheet.setupDiary();
        dndUsersheet.setupDatatableInfo();
        //dndUsersheet.setupDatatableSpellbook();
        dndUsersheet.setupDatatableInventory();
        dndUsersheet.setupButtons();
        dndUsersheet.config.HPBar = $(dndUsersheet.config.idHpBar).progress();
    },
    setupButtons: function () {
        $(document)
                .on('click', dndUsersheet.config.idButtonEquipt, dndUsersheet.clickButtonEquipt)
                .on('click', dndUsersheet.config.idButtonUnequipt, dndUsersheet.clickButtonUnequipt)
                .on('click', dndUsersheet.config.idButtonTrade, dndUsersheet.clickButtonTrade)
                .on('click', dndUsersheet.config.idButtonRemove, dndUsersheet.clickButtonRemove);
    },
    setupPoll: function () {
        if (dndUsersheet.config.poll === null) {
            dndUsersheet.config.poll = setInterval(dndUsersheet.doPoll, 3000);
        }
    },
    doPoll: function () {
        dndUsersheet.ajaxRequest(
                dndUsersheet.config.ajaxPoll,
                'GET',
                [],
                dndUsersheet.responsePoll
                );
    },
    responsePoll: function (data) {
        $.each(data.data, function (key, val) {
            if (val.message !== null) {
                dndUsersheet.appendPopup('<div class="item"><div class="header">[' + dndUsersheet.getZeit() + '] </div>' + val.message + '</div>');
                dndUsersheet.doShowMessageBox();
            }
            if (val.command !== null) {
                switch (val.command) {
                    case 'reloadExp':
                        dndUsersheet.ajaxRequest(dndUsersheet.config.ajaxData, 'GET', [], function (data) {
                            $(dndUsersheet.config.idUpdateChar).html('' + data.data.charname + ' Lvl ' + data.data.level.level + ' (' + data.data.level.exp + '/' + data.data.level.expCap + ')');
                        });
                        break;
                    case 'reloadEnv':
                        dndUsersheet.ajaxRequest(dndUsersheet.config.ajaxData, 'GET', [], function (data) {
                            console.log(data.data.env);
                            $(dndUsersheet.config.idUpdateEnv1).html(data.data.env.time);
                            $(dndUsersheet.config.idUpdateEnv2).html(data.data.env.day + '.' + data.data.env.month + '.' + data.data.env.year + ' - ' + data.data.env.date.monthWord);
                            $(dndUsersheet.config.idUpdateEnv3).html(data.data.env.weather + '(Temp:' + data.data.env.temperature + '°C Hum:' + data.data.env.humidity + '%)');
                            $(dndUsersheet.config.idUpdateEnv4).html('Mond1: <img style="height:20px;width: 20px" title="' + data.data.env.date.moon1 + '" src="/inc/images/moon_' + data.data.env.date.moon1 + '.png">, Mond2: <img style="height:20px;width: 20px" title="' + data.data.env.date.moon2 + '" src="/inc/images/moon_' + data.data.env.date.moon2 + '.png">');
                            $(dndUsersheet.config.idUpdateEnv5).html('');
                            $(dndUsersheet.config.idUpdateEnv6).html('Smog: ' + data.data.env.smog + '%');
                        });
                        break;
                    case 'reloadHP':
                        dndUsersheet.ajaxRequest(dndUsersheet.config.ajaxData, 'GET', [], function (data) {
                            $(dndUsersheet.config.idUpdateHP).html(data.data.hp.now + '/' + data.data.hp.max + '(' + data.data.hp.tmp + ')');
                            dndUsersheet.config.HPBar = $(dndUsersheet.config.idHpBar).progress('set percent', Math.round(data.data.hp.now / (data.data.hp.max + data.data.hp.tmp)));
                        });
                        break;
                    case 'reloadMoney':
                        dndUsersheet.ajaxRequest(dndUsersheet.config.ajaxData, 'GET', [], function (data) {
                            $(dndUsersheet.config.idUpdateCP).html(data.data.money.copper);
                            $(dndUsersheet.config.idUpdateSP).html(data.data.money.silver);
                            $(dndUsersheet.config.idUpdateEP).html(data.data.money.electrum);
                            $(dndUsersheet.config.idUpdateGP).html(data.data.money.gold);
                            $(dndUsersheet.config.idUpdatePP).html(data.data.money.platinum);
                        });
                        break;
                    case 'reload':
                        setTimeout(function () {
                            location.reload();
                        }, 5000);
                        break;
                }
            }
        });
    },
    setupDatatableInfo: function () {
        dndUsersheet.config.datatableLog = $(dndUsersheet.config.idDatatableLog).DataTable({
            "jQueryUI": false,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: dndUsersheet.config.ajaxDatatableLog,
                dataSrc: 'data',
                type: 'POST'
            },
            "initComplete": function (settings, json) {
                $('.ui.dropdown').dropdown();
            },
            "drawCallback": function (settings) {
                $('.ui.dropdown').dropdown();
            },
            columns: [
                {data: "date"},
                {data: "message"},
            ],
            "order": [[0, "desc"]],
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
    setupDatatableSpellbook: function () {
        dndUsersheet.config.datatableSpellbook = $(dndUsersheet.config.idDatatableSpellbook).DataTable({
            "jQueryUI": false,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: dndUsersheet.config.ajaxDatatableLog,
                dataSrc: 'data',
                type: 'POST'
            },
            "initComplete": function (settings, json) {
                $('.ui.dropdown').dropdown();
            },
            "drawCallback": function (settings) {
                $('.ui.dropdown').dropdown();
            },
            columns: [
                {data: "date"},
                {data: "message"},
            ],
            "order": [[0, "desc"]],
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
    setupDatatableInventory: function () {
        dndUsersheet.config.datatableInventory = $(dndUsersheet.config.idDatatableIventory).DataTable({
            "jQueryUI": false,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: dndUsersheet.config.ajaxDatatableInventory,
                dataSrc: 'data',
                type: 'POST'
            },
            "initComplete": function (settings, json) {
                $('.ui.dropdown').dropdown();
            },
            "drawCallback": function (settings) {
                $('.ui.dropdown').dropdown();
            },
            columns: [
                {
                    data: "id",
                    orderable: false,
                    "render": function (data, type, row, meta) {
                        return '<img src="/image/' + data + '" style="weight:30px; height:30px; border: none; padding: 0px">';
                    }
                },
                {data: "name"},
                {
                    data: "description",
                    "render": function (data, type, row, meta) {
                        return data;
                    }
                },
                {data: "amount"},
                {
                    data: "weight",
                    orderable: false,
                    "render": function (data, type, row, meta) {
                        return (data * row.amount);
                    }
                },
                {
                    "orderable": false,
                    "data": "id",
                    "render": function (data, type, row, meta) {
                        var menu = '';
                        menu += '<div class="ui vertical icon labeled buttons">';

                        if (row.wearable !== null && row.wearable !== "" && row.wearable > 0) {
                            menu += '    <div class="equiptItem ui button" data-id="' + data + '"><i class="universal access icon"></i> Anziehen</div>';
                        } else {
                            menu += '    <div class="disabled ui button" data-id="' + data + '"><i class="universal access icon"></i> Anziehen</div>';
                        }
                        menu += '    <div class="tradeItem ui button" data-id="' + data + '"><i class="sync alternate icon"></i> Weitergeben</div>';
                        menu += '    <div class="removeItem ui button item" data-id="' + data + '"><i class="trash icon"></i> Wegwerfen</div>';
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
    setupTab: function () {
        dndUsersheet.config.Tab = $(dndUsersheet.config.idMenuTab).tab({
            history: true,
            onLoad: function (tabPath, parameterArray, historyEvent) {
                if (tabPath == "Quest") {
                    dndUsersheet.setupFirepad();
                }
            }
        });
    },
    setupDiary: function () {
        tinymce.init({
            selector: dndUsersheet.config.idDiary,
            setup: function (ed) {
                ed.on('keydown', function (e) {
                    dndUsersheet.updateDiary(ed.getContent());
                }).on('change', function (e) {
                    dndUsersheet.updateDiary(ed.getContent());
                });
            }
        });
    },
    updateDiary: function (content) {
        clearTimeout(dndUsersheet.config.timeoutDiary);
        dndUsersheet.config.timeoutDiary = setTimeout(function () {
            dndUsersheet.ajaxRequest(dndUsersheet.config.ajaxEditDiary, 'POST', {diary: content}, function (data) {
                if (!data.success) {
                    alert(data.message);
                }
            });
        }, 1000);
    },
    setupFirepad: function () {
        try {
            firebase.initializeApp(dndUsersheet.config.firepadConfig);
            dndUsersheet.config.idFirepadDiv = document.getElementById(dndUsersheet.config.idFirepad);
            dndUsersheet.config.idFirepadRef = firebase.database().ref();
            dndUsersheet.config.CodeMirror = CodeMirror(dndUsersheet.config.idFirepadDiv, {lineWrapping: true});
            dndUsersheet.config.Firepad = Firepad.fromCodeMirror(dndUsersheet.config.idFirepadRef, dndUsersheet.config.CodeMirror, {richTextShortcuts: true, richTextToolbar: true});
        } catch (err) {
        }
    },
    clickButtonEquipt: function () {
        dndUsersheet.ajaxRequest(dndUsersheet.config.ajaxEquipt + '/' + $(this).data('id'), 'POST', {}, dndUsersheet.ajaxDefaultCallback);
    },
    clickButtonUnequipt: function () {
        dndUsersheet.ajaxRequest(dndUsersheet.config.ajaxUnquipt + '/' + $(this).data('id'), 'POST', {}, dndUsersheet.ajaxDefaultCallback);
    },
    clickButtonTrade: function () {
        dndUsersheet.ajaxModal('#Inventory_tradeForm', dndUsersheet.config.ajaxTrade + '/' + $(this).data('id'), 'POST', dndUsersheet.ajaxInventoryReload);
    },
    clickButtonRemove: function () {
        dndUsersheet.ajaxModal('#Inventory_dropForm', dndUsersheet.config.ajaxDrop + '/' + $(this).data('id'), 'POST', dndUsersheet.ajaxInventoryReload);
    },
    ajaxModal: function (formId, ajaxUrl, ajaxType, myCallback) {
        $(formId).modal({
            onApprove: function () {
                dndUsersheet.ajaxRequest(ajaxUrl, ajaxType, $(formId + ' form').serialize(), myCallback);
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
    ajaxInventoryReload: function (data) {
        if (data.success) {
            dndUsersheet.config.datatableInventory.ajax.reload();
        } else {
            alert(data.message);
        }
    },
    ajaxDefaultCallback: function (data) {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    },
    doShowMessageBox: function () {
        $(dndUsersheet.config.idPopupMessage).show();
        if (dndUsersheet.config.timeoutMessage !== false) {
            clearTimeout(dndUsersheet.config.timeoutMessage);
        }
        dndUsersheet.config.timeoutMessage = setTimeout(function () {
            dndUsersheet.resetPopup();
        }, (10 * 1000));
    },
    clickClosePopup: function () {
        dndUsersheet.resetPopup();
    },
    resetPopup: function () {
        $(dndUsersheet.config.idPopupMessageContent).html('');
        $(dndUsersheet.config.idPopupMessage).hide();
    },
    appendPopup: function (msg) {
        var old = $(dndUsersheet.config.idPopupMessageContent).html();
        $(dndUsersheet.config.idPopupMessageContent).html(msg + old);
    },
    getZeit: function () {
        var now = new Date();
        return now.getUTCHours() + ":" + now.getUTCMinutes() + ":" + now.getUTCSeconds();
    },
};
