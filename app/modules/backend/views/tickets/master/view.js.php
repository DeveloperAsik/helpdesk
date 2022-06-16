<script>
    var Ajax = function () {
        return {
            //main function to initiate the module
            init: function () {
                if (key) {
                    if (key == 'transfer') {
                        $('#trf').show();
                        $('#def').hide();
                        var table = $('#transfer').DataTable({
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
                                url: base_backend_url + 'tickets/master/get_list/' + key,
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

                        var table2 = $('#transfer_in').DataTable({
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
                                url: base_backend_url + 'tickets/master/get_list/transfer_in',
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

                        var table3 = $('#transfer_out').DataTable({
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
                                url: base_backend_url + 'tickets/master/get_list/transfer_out',
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
                    } else if (key == 'progress') {
                        $('#prog').show();
                        $('#def').hide();
                        $('#trf').hide();

                        var table4 = $('#prog_def').DataTable({
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
                                url: base_backend_url + 'tickets/master/get_list/progress',
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
                                {"data": "create"},
                                {"data": "status"},
                                // {"data": "close_message"},
                                {"data": "action"}
                            ],
                            "drawCallback": function (master) {
                                $('.make-switch').bootstrapSwitch();
                            }
                        });

                        var table5 = $('#prog_reopen').DataTable({
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
                                url: base_backend_url + 'tickets/master/get_list/progress_reopen',
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
                                {"data": "create"},
                                {"data": "status"},
                                // {"data": "close_message"},
                                {"data": "action"}
                            ],
                            "drawCallback": function (master) {
                                $('.make-switch').bootstrapSwitch();
                            }
                        });
                    } else {
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
                                url: base_backend_url + 'tickets/master/get_list/' + key,
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
                    }
                }

                $('#datatable_ajax').on('switchChange.bootstrapSwitch', 'input[name="status"]', function (event, state) {
                    var id = $(this).attr('data-id');
                    var formdata = {
                        id: Base64.encode(id),
                        active: state
                    };
                    $.ajax({
                        url: base_backend_url + 'tickets/master/update_status/',
                        method: "POST", //First change type to method here
                        data: formdata,
                        success: function (response) {
                            toastr.success('Successfully ' + response);
                            return false;
                        },
                        error: function () {
                            toastr.error('Failed ' + response);
                            return false;
                        }

                    });
                });

                $('#global_search').on('keyup', function () {
                    if ($(".table")[0]) {
                        table.search(this.value).draw();
                    }
                });

                $('a.btn').on('click', function () {
                    var action = $(this).attr('data-id');
                    var count = $('input.select_tr:checkbox').filter(':checked').length;
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
                                    url: base_backend_url + 'tickets/master/get_data/',
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
                                var uri = base_backend_url + 'tickets/master/delete/';
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
                $("#frm_request_close_ticket").submit(function () {
                    var id = $('input[name="id"]').val();
                    var is_active = $("[name='status']").bootstrapSwitch('state');
                    var uri = base_backend_url + 'tickets/master/insert/';
                    var txt = 'add new group';
                    var formdata = {
                        name: $('input[name="name"]').val(),
                        description: $('textarea[name="description"]').val(),
                        active: is_active
                    };
                    if (id) {
                        uri = base_backend_url + 'tickets/master/update/';
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
                $("#add_edit").submit(function () {
                    var id = $('input[name="id"]').val();
                    var is_active = $("[name='status']").bootstrapSwitch('state');
                    var uri = base_backend_url + 'tickets/master/insert/';
                    var txt = 'add new group';
                    var formdata = {
                        name: $('input[name="name"]').val(),
                        description: $('textarea[name="description"]').val(),
                        active: is_active
                    };
                    if (id) {
                        uri = base_backend_url + 'tickets/master/update/';
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