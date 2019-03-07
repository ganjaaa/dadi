var gmAccount = {
    init: function (settings) {
        gmAccount.config = {
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
        $.extend(gmAccount.config, settings);

        gmAccount.setup();
    },
    setup: function () {
        gmAccount.setupButtons();
        gmAccount.setupDatatableAccount();
    },
    setupButtons: function () {
        $(document)
                .on('click', gmAccount.config.idBtnAddAccount, gmAccount.clickAddAccount)
                .on('click', gmAccount.config.idBtnEditAccount, gmAccount.clickEditAccount)
                .on('click', gmAccount.config.idBtnDeleteAccount, gmAccount.clickDelAccount)
                .on('click', gmAccount.config.idBtnAddInventory, gmAccount.clickAddInventory)
                .on('click', gmAccount.config.idBtnEditInventory, gmAccount.clickEditInventory)
                .on('click', gmAccount.config.idBtnDeleteInventory, gmAccount.clickDelInventory);
    },
    setupDatatableAccount: function () {
        gmAccount.config.datatableAccount = $(gmAccount.config.idDatatableAccount).DataTable({
            "jQueryUI": false,
            "processing": true,
            "serverSide": true,
            "select": true,
            ajax: {
                url: gmAccount.config.ajaxDatatableAccount,
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

        gmAccount.config.datatableAccount.on('select', function (e, dt, type, indexes) {
            if (type === 'row') {
                var data = gmAccount.config.datatableAccount.rows(indexes).data();
                gmAccount.config.selectedAccount = data[0];
                gmAccount.config.datatableInventory.rows().deselect();
                gmAccount.config.datatableInventory.ajax.reload();
            }
        });
    },
    clickAddAccount: function () {
        gmAccount.ajaxModal(
                gmAccount.config.idFormAddAccount,
                gmAccount.config.ajaxAccount,
                'POST',
                function (data) {
                    if (data.success) {
                        gmAccount.config.datatableAccount.ajax.reload();
                    } else {
                        alert(data.message);
                    }
                }
        );
    },
    clickDelAccount: function () {
        if (confirm("Wirklich löschen?")) {
            gmAccount.ajaxRequest(gmAccount.config.ajaxAccount + '/' + $(this).data('id'), 'DELETE', {}, function (data) {
                if (data.success) {
                    gmAccount.config.datatableAccount.ajax.reload();
                } else {
                    alert(data.message);
                }
            });
        }
    },
    clickEditAccount: function () {
        gmAccount.ajaxRequest(gmAccount.config.ajaxAccount + '/' + $(this).data('id'), 'GET', {}, function (data) {
            if (data.success) {
                $(gmAccount.config.idFormEditAccount).find('.ui.form')[0].reset();
                $(gmAccount.config.idFormEditAccount + '_password').val('');
                $(gmAccount.config.idFormEditAccount + '_id').val(data.data.id);
                $(gmAccount.config.idFormEditAccount + '_mail').val(data.data.mail);
                $(gmAccount.config.idFormEditAccount + '_active').val(data.data.active);
                $(gmAccount.config.idFormEditAccount + '_gm').val(data.data.gm);

                gmAccount.ajaxModal(gmAccount.config.idFormEditAccount, gmAccount.config.ajaxAccount + '/' + data.data.id, 'POST', function (data) {
                    if (data.success) {
                        gmAccount.config.datatableAccount.ajax.reload();
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