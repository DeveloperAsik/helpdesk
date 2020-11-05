<script>
    var fnReset = function () {
        $("#report_btn_table")[0].reset();
    };

    var Ajax = function () {
        return {
            //main function to initiate the module
            init: function () {
                $("#report_btn_table").submit(function () {
                    var code = $('#code').val();
                    $('#datatable_ajax').fadeIn();

                    var table = $('#datatable_ajax').DataTable({
                        "bDestroy": true,
                        "columnDefs": [{
                                targets: [1, 9],
                                visible: false
                            }],
                        "lengthMenu": [[10, 25, 50], [10, 25, 50]],
                        "sPaginationType": "bootstrap",
                        "paging": true,
                        "pagingType": "full_numbers",
                        "ordering": true,
                        "serverSide": true,
                        "processing": true,
                        "language": {
                            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                        },
                        "ajax": {
                            url: base_backend_url + 'reports/v1_ticket/get_list/',
                            type: 'POST',
                            data: {
                                "param3": {
                                    "code": code
                                }
                            }
                        },
                        "columns": [
                            {"data": "num"},
                            {"data": "code"},
                            {"data": "category_name"},
                            {"data": "tag"},
                            {"data": "priority"},
                            {"data": "content"},
                            {"data": "create_by"},
                            {"data": "respon_by"},
                            {"data": "create"},
                            {"data": "status"},
                            {"data": "action"}
                        ],
                        "drawCallback": function () {
                            $('.make-switch').bootstrapSwitch();
                        }
                    });
                    return false;
                });

                $('#cancel').on('click', function () {
                    fnReset();
                });
            }
        };
    }();
    jQuery(document).ready(function () {
        Ajax.init();
    });
</script>