<script>
    $(".modal").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var target = $(this).attr('id');
        var id = button.data('id');
        App.startPageLoading();
        switch (target) {
            case 'modal_detail':
                fnGetDetail(id);
                break;
        }
        App.stopPageLoading();
    });
    var fnGetDetail = function (id) {
        var formdata = {
            ticket_id: (id)
        };
        $.ajax({
            url: base_monitor_url + 'tickets/get_ticket_detail/',
            method: "POST",
            data: formdata,
            beforeSend: function () {
                // Statement
                App.startPageLoading();
            },
            success: function (data) {
                var row = JSON.parse(data);
                var status_ = false;
                if (row.is_active == 1) {
                    status_ = true;
                }
                $('input[name="create_date_modal_detail_ticket"]').val(row.create_date);
                $('input[name="code_modal_detail_ticket"]').val(row.code);
                $('input[name="ticket_status_modal_detail_ticket"]').val(row.ticket_status);
                $('input[name="category_name_modal_detail_ticket"]').val(row.category['name_ina']);
                $('input[name="job_category_name_modal_detail_ticket"]').val(row.job['name']);
                $('textarea[name="content_modal_detail_ticket"]').val(row.content);
                $('input[name="problem_impact_modal_detail_ticket"]').val(row.problem_impact);
                $('input[name="create_by_name_detail_ticket"]').val(row.create_by_name);
                $('input[name="recreate_by_name_detail_ticket"]').val(row.recreate_by);
                if (row.branch_id == 0) {
                    $('input[name="branch_name_modal_detail_ticket"]').val("IMI");
                } else {
                    $('input[name="branch_name_modal_detail_ticket"]').val(row.branch['name']);
                }
                if (row.ticket_status == 'transfer') {
                    $('.modal-title').html('This ticket transfer from <b>' + row.ticket_transfer.user_from_name + '</b> to <b>' + row.ticket_transfer.user_to_name + '</b>');
                } else {
                    $('.modal-title').html((row.handle_by != null) ? 'Tiket ditangani oleh <b>' + row.handle_by + '</b>' : 'Tiket ini <b>belum ditangani oleh siapa pun.</b>');
                }
                if (row.files) {
                    var files = row.files;
                    var vl_arr = [];
                    for (i = 0; i < files.length; i++) {
                        vl_arr += '<div class="col-md-2" style="margin-bottom:2px; width:18%;"><div class="dashboard-stat blue"><img style="width:100%" src="' + static_url + 'tickets/' + files[i]['path'] + '" /><a class="more f_attachment" data-toggle="modal" href="#file_attach_mdl" data-path="' + files[i]['path'] + '"  data-id="' + row.id + '" data-code="' + row.code + '" href="javascript:;"> LIHAT DETAIL <i class="m-icon-swapright m-icon-white"></i></a></div></div>';
                    }
                    $('#img_attach').html(vl_arr);
                }
                if (row.ticket_status == 'open' || row.ticket_status == 'close' || row.ticket_status == 'progress' || row.ticket_status == 'transfer') {
                    if (row.ticket_status == 'open') {
                        $('#history').hide();
                        $('#history_chat').hide();
                    } else {
                        var style = '';
                        if (row.history_chat) {
                            var history_chat = row.history_chat;
                            var vl_arr2 = [];
                            for (var i = 0; i < history_chat.length; i++) {
                                if (history_chat[i]['reply_to'] == Base64.decode(user_id)) {
                                    style = '#d57b6c';
                                } else if (history_chat[i]['created_by'] == Base64.decode(user_id)) {
                                    style = '#28acb8';
                                } else if (history_chat[i]['reply_to'] != Base64.decode(user_id) && history_chat[i]['created_by'] != Base64.decode(user_id)) {
                                    style = '#f5f6fa';
                                }
                                vl_arr2 = vl_arr2 + '<div class="todo-tasklist-item todo-tasklist-item-border-green" style="border-left: ' + style + ' 4px solid;"><div class="todo-tasklist-item-title"><span class="todo-tasklist-badge badge badge-roundless"> ' + history_chat[i]['username'] + ' </span></div><div class="todo-tasklist-item-text">' + history_chat[i]['messages'] + '</div><div class="todo-tasklist-controls pull-left"><span class="todo-tasklist-date"><i class="fa fa-calendar"></i>' + row.create_date + '</span></div></div>';
                            }
                            $('.history_chat').show();
                            $('.history_chat').html(vl_arr2);
                            $('.history_chat').css('z-index', 99999);
                        }
                    }
                    if (row.history_ticket) {
                        var history_ticket = row.history_ticket;
                        var vl_arr3 = [];
                        for (i = 0; i < history_ticket.length; i++) {
                            vl_arr3 += '<div class="portlet-body"> <div class="timeline"><div class="timeline-item"><div class="timeline-badge"><div class="timeline-icon"></div></div><div class="timeline-body" ><div class="timeline-body-arrow"></div><div class="timeline-body-head"><div class="timeline-body-head-caption"><span class="timeline-body-time font-grey-cascade">' + row.history_ticket[i].create_date + '</span></div></div><hr style="  border-bottom: 2px solid rgb(185, 179, 179); "><div class="timeline-body-content"> <span class="font-grey-cascade">' + history_ticket[i]['messages'] + '</span></div></div></div></div></div>';
                        }
                        $('.history_ticket').show();
                        $('.history_ticket').html(vl_arr3);
                        $('.history_ticket').css('z-index', 99999);
                    }
                } else {
                    $('#history').hide();
                    $('#history_chat').hide();
                    $('#history_ticket').hide();
                }
            },
            error: function (data) {
                console.log(data);
            },
            complete: function (data) {
                // Hide image container
                App.stopPageLoading();
            }
        });
        return false;
    };
    var Ajax = function () {
        return {
            //main function to initiate the module
            init: function () {
                $('#def').show();
                $('#trf').hide();
                $('#prog').hide();
                var table3 = $('#default').DataTable({
                    "lengthMenu": [[10, 25, 50], [10, 25, 50]],
                    'createdRow': function (row, data, dataIndex) {
                        $(row).addClass('expiry-row');
                        $(row).addClass('style_no_' + data.create_def);
                        $(row).attr('title', data.create_def_text);
                    },
                    "sPaginationType": "bootstrap",
                    "paging": true,
                    "pagingType": "full_numbers",
                    "ordering": false,
                    "serverSide": true,
                    "processing": true,
                    "language": {
                        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                    },
                    "ajax": {
                        url: base_monitor_url + 'tickets/get_list/' + key,
                        type: 'POST'
                    },
                    "columns": [
                        {"data": "num"},
                        {"data": "create_def"},
                        {"data": "code"},
                        {"data": "content"},
                        {"data": "category_name"},
                        {"data": "job_category_name"},
                        {"data": "branch_name"},
                        {"data": "status"},
                        {"data": "create"},
                        // {"data": "close_message"},
                        {"data": "action"}
                    ],
                    "drawCallback": function (master) {
                        $('.make-switch').bootstrapSwitch();
                    }
                });

                $('#global_search').on('keyup', function () {
                    if ($(".table")[0]) {
                        table.search(this.value).draw();
                    }
                });

                $('a.btn').on('click', function () {
                    var action = $(this).attr('data-id');
                    var count = $('input.select_tr:checkbox').filter(':checked').length;
                    console.log(action);
                    switch (action) {
                        case 'add':
                            $('.modal-title').html('Insert New Master');
                            break;

                        case 'edit':
                            $('.modal-title').html('Update Exist Master');
                            var status_ = $(this).hasClass('disabled');
                            var id = $('input.select_tr:checkbox:checked').attr('data-id');
                            if (status_ == 0) {
                                var formdata = {
                                    id: Base64.encode(id)
                                };
                                $.ajax({
                                    url: base_monitor_url + 'tickets/get_data/',
                                    method: "POST", //First change type to method here
                                    data: formdata,
                                    success: function (response) {
                                        var row = JSON.parse(response);
                                        var status_ = false;
                                        if (row.is_active == 1) {
                                            status_ = true;
                                        }
                                        $('input[name="id"]').val(row.id);
                                        $('input[name="name"]').val(row.name);
                                        $("[name='status']").bootstrapSwitch('state', status_);
                                        $('textarea[name="description"]').val(row.description);
                                        $('#modal_add_edit').modal('show');
                                    },
                                    error: function () {
                                        fnToStr('Error is occured, please contact administrator.', 'error');
                                    }
                                });
                                return false;
                            }
                            break;

                        case 'delete':
                            bootbox.confirm("Are you sure to delete this id?", function (result) {
                                if (result == false) {
                                    $('.modal-backdrop').hide();
                                    $('.bootbox ').hide();
                                    return false;
                                }
                                var uri = base_monitor_url + 'tickets/delete/';
                                id = [];
                                $("input.select_tr:checkbox:checked").each(function () {
                                    id.push($(this).data("id"));
                                });
                                fnAjaxPost(uri, {id: id}, 'delete');
                                fnRefreshDataTable();
                                fnResetBtn();
                            });
                            break;

                        case 'refresh':
                            fnRefreshDataTable();
                            break;
                    }
                });

                $("#add_edit").submit(function () {
                    var id = $('input[name="id"]').val();
                    var is_active = $("[name='status']").bootstrapSwitch('state');
                    var uri = base_monitor_url + 'tickets/insert/';
                    var txt = 'add new group';
                    var formdata = {
                        name: $('input[name="name"]').val(),
                        description: $('textarea[name="description"]').val(),
                        active: is_active
                    };
                    if (id) {
                        uri = base_monitor_url + 'tickets/update/';
                        txt = 'update group';
                        formdata = {
                            id: Base64.encode(id),
                            name: $('input[name="name"]').val(),
                            description: $('textarea[name="description"]').val(),
                            active: is_active
                        };
                    }
                    $.ajax({
                        url: uri,
                        method: "POST", //First change type to method here
                        data: formdata,
                        success: function (response) {
                            toastr.success('Successfully ' + txt);
                            fnCloseModal();
                        },
                        error: function () {
                            toastr.error('Failed ' + txt);
                            fnCloseModal();
                        }

                    });
                    return false;
                });
            }
        };
    }();

    jQuery(document).ready(function () {
        Ajax.init();
    });
</script>