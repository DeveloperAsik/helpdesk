<script>
    var handleSummernote = function () {
        $('#value').summernote({height: 300});
    };
    var handleDestroySummernote = function () {
        $('#value').destroy();
    };
    var Ajax = function () {
        return {
            //main function to initiate the module
            init: function () {
                $('.btn').on('click', function (e) {
                    e.preventDefault();
                    var value = $(this).attr('data-value');
                    if (value == "add" || value == "edit") {
                        handleSummernote();
                    } else if (value == "close") {
                        handleDestroySummernote();
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
                        url: base_backend_url + 'prefferences/email_layout/get_list/',
                        type: 'POST'
                    },
                    "columns": [
                        {"data": "rowcheck"},
                        {"data": "num"},
                        {"data": "keyword"},
                        {"data": "value_eng"},
                        {"data": "value_ind"},
                        {"data": "description"},
                        {"data": "active"}
                    ],
                    "drawCallback": function (master) {
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
                            url: base_backend_url + 'prefferences/email_layout/update_status/' + Base64.encode(id),
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

                $("#opt_edit").on('click', function () {
                    var status_ = $(this).hasClass('disabled');
                    if (status_ == 0) {
                        var id = $("input[class='select_tr']:checked").attr("data-id");
                        $.post(base_backend_url + 'prefferences/email_layout/get_data/' + id, function (data) {
                            var row = JSON.parse(data);
                            var status_ = false;
                            if (row.is_active == 1) {
                                status_ = true;
                            }
                            $('input[name="id"]').val(row.id);
                            $('input[name="keyword"]').val(row.keyword);
                            $('input[name="value"]').val(row.value);
                            $("[name='status']").bootstrapSwitch('state', status_);
                            $('textarea[name="description"]').val(row.description);
                        });
                    }
                });

                $("#opt_delete").on('click', function () {
                    var status_ = $(this).hasClass('disabled');
                    if (status_ == 0) {
                        bootbox.confirm("Are you sure?", function (result) {
                            if (result == false) {
                                $('.modal-backdrop').hide();
                                $('.bootbox ').hide();
                                return false;
                            }
                            var id = $("input[class='select_tr']:checked").attr("data-id");
                            var formdata = {
                                id: Base64.encode(id)
                            };
                            $.ajax({
                                url: base_backend_url + 'prefferences/email_layout/delete/' + Base64.encode(id),
                                method: "POST", //First change type to method here
                                data: formdata,
                                success: function (response) {
                                    fnToStr('Successfully ' + response, 'success', 1100);
                                    fnCloseBootbox();
                                },
                                error: function () {
                                    fnToStr('Failed ' + response, 'success', 1100);
                                    fnCloseBootbox();
                                }

                            });
                        });

                    } else {
                        toastr.success('Something went wrong ');
                        close_bootbox();
                        close_modal();
                        return false;
                    }
                });

                $("#add_edit").submit(function () {
                    bootbox.confirm("Are you sure?", function (result) {
                        if (result == false) {
                            $('.modal-backdrop').hide();
                            $('.bootbox ').hide();
                            return false;
                        }
                        var id = $('input[name="id"]').val();
                        var keyword = $('input[name="keyword"]').val();
                        var is_active = $("[name='status']").bootstrapSwitch('state');
                        var values = $('#value').summernote('code');
                        var uri = base_backend_url + 'prefferences/email_layout/insert/';
                        var txt = 'add new group';
                        var formdata = {
                            keyword: keyword,
                            values: values,
                            description: $('textarea[name="description"]').val(),
                            active: is_active
                        };
                        if (id)
                        {
                            uri = base_backend_url + 'prefferences/email_layout/update/';
                            txt = 'update group';
                            formdata = {
                                id: Base64.encode(id),
                                keyword: keyword,
                                values: values,
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
                                close_modal();
                            },
                            error: function () {
                                toastr.error('Failed ' + txt);
                                close_modal();
                            }
                        });
                        return false;
                    });
                });
            }
        };
    }();

    jQuery(document).ready(function () {
        Ajax.init();
    });
</script>