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
                        url: base_backend_url + 'prefferences/login_notification/get_list/',
                        type: 'POST'
                    },
                    "columns": [
                        {"data": "rowcheck"},
                        {"data": "num"},
                        {"data": "name"},
                        {"data": "content_summary"},
                        {"data": "content_full"},
                        {"data": "active"},
                        {"data": "description"}
                    ],
                    "drawCallback": function (master) {
                        $('.make-switch').bootstrapSwitch();
                    }
                });

                $('#datatable_ajax').on('switchChange.bootstrapSwitch', 'input[name="status"]', function (event, state) {
                    var id = $(this).attr('data-id');
                    var formdata = {
                        id: Base64.encode(id),
                        active: state
                    };
                    $.ajax({
                        url: base_backend_url + 'prefferences/login_notification/update_status/',
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

                $('a.btn').on('click', function () {
                    var action = $(this).attr('data-id');
                    var count = $('input.select_tr:checkbox').filter(':checked').length;
                    switch (action) {
                        case 'add':
                            $('.modal-title').html('Insert New Login_notification');
                            break;

                        case 'edit':
                            $('.modal-title').html('Update Exist Login_notification');
                            var status_ = $(this).hasClass('disabled');
                            var id = $('input.select_tr:checkbox:checked').attr('data-id');
                            if (status_ == 0) {
                                var formdata = {
                                    id: Base64.encode(id)
                                };
                                $.ajax({
                                    url: base_backend_url + 'prefferences/login_notification/get_data/',
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
                                        $('input[name="color"]').val(row.color);
                                        $('input[name="content_summary"]').val(row.content_summary);
                                        $('textarea[name="content_full"]').val(row.content_full);
                                        $('textarea[name="description"]').val(row.description);
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
                                var uri = base_backend_url + 'prefferences/login_notification/delete/';
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
                    var is_active = $("[name='mdl_status']").bootstrapSwitch('state');
                    var uri = base_backend_url + 'prefferences/login_notification/insert/';
                    var txt = 'add new login notif';
                    var formdata = {
                        name: $('input[name="name"]').val(),
                        color: $('input[name="color"]').val(),
                        content_summary: $('input[name="content_summary"]').val(),
                        content_full: $('textarea[name="content_full"]').val(),
                        description: $('textarea[name="description"]').val(),
                        active: is_active
                    };
                    if (id) {
                        uri = base_backend_url + 'prefferences/login_notification/update/';
                        txt = 'update login notif';
                        formdata = {
                            id: Base64.encode(id),
                            name: $('input[name="name"]').val(),
                            color: $('input[name="color"]').val(),
                            content_summary: $('input[name="content_summary"]').val(),
                            content_full: $('textarea[name="content_full"]').val(),
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

                $('#content_summary').on('keyup', function () {
                    var myText = $(this).val();
                    var i = 30;
                    if (myText.length <= i) {
                        var j = i - myText.length;
                        $('.words').html('Maksimal Karakter ' + j);
                    }
                });
            }
        };
    }();
    jQuery(document).ready(function () {
        Ajax.init();
    });
</script>