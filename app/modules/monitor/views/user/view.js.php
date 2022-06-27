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
                        url: base_monitor_url + 'user/get_list/',
                        type: 'POST'
                    },
                    "columns": [
                        {"data": "num"},
                        {"data": "nik"},
                        {"data": "name"},
                        {"data": "email"},
                        {"data": "phone_number"},
                        {"data": "branch_code"},
                        {"data": "branch_name"},
                        {"data": "active"}
                    ],
                    "drawCallback": function (master) {
                        $('.make-switch').bootstrapSwitch();
                    }
                });
                $('#opt_refresh').on('click', function (event, state) {
                    var action = $(this).attr('data-id');
                    switch (action) {
                        case 'refresh':
                            fnRefreshDataTable();
                            break;
                    }
                });
            }
        };
    }();

    jQuery(document).ready(function () {
        Ajax.init();
    });
</script>