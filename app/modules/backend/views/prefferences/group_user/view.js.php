<script>
    var fnGetGroup = function () {
        $.ajax({
            url: base_backend_url + 'prefferences/group_user/get_group/',
            method: "POST", //First change type to method here
            success: function (response) {
                $('#group').html(response);
            },
            error: function (response) {
                $('#group').html(response);
            }
        });
        return false;
    };

    var fnGetUser = function () {
        $.ajax({
            url: base_backend_url + 'prefferences/group_user/get_user/',
            method: "POST", //First change type to method here
            success: function (response) {
                $('#user').html(response);
            },
            error: function (response) {
                $('#user').html(response);
            }
        });
        return false;
    };

    var Ajax = function () {
        return {
            //main function to initiate the module
            init: function () {
                $('a.btn').on('click', function (e) {
                    e.preventDefault();
                    var value = $(this).attr('data-id');
                    if (value == "add" || value == "edit") {
                        fnGetUser();
                        fnGetGroup();
                    }
                });
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
                        url: base_backend_url + 'prefferences/group_user/get_list/',
                        type: 'POST'
                    },
                    "columns": [
                        {"data": "rowcheck"},
                        {"data": "num"},
                        {"data": "username"},
                        {"data": "email"},
                        {"data": "group"},
                        {"data": "active"}
                    ],
                    "drawCallback": function (prefferences) {
                        $('.make-switch').bootstrapSwitch();
                    }
                });

                $('#datatable_ajax').on('switchChange.bootstrapSwitch', 'input[name="status"]', function (event, state) {
                    bootbox.confirm("Are you sure?", function (result) {
                        if (result == false) {
                            $('.modal-backdrop').hide();
                            $('.bootbox ').hide();
                            return false;
                        }
                        var id = $(this).attr('data-id');
                        var formdata = {
                            active: state
                        };
                        $.ajax({
                            url: base_backend_url + 'prefferences/group_user/update_status/' + Base64.encode(id),
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
                            $('.modal-title').html('Insert New User group');
                            break;

                        case 'edit':
                            $('.modal-title').html('Update Exist User group');
                            var status_ = $(this).hasClass('disabled');
                            var id = $('input.select_tr:checkbox:checked').attr('data-id');
                            if (status_ == 0) {
                                var formdata = {
                                    id: Base64.encode(id)
                                };
                                $.ajax({
                                    url: base_backend_url + 'prefferences/group_user/get_data/',
                                    method: "POST", //First change type to method here
                                    data: formdata,
                                    success: function (response) {
                                        var row = JSON.parse(response);
                                        var status_ = false;
                                        if (row.is_active == 1) {
                                            status_ = true;
                                        }
                                        $('input[name="id"]').val(row.id);
                                        $('#group').val(row.group_id);
                                        $('#user').val(row.user_id);
                                        $("[name='status']").bootstrapSwitch('state', status_);
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
                                var uri = base_backend_url + 'prefferences/group_user/delete/';
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
                    var uri = base_backend_url + 'prefferences/group_user/insert/';
                    var txt = 'add new group_user';
                    var formdata = {
                        user: $('#user').val(),
                        group: $('#group').val(),
                        active: is_active
                    };
                    if (id) {
                        uri = base_backend_url + 'prefferences/group_user/update/';
                        txt = 'update group_user';
                        formdata = {
                            id: Base64.encode(id),
                            user: $('#user').val(),
                            group: $('#group').val(),
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
                            fnRefreshDataTable();
                            fnResetBtn();
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