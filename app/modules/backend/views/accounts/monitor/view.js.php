<script>
    var Ajax = function () {
        return {
            //main function to initiate the module
            init: function () {
                var table = $('#datatable_ajax').DataTable({
                    "lengthMenu": [[10, 25, 50], [10, 25, 50]],
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
                        url: base_backend_url + 'accounts/monitor/get_list/',
                        type: 'POST'
                    },
                    "columns": [
                        {"data": "rowcheck"},
                        {"data": "num"},
                        {"data": "nik"},
                        {"data": "name"},
                        {"data": "email"},
                        {"data": "phone_number"},
                        {"data": "branch_code"},
                        {"data": "branch_name"},
                        {"data": "active"}
                    ],
                    "drawCallback": function (master) {
                        $('.make-switch').bootstrapSwitch();
                    }
                });

                $('#datatable_ajax').on('switchChange.bootstrapSwitch', 'input[name="status"]', function (event, state) {
                    bootbox.confirm("Are you sure?", function (result) {
                        var id = $(this).attr('data-id');
                        var formdata = {
                            id: Base64.encode(id),
                            active: state
                        };
                        $.ajax({
                            url: base_backend_url + 'accounts/monitor/update_status/',
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
                });

                $('a.btn').on('click', function () {
                    var action = $(this).attr('data-id');
                    var count = $('input.select_tr:checkbox').filter(':checked').length;
                    switch (action) {
                        case 'add':
                            $('.modal-title').html('Insert New Employee');
                            break;

                        case 'edit':
                            $('.modal-title').html('Update Exist Employee');
                            var status_ = $(this).hasClass('disabled');
                            var id = $('input.select_tr:checkbox:checked').attr('data-id');
                            if (status_ == 0) {
                                var formdata = {
                                    id: Base64.encode(id)
                                };
                                $.ajax({
                                    url: base_backend_url + 'accounts/monitor/get_data/',
                                    method: "POST", //First change type to method here
                                    data: formdata,
                                    success: function (response) {
                                        var row = JSON.parse(response);
                                        var status_ = false;
                                        if (row.is_active == 1) {
                                            status_ = true;
                                        }
                                        $('input[name="id"]').val(row.id);
                                        $('input[name="user_id"]').val(row.user_id);
                                        $('input[name="nik"]').val(row.nik);
                                        $('input[name="username"]').val(row.name);
                                        $('input[name="fname"]').val(row.first_name);
                                        $('input[name="lname"]').val(row.last_name);
                                        $('input[name="email"]').val(row.email);
                                        $('input[name="phone"]').val(row.phone_number);
                                        $('#branch').val(row.branch_id);
                                        $("[name='status']").bootstrapSwitch('state', status_);
                                        $('textarea[name="description"]').val(row.description);
                                        $('#modal_add_edit').modal('show');
                                        $('input[name="email"]').attr('readonly', true);
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
                                if (result == true) {
                                    var uri = base_backend_url + 'accounts/monitor/delete/';
                                    id = [];
                                    $("input.select_tr:checkbox:checked").each(function () {
                                        id.push($(this).data("id"));
                                    });
                                    fnAjaxPost(uri, {id: id}, 'remove');
                                    fnRefreshDataTable();
                                    fnResetBtn();
                                } else {
                                    fnToStr('You re cancelling delete this id', 'info');
                                    fnRefreshDataTable();
                                    fnResetBtn();
                                }
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
                    var uri = base_backend_url + 'accounts/monitor/insert/';
                    var txt = 'add new employee';
                    var formdata = {
                        nik: $('input[name="nik"]').val(),
                        username: $('input[name="username"]').val(),
                        first_name: $('input[name="fname"]').val(),
                        last_name: $('input[name="lname"]').val(),
                        email: $('input[name="email"]').val(),
                        password: $('input[name="password"]').val(),
                        phone_number: $('input[name="phone"]').val(),
                        branch: $('#branch').val(),
                        group: 4,
                        active: is_active
                    };
                    if (id) {
                        uri = base_backend_url + 'accounts/monitor/update/';
                        txt = 'update employee';
                        formdata = {
                            id: Base64.encode(id),
                            user_id: $('input[name="user_id"]').val(),
                            nik: $('input[name="nik"]').val(),
                            username: $('input[name="username"]').val(),
                            first_name: $('input[name="fname"]').val(),
                            last_name: $('input[name="lname"]').val(),
                            password: $('input[name="password"]').val(),
                            phone_number: $('input[name="phone"]').val(),
                            branch: $('#branch').val(),
                            active: is_active
                        };
                    }
                    $.ajax({
                        url: uri,
                        method: "POST", //First change type to method here
                        data: formdata,
                        success: function (response) {
                            fnToStr('Successfully ' + txt,'success');
                            fnCloseModal();
                            fnRefreshDataTable();
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