<script>
    var Ajax = function () {
        return {
            //main function to initiate the module
            init: function () {
                var table = $('#ticket_dttable').DataTable({
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
                        url: base_url + 'helpdesk/ticket/get_list',
                        type: 'POST'
                    },
                    "columns": [
                        {"data": "num"},
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
                $('#global_search').on('keyup', function () {
                    if ($(".table")[0]) {
                        table.search(this.value).draw();
                    }
                });

                $('#global_search').on('keyup keypress', function (e) {
                    var keyCode = e.keyCode || e.which;
                    if (keyCode === 13) {
                        e.preventDefault();
                        return false;
                    }
                });
            }
        };

    }();

    jQuery(document).ready(function () {
        Ajax.init();
    });

</script>
