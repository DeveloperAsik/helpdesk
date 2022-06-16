<script>
    var tbl_1 = function (id) {
        if (id == 1) {
            var table = $('#data_vendor').DataTable({
                "bDestroy": true,
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
                    url: base_backend_url + 'accounts/vendor/get_list/',
                    type: 'POST'
                },
                "columns": [
                    {"data": "rowcheck"},
                    {"data": "num"},
                    {"data": "name"},
                    {"data": "phone_number"},
                    {"data": "fax"},
                    {"data": "email"},
                    {"data": "active"}
                ],
                "drawCallback": function () {
                    $('.make-switch').bootstrapSwitch();
                }
            });
        } else {
            var table = $('#data_vendor_user').DataTable({
                "bDestroy": true,
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
                    url: base_backend_url + 'accounts/vendor/get_vendor_user_list/',
                    type: 'POST'
                },
                "columns": [
                    {"data": "rowcheck"},
                    {"data": "num"},
                    {"data": "nik"},
                    {"data": "username"},
                    {"data": "vendor_code"},
                    {"data": "vendor_name"},
                    {"data": "email"},
                    {"data": "group_name"},
                    {"data": "active"}
                ],
                "drawCallback": function () {
                    $('.make-switch').bootstrapSwitch();
                }
            });
        }
    };

    var Ajax = function () {
        return {
            //main function to initiate the module
            init: function () {
                $('table.display').dataTable();
                tbl_1(1);
                $('#download_sample').on('click', function () {
                    var filename = $(this).data('filename');
                    var filetype = $(this).data('filetype');
                    window.location = base_backend_url + 'accounts/vendor/download_sample/' + filename + '/' + filetype;
                });
                $('a').on('click', function () {
                    var toggle = $(this).data('toggle');
                    var href = $(this).attr('href');
                    var id = $(this).data('id');
                    if (toggle && toggle == 'tab') {
                        if (href == '#tab_reversed_1_2') {
                            tbl_1(2);
                        }
                    }
                    var count = $('input.select_tr_vndr_:checkbox').filter(':checked').length;
                    if (id == 'add' || id == 'edit') {
                        var ref_this = $("ul.nav li.active a").attr('href');
                        if (ref_this == '#tab_reversed_1_1') {
                            if (id == 'edit') {
                                vndr_id = $('input.select_tr_vndr_:checkbox:checked').attr('data-id');
                                var formdata = {
                                    vndr_id: Base64.encode(vndr_id)
                                };
                                $.ajax({
                                    url: base_backend_url + 'accounts/vendor/get_data/',
                                    method: "POST", //First change type to method here
                                    data: formdata,
                                    success: function (response) {
                                        var row = JSON.parse(response);
                                        var status_ = false;
                                        if (row.is_active == 1) {
                                            status_ = true;
                                        }
                                        $('input[name="id"]').val(row.id);
                                        $('input[name="vndr_code"]').val(row.code);
                                        $('input[name="vndr_name"]').val(row.name);
                                        $('input[name="vndr_email"]').val(row.email);
                                        $('input[name="vndr_phone"]').val(row.phone_number);
                                        $('input[name="vndr_fax"]').val(row.fax);
                                        $('textarea[name="vndr_address"]').val(row.address);
                                        $('textarea[name="vndr_description"]').val(row.description);
                                        $("[name='status_vndr_frm']").bootstrapSwitch('state', status_);
                                        $('#modal_add_edit').modal('show');
                                    },
                                    error: function () {
                                        fnToStr('Error is occured, please contact administrator.', 'error');
                                    }
                                });
                            }
                            if (id == 'add') {
                                $('#title_frm_vendor_mdl').html("Tambah data vendor");
                            } else {
                                $('#title_frm_vendor_mdl').html("Ubah data vendor");
                            }
                            $('#modal_add_edit_vendor').modal('show');
                            $('#modal_add_edit_vendor_user').modal('hide');
                        } else if (ref_this == '#tab_reversed_1_2') {
                            var vndr_user_id = $('input.select_tr_usr_:checkbox:checked').attr('data-id');
                            if (id == 'add') {
                                $('#title_frm_vendor_user_mdl').html("Tambah data pengguna dari vendor");
                            } else {
                                $('#title_frm_vendor_user_mdl').html("Ubah data pengguna dari vendor");
                            }
                            $.ajax({
                                url: base_backend_url + 'accounts/vendor/get_vendors/',
                                method: "POST", //First change type to method here
                                success: function (response) {
                                    $('#vendor_list').html(response);
                                },
                                error: function () {
                                    fnToStr('Error is occured, please contact administrator.', 'error');
                                }
                            });
                            if (id == 'edit') {
                                var formdata = {
                                    vndr_user_id: Base64.encode(vndr_user_id)
                                };
                                $.ajax({
                                    url: base_backend_url + 'accounts/vendor/get_data_vendor_user/',
                                    method: "POST", //First change type to method here
                                    data: formdata,
                                    success: function (response) {
                                        var row = JSON.parse(response);
                                        var status_ = false;
                                        if (row.is_active == 1) {
                                            status_ = true;
                                        }
                                        //$('#div_password').fadeOut();
                                        // $('#div_user_group').fadeOut();
                                        //$('#div_vendor').fadeOut();
                                        $('input[name="id"]').val(row.id);
                                        $('input[name="user_id"]').val(row.user_id);
                                        $('input[name="nik"]').val(row.nik);
                                        $('input[name="user_name"]').val(row.username);
                                        $('input[name="first_name"]').val(row.first_name);
                                        $('input[name="last_name"]').val(row.last_name);
                                        $('input[name="email"]').val(row.email);
                                        $('input[name="phone"]').val(row.phone_number);
                                        $("[name='status']").bootstrapSwitch('state', status_);
                                        $("select#vendor_list").val(row.vendor_id).change();
                                    },
                                    error: function () {
                                        fnToStr('Error is occured, please contact administrator.', 'error');
                                    }
                                });
                            }
                            $('#modal_add_edit_vendor').modal('hide');
                            $('#modal_add_edit_vendor_user').modal('show');
                        }
                    } else if (id == 'delete') {
                        bootbox.confirm("Are you sure to delete this id?", function (result) {
                            if (result == true) {
                                var ref_this = $("ul.nav li.active a").attr('href');
                                if (ref_this == '#tab_reversed_1_1') {
                                    var uri = base_backend_url + 'accounts/vendor/delete/';
                                } else if (ref_this == '#tab_reversed_1_2') {
                                    uri = base_backend_url + 'accounts/vendor/delete_user/';
                                }
                                var vndr_user_id = [];
                                $("input.select_tr_usr_:checkbox:checked").each(function () {
                                    vndr_user_id.push($(this).data("id"));
                                });
                                fnAjaxPost(uri, {id: vndr_user_id}, 'delete');
                                $(".table").DataTable().ajax.reload();
                                fnResetBtn();
                            } else {
                                fnToStr('You re cancelling delete this id', 'info');
                                $(".table").DataTable().ajax.reload();
                                fnResetBtn();
                            }
                        });
                    }
                });

                $('.md-check').on('click', function () {
                    var id_vndr = $(this).hasClass('select_all_vndr_');
                    var id_vndr_user = $(this).hasClass('select_all_usr_');
                    var is_checked = $(this).is(':checked');
                    if (id_vndr == true) {
                        if (is_checked == true) {
                            $('.select_tr_vndr_').prop('checked', true);
                        } else {
                            $('.select_tr_vndr_').prop('checked', false);
                        }
                    } else {
                        fnResetBtn();
                    }
                    if (id_vndr_user == true) {
                        if (is_checked == true) {
                            $('.select_tr_usr_').prop('checked', true);
                        } else {
                            $('.select_tr_usr_').prop('checked', false);
                        }
                    } else {
                        fnResetBtn();
                    }
                });

                $(".modal").on("hide.bs.modal", function (event) {
                    $('input[type="checkbox"]').prop('checked', false);
                });

                $('#tab_reversed_1_2').on('click', '.select_tr_usr_', function () {
                    var is_checked = $(this).is(':checked');
                    var id = $(this).attr('data-id');
                    if (is_checked == true) {
                        var count = $('input.select_tr').filter(':checked').length;
                        if (id) {
                            $('input[name="frm_vendor_user_id"]').val(id);
                        }
                        if (count > 1) {
                            $("#opt_delete").show();
                            $("#opt_remove").show();
                            $("#opt_add").hide();
                            $("#opt_edit").hide();
                        } else {
                            $("#opt_delete").show();
                            $("#opt_remove").show();
                            $("#opt_add").hide();
                            $("#opt_edit").show();
                        }
                    } else {
                        $("#opt_delete").hide();
                        $("#opt_remove").show();
                        $("#opt_add").show();
                        $("#opt_edit").hide();

                        fnResetBtn();
                    }
                });

                $('#tab_reversed_1_1').on('click', '.select_tr_vndr_', function () {
                    var is_checked = $(this).is(':checked');
                    var id = $(this).attr('data-id');
                    if (is_checked == true) {
                        var count = $('input.select_tr').filter(':checked').length;
                        if (id) {
                            $('input[name="frm_vendor_id"]').val(id);
                        }
                        if (count > 1) {
                            $("#opt_delete").show();
                            $("#opt_remove").show();
                            $("#opt_add").hide();
                            $("#opt_edit").hide();
                        } else {
                            $("#opt_delete").show();
                            $("#opt_remove").show();
                            $("#opt_add").hide();
                            $("#opt_edit").show();
                        }
                    } else {
                        $("#opt_delete").hide();
                        $("#opt_remove").show();
                        $("#opt_add").show();
                        $("#opt_edit").hide();

                        fnResetBtn();
                    }
                });

                $("#frmVendor").submit(function (e) {
                    e.preventDefault();
                    var is_active = $("[name='status']").bootstrapSwitch('state');
                    var id = Base64.encode($('input[name="frm_vendor_id"]').val());
                    var is_active = $("[name='status_vndr_frm']").bootstrapSwitch('state');
                    var uri = base_backend_url + 'accounts/vendor/insert_vendor/';
                    var pass = $('input=[name="password"]').val();
                    var formdata = {
                        code: $('input[name="vndr_code"]').val(),
                        name: $('input[name="vndr_name"]').val(),
                        email: $('input[name="vndr_email"]').val(),
                        phone: $('input[name="vndr_phone"]').val(),
                        fax: $('input[name="vndr_fax"]').val(),
                        address: $('textarea[name="vndr_address"]').val(),
                        description: $('textarea[name="vndr_description"]').val(),
                        active: is_active
                    };
                    if (id) {
                        uri = base_backend_url + 'accounts/vendor/update_vendor/';
                        formdata = {
                            id: id,
                            code: $('input[name="vndr_code"]').val(),
                            name: $('input[name="vndr_name"]').val(),
                            email: $('input[name="vndr_email"]').val(),
                            phone: $('input[name="vndr_phone"]').val(),
                            fax: $('input[name="vndr_fax"]').val(),
                            address: $('textarea[name="vndr_address"]').val(),
                            description: $('textarea[name="vndr_description"]').val(),
                            active: is_active
                        };
                    }
                    $.ajax({
                        url: uri,
                        method: "POST", //First change type to method here
                        data: formdata,
                        success: function (response) {
                            fnToStr('Successfully', 'success');
                            fnCloseModal();
                            fnResetBtn();
                            $(".table").DataTable().ajax.reload();
                        },
                        error: function () {
                            fnToStr('Failed', 'error');
                            fnCloseModal();
                            fnResetBtn();
                            $(".table").DataTable().ajax.reload();
                        }
                    });
                    return false;
                });
                $("#frmVendorUser").submit(function (e) {
                    e.preventDefault();
                    var id = Base64.encode($('input[name="frm_vendor_user_id"]').val());
                    var user_id = Base64.encode($('input[name="frm_vendor_user_user_id"]').val());
                    var is_active = $("[name='status']").bootstrapSwitch('state');
                    var uri = base_backend_url + 'accounts/vendor/insert_user/';
                    var pass = [];
                    if ($('input[name="password"]').val()) {
                        pass = $('input[name="password"]').val();
                    }
                    var formdata = {
                        nik: $('input[name="nik"]').val(),
                        username: $('input[name="user_name"]').val(),
                        first_name: $('input[name="first_name"]').val(),
                        last_name: $('input[name="last_name"]').val(),
                        password: pass,
                        email: $('input[name="email"]').val(),
                        phone: $('input[name="phone"]').val(),
                        group: 3,
                        vendor: $('#vendor_list').val(),
                        active: is_active
                    };
                    if (id) {
                        uri = base_backend_url + 'accounts/vendor/update_user/';
                        formdata = {
                            id: id,
                            user_id: user_id,
                            nik: $('input[name="nik"]').val(),
                            username: $('input[name="user_name"]').val(),
                            first_name: $('input[name="first_name"]').val(),
                            last_name: $('input[name="last_name"]').val(),
                            password: pass,
                            email: $('input[name="email"]').val(),
                            phone: $('input[name="phone"]').val(),
                            vendor: $('#vendor_list').val(),
                            active: is_active
                        };
                    }
                    $.ajax({
                        url: uri,
                        method: "POST", //First change type to method here
                        data: formdata,
                        success: function (response) {
                            fnToStr('Successfully', 'success');
                            fnCloseModal();
                            fnResetBtn();
                            $(".table").DataTable().ajax.reload();
                        },
                        error: function () {
                            fnToStr('Failed', 'error');
                            fnCloseModal();
                            fnResetBtn();
                            $(".table").DataTable().ajax.reload();
                        }
                    });
                    return false;
                });

                $('#import_file_vendor').on('submit', function (e) {
                    e.preventDefault();
                    var form = $(this);
                    var formData = new FormData(form[0]);
                    var uri = base_backend_url + 'accounts/vendor/import_file/';
                    $.ajax({
                        url: uri,
                        method: "POST", //First change type to method here
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            fnToStr('Successfully ', 'success');
                            fnCloseModal();
                            $("#import_file_vendor")[0].reset();
                            return false;
                        },
                        error: function (response) {
                            fnToStr('Failed ', 'error');
                            fnCloseModal();
                            return false;
                        }
                    });
                });
            }
        };

    }();

    jQuery(document).ready(function () {
        Ajax.init();
    });
</script>