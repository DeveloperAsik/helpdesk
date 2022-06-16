<script>
    var fnValidateForm = function () {
        var el = '#add_edit';
        $(el).validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                nik: {
                    required: true
                },
                username: {
                    required: true
                }
            },
            invalidHandler: function (event, validator) {
                $('.alert-danger', $(el)).show();
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = errors == 1 ? 'You missed 1 field. It has been highlighted' : 'You missed ' + errors + ' fields. They have been highlighted';
                    $(".alert-danger span").html(message);
                    $(".alert-danger").show();
                } else {
                    $(".alert-danger").hide();
                }
            },
            highlight: function (element) {
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element.closest('.input-icon'));
            }
        });
        $(el).keypress(function (e) {
            return 13 == e.which ? ($(el).validate().form() && $(el).submit(), !1) : void 0
        });
    };

    var Ajax = function () {
        return {
            //main function to initiate the module
            init: function () {
                var table = $('.table').DataTable({
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
                        url: base_backend_url + 'accounts/admin/get_list/',
                        type: 'POST'
                    },
                    "columns": [
                        {"data": "rowcheck"},
                        {"data": "num"},
                        {"data": "nik"},
                        {"data": "username"},
                        {"data": "first_name"},
                        {"data": "last_name"},
                        {"data": "email"},
                        {"data": "group_name"},
                        {"data": "active"}
                    ],
                    "drawCallback": function (master) {
                        $('.make-switch').bootstrapSwitch();
                    }
                });

                $('.table').on('switchChange.bootstrapSwitch', 'input[name="status"]', function (event, state) {
                    bootbox.confirm("Are you sure?", function (result) {
                        if (result == false) {
                            $('.modal-backdrop').hide();
                            $('.bootbox ').hide();
                            return false;
                        }
                        var id = $(this).attr('data-id');
                        var formdata = {
                            id: Base64.encode(id),
                            active: state
                        };
                        $.ajax({
                            url: base_backend_url + 'accounts/admin/update_status/',
                            method: "POST",
                            data: formdata,
                            success: function (response) {
                                toastr.success('Successfully ' + response);
                                return false;
                            },
                            error: function (response) {
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
                            $('.modal-title').html('Insert New Admin');
                            $("#add_edit")[0].reset();
                            break;

                        case 'edit':
                            $('.modal-title').html('Update Exist Admin');
                            var status_ = $(this).hasClass('disabled');
                            var id = $('input.select_tr:checkbox:checked').attr('data-id');
                            if (status_ == 0) {
                                var formdata = {
                                    id: Base64.encode(id)
                                };
                                $.ajax({
                                    url: base_backend_url + 'accounts/admin/get_data/',
                                    method: "POST",
                                    data: formdata,
                                    success: function (response) {
                                        var row = JSON.parse(response);
                                        var status_ = false;
                                        if (row.is_active == 1) {
                                            status_ = true;
                                        }
                                        $('input[name="id"]').val(row.id);
                                        $('input[name="nik"]').val(row.nik);
                                        $('input[name="username"]').val(row.username);
                                        $('input[name="first_name"]').val(row.first_name);
                                        $('input[name="last_name"]').val(row.last_name);
                                        $('input[name="email"]').val(row.email);
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
                                if (result == true) {
                                    var uri = base_backend_url + 'accounts/admin/delete/';
                                    id = [];
                                    $("input.select_tr:checkbox:checked").each(function () {
                                        id.push($(this).data("id"));
                                    });
                                    fnAjaxPost(uri, {id: id}, 'delete');
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

                $("#add_edit").submit(function (e) {
                    e.preventDefault();
                    var id = $('input[name="id"]').val();
                    var is_active = $("[name='status']").bootstrapSwitch('state');
                    var uri = base_backend_url + 'accounts/admin/insert/';
                    var txt = 'add new group';
                    var pass = '-';
                    if ($('input[name="password"]').val()) {
                        pass = Base64.encode($('input[name="password"]').val());
                    }
                    var formdata = {
                        nik: $('input[name="nik"]').val(),
                        username: $('input[name="username"]').val(),
                        first_name: $('input[name="first_name"]').val(),
                        last_name: $('input[name="last_name"]').val(),
                        password: pass,
                        email: $('input[name="email"]').val(),
                        active: is_active
                    };
                    if (id) {
                        uri = base_backend_url + 'accounts/admin/update/';
                        txt = 'update group';
                        formdata = {
                            id: Base64.encode(id),
                            nik: $('input[name="nik"]').val(),
                            username: $('input[name="username"]').val(),
                            first_name: $('input[name="first_name"]').val(),
                            last_name: $('input[name="last_name"]').val(),
                            email: $('input[name="email"]').val(),
                            active: is_active
                        };
                    }
                    fnValidateForm();
                    $.ajax({
                        url: uri,
                        method: "POST", //First change type to method here
                        data: formdata,
                        success: function (response) {
                            fnToStr('Successfully ' + txt, 'success');
                            fnCloseModal();
                            fnRefreshDataTable();
                        },
                        error: function () {
                            fnToStr('Failed ' + txt, 'error');
                            fnCloseModal();
                            fnRefreshDataTable();
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