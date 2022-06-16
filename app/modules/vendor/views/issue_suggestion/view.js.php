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
                    "ajax": {
                        url: base_url + 'vendor/issue_suggestion/get_list/',
                        type: 'POST'
                    },
                    "columns": [
                        {"data": "rowcheck"},
                        {"data": "num"},
                        {"data": "value_eng"},
                        {"data": "value_ina"},
                        {"data": "active"},
                        {"data": "description"}
                    ],
                    "drawCallback": function (master) {
                        $('.make-switch').bootstrapSwitch();
                        $('.select_tr').iCheck({
                            checkboxClass: 'icheckbox_minimal-grey',
                            radioClass: 'iradio_minimal-grey'
                        });
                    }
                });

                $('#datatable_ajax').on('switchChange.bootstrapSwitch', 'input[name="status"]', function (event, state) {
                    console.log(state); // true | false
                    var id = $(this).attr('data-id');
                    var formdata = {
                        id: Base64.encode(id),
                        active: state
                    };
                    $.ajax({
                        url: base_url + 'vendor/issue_suggestion/update_status/',
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

                $("#opt_edit").on('click', function () {
                    var status_ = $(this).hasClass('disabled');
                    if (status_ == 0) {
                        var id = $("input[class='select_tr']:checked").attr("data-id");
                        $.post(base_url + 'vendor/issue_suggestion/get_data/' + id, function (data) {
                            var row = JSON.parse(data);
                            var status_ = false;
                            if (row.is_active == 1) {
                                status_ = true;
                            }
                            $('input[name="id"]').val(row.id);
                            $("[name='status']").bootstrapSwitch('state', status_);
                            $('textarea[name="value_eng"]').val(row.value_eng);
                            $('textarea[name="value_ina"]').val(row.value_ina);
                            $('textarea[name="description"]').val(row.description);
                        });
                    }
                });

                $("#opt_delete").on('click', function () {
                    var status_ = $(this).hasClass('disabled');
                    if (status_ == 0) {
                        bootbox.confirm("Are you sure to delete this id?", function (result) {
                            if (result == true) {
                                var id = $("input[class='select_tr']:checked").attr("data-id");
                                var formdata = {
                                    id: Base64.encode(id)
                                };
                                $.ajax({
                                    url: base_url + 'vendor/issue_suggestion/delete/',
                                    method: "POST", //First change type to method here
                                    data: formdata,
                                    success: function (response) {
                                        toastr.success('Successfully ' + response);
                                        fnCloseBootbox();
                                        fnCloseModal();
                                    },
                                    error: function () {
                                        toastr.error('Failed ' + response);
                                        fnCloseBootbox();
                                        fnCloseModal();
                                    }

                                });
                            } else {
                                toastr.success('Cancelling delete data ');
                                fnCloseBootbox();
                                fnCloseModal();
                                return false;
                            }
                        });

                    } else {
                        toastr.success('Something went wrong ');
                        fnCloseBootbox();
                        fnCloseModal();
                        return false;
                    }
                });

                $("#sbmt_form").on('click', function () {
                    var id = $('input[name="id"]').val();
                    var is_active = $("[name='status']").bootstrapSwitch('state');
                    var uri = base_url + 'vendor/issue_suggestion/insert/';
                    var txt = 'add new group';
                    var formdata = {
                        value_eng: $('textarea[name="value_eng"]').val(),
                        value_ina: $('textarea[name="value_ina"]').val(),
                        description: $('textarea[name="description"]').val(),
                        active: is_active
                    };
                    if (id) {
                        uri = base_url + 'vendor/issue_suggestion/update/';
                        txt = 'update issue suggestion';
                        formdata = {
                            id: Base64.encode(id),
                            value_eng: $('textarea[name="value_eng"]').val(),
                            value_ina: $('textarea[name="value_ina"]').val(),
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