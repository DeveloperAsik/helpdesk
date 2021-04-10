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
                        url: base_backend_url + 'tickets/rule/get_list/',
                        type: 'POST'
                    },
                    "columns": [
                        {"data": "rowcheck"},
                        {"data": "num"},
                        {"data": "title"},
                        {"data": "response_time"},
                        {"data": "solving_time"},
                        {"data": "fine_result"},
                        {"data": "active"}
                    ],
                    "drawCallback": function (master) {
                        $('.make-switch').bootstrapSwitch();
                    }
                });

                $('#datatable_ajax').on('switchChange.bootstrapSwitch', 'input[name="rule"]', function (event, state) {
                    console.log(state); // true | false
                    var id = $(this).attr('data-id');
                    var formdata = {
                        active: state
                    };
                    $.ajax({
                        url: base_backend_url + 'tickets/rule/update_status/' + Base64.encode(id),
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
                                    url: base_backend_url + 'tickets/rule/get_data/',
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
                                            $('input[name="title"]').val(row.title);
                                            $('input[name="response_time"]').val(row.response_time);
                                            $('input[name="solving_time"]').val(row.solving_time);
                                            $('input[name="fine_result"]').val(row.fine_result);
                                            document.getElementById("priority").selectedIndex = row.priority_id;
                                            $("[name='status_frm']").bootstrapSwitch('state', status_);
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
                                var uri = base_backend_url + 'tickets/rule/delete/';
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
                    var uri = base_backend_url + 'tickets/rule/insert/';
                    var txt = 'add new rule';
                    var formdata = {
                        title: $('input[name="title"]').val(),
                        response_time: $('input[name="response_time"]').val(),
                        solving_time: $('input[name="solving_time"]').val(),
                        fine_result: $('input[name="fine_result"]').val(),
                        priority_id: $('#priority').val(),
                        active: is_active
                    };
                    if (id) {
                        uri = base_backend_url + 'tickets/rule/update/';
                        txt = 'update rule';
                        formdata = {
                            id: Base64.encode(id),
                            title: $('input[name="title"]').val(),
                            response_time: $('input[name="response_time"]').val(),
                            solving_time: $('input[name="solving_time"]').val(),
                            fine_result: $('input[name="fine_result"]').val(),
                            priority_id: $('#priority').val(),
                            active: is_active
                        };
                    }
                    $.ajax({
                        url: uri,
                        method: "POST", //First change type to method here
                        data: formdata,
                        success: function (response) {
                            toastr.success('Successfully ' + txt);
                            fnRefreshDataTable();
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