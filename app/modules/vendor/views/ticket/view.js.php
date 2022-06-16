<script>
    var index = function () {
        return {
            //main function to initiate the module
            init: function () {
                $('input[type="checkbox"][name="insert_by"]').on('click', function () {
                    var id = $(this).prop("checked");
                    if (id == true) {
                        $.post(base_url + 'vendor/user/get_issue_suggest/' + id, function (data) {
                            $('#issue_template').html(data);
                            $('#insert_from_temp').fadeIn();
                        });
                    } else {
                        $('#insert_from_temp').fadeOut();
                    }
                });
                $('#issue_template').on('change', function () {
                    var value = $(this).val();
                    $('textarea[name="message"]').val(value);
                });
                $('input[type="checkbox"][name="agree"]').on('click', function () {
                    var id = $(this).prop("checked");
                    if (id == true) {
                        $('#sbmt_form').fadeIn();
                    } else {
                        $('#sbmt_form').fadeOut();
                    }
                });
                if (key) {
                    if (key == 'transfer') {
                        $('#trf').show();
                        $('#def').hide();
                        $('#prog').hide();

                        var table2 = $('#trf_in').DataTable({
                            "lengthMenu": [[10, 25, 50], [10, 25, 50]],
                            'createdRow': function (row, data, dataIndex) {
                                $(row).addClass('expiry-row');
                                $(row).addClass('style_no_' + data.create_def);
                                $(row).attr('title', data.create_def_text);
                            },
                            "sPaginationType": "bootstrap",
                            "paging": true,
                            "retrieve": true,
                            "pagingType": "full_numbers",
                            "ordering": false,
                            "serverSide": true,
                            "processing": true,
                            "language": {
                                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                            },
                            "ajax": {
                                url: base_url + 'vendor/ticket/get_list/transfer_in',
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
                                {"data": "close_message"},
                                {"data": "action"}
                            ],
                            "drawCallback": function (master) {
                                $('.make-switch').bootstrapSwitch();
                            }
                        });
                        var table3 = $('#trf_out').DataTable({
                            "lengthMenu": [[10, 25, 50], [10, 25, 50]],
                            'createdRow': function (row, data, dataIndex) {
                                $(row).addClass('expiry-row');
                                $(row).addClass('style_no_' + data.create_def);
                                $(row).attr('title', data.create_def_text);
                            },
                            "sPaginationType": "bootstrap",
                            "paging": true,
                            "retrieve": true,
                            "pagingType": "full_numbers",
                            "ordering": false,
                            "serverSide": true,
                            "processing": true,
                            "language": {
                                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                            },
                            "ajax": {
                                url: base_url + 'vendor/ticket/get_list/transfer_out',
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
                                {"data": "close_message"},
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
                            "retrieve": true,
                            "pagingType": "full_numbers",
                            "ordering": false,
                            "serverSide": true,
                            "processing": true,
                            "language": {
                                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                            },
                            "ajax": {
                                url: base_url + 'vendor/ticket/get_list/progress',
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
                            "retrieve": true,
                            "pagingType": "full_numbers",
                            "ordering": false,
                            "serverSide": true,
                            "processing": true,
                            "language": {
                                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                            },
                            "ajax": {
                                url: base_url + 'vendor/ticket/get_list/progress_reopen',
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
                            "retrieve": true,
                            "pagingType": "full_numbers",
                            "ordering": false,
                            "serverSide": true,
                            "processing": true,
                            "language": {
                                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                            },
                            "ajax": {
                                url: base_url + 'vendor/ticket/get_list/' + key,
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
                    }
                }
                $('#global_search').on('keyup', function () {
                    if ($(".table")[0]) {
                        if (key) {
                            if (key == 'transfer') {
                                table2.search(this.value).draw();
                            } else if (key == 'progress') {
                                table4.search(this.value).draw();

                            } else {
                                table3.search(this.value).draw();
                            }
                        }
                    }
                });
            }
        };

    }();

    jQuery(document).ready(function () {
        index.init();
    });

</script>
