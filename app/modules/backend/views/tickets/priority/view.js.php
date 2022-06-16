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
                        url: base_backend_url + 'tickets/priority/get_list/',
                        type: 'POST'
                    },
                    "columns": [
                        {"data": "rowcheck"},
                        {"data": "num"},
                        {"data": "name"},
                        {"data": "active"},
                        {"data": "description"}
                    ],
                    "drawCallback": function (master) {
                        $('.make-switch').bootstrapSwitch();
                    }
                });

                $('#datatable_ajax').on('switchChange.bootstrapSwitch', 'input[name="priority"]', function (event, state) {
                    var id = $(this).attr('data-id');
                    var formdata = {
                        active: state
                    };
                    $.ajax({
                        url: base_backend_url + 'tickets/priority/update_status/' + Base64.encode(id),
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
                            $('.modal-title').html('Insert New Ticket Status');
                            break;

                        case 'edit':
                            $('.modal-title').html('Update Exist Ticket Status');
                            var status_ = $(this).hasClass('disabled');
                            var id = $('input.select_tr:checkbox:checked').attr('data-id');
                            if (status_ == 0) {
                                var formdata = {
                                    id: Base64.encode(id)
                                };
                                $.ajax({
                                    url: base_backend_url + 'tickets/priority/get_data/',
                                    method: "POST", //First change type to method here
                                    data: formdata,
                                    success: function (response) {
                                        if (response) {
                                            var row = JSON.parse(response);
                                            var status_ = false;
                                            if (row.is_active == 1) {
                                                status_ = true;
                                            }
                                            $('input[name="id"]').val(row.id);
                                            $('input[name="name"]').val(row.name);
                                            $("[name='status_frm']").bootstrapSwitch('state', status_);
                                            $('textarea[name="description"]').val(row.description);
                                            $('.modal').modal('show');
                                        }
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
                                var uri = base_backend_url + 'tickets/priority/delete/';
                                id = [];
                                $("input.select_tr:checkbox:checked").each(function () {
                                    id.push($(this).data("id"));
                                });
                                var frmdata = {
                                    id: id
                                };
                                fnAjaxPost(uri, frmdata, 'delete');
                                fnResetBtn();
                            });
                            break;

                        case 'refresh':
                            fnRefreshDataTable();
                            fnResetBtn();
                            break;
                    }
                });
                $("#add_edit").submit(function () {
                    var id = $('input[name="id"]').val();
                    var is_active = $("[name='status_frm']").bootstrapSwitch('state');
                    var uri = base_backend_url + 'tickets/priority/insert/';
                    var txt = 'add new priority';
                    var formdata = {
                        name: $('input[name="name"]').val(),
                        description: $('textarea[name="description"]').val(),
                        active: is_active
                    };
                    if (id) {
                        uri = base_backend_url + 'tickets/priority/update/';
                        txt = 'update priority';
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