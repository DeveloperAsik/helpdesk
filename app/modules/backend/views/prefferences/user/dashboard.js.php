<script>
    var Ajax = function () {
        return {
            //main function to initiate the module
            init: function () {
                var table = $('#ticket_dttable').DataTable({
                    "lengthMenu": [[10, 25, 50], [10, 25, 50]],
                    'createdRow': function( row, data, dataIndex ) {
                        $(row).addClass( 'expiry-row' );
                        $(row).addClass( 'style_no_' + data.create_def );   
                        $(row).attr( 'title', data.create_def_text );                               
                    },
                    "sPaginationType": "bootstrap",
                    "paging": true,
                    "pagingType": "full_numbers",
                    "ordering": false,
                    "processing": true,
                    "language": {
                        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                    },
                    "serverSide": true,
                    "ajax": {
                        url: base_backend_url + 'tickets/master/get_list/',
                        type: 'POST'
                    },
                    "columns": [
                        {"data": "num"},
                        {"data": "create_def"},
                        {"data": "code"},
                        {"data": "content"},
                        {"data": "category_name"},
                        {"data": "priority_name"},
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

                $('table.table').on('click', 'td button.set_priority', function () {
                    var vl = $(this).data('id');
                    var id = $(this).data('ticket');
                    bootbox.confirm("Are you sure to set this ticket priority to?", function (result) {
                        if (result == false) {
                            $('.modal-backdrop').hide();
                            $('.bootbox ').hide();
                            return false;
                        }
                        var uri = base_backend_url + 'tickets/master/set_priority/';
                        var formdata = {
                            id: (id),
                            v: vl
                        };
                        $.ajax({
                            url: uri,
                            type: "post",
                            data: formdata,
                            success: function (response) {
                                App.stopPageLoading();
                                fnRefreshDataTable();
                                return false;
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                App.stopPageLoading();
                                console.log(textStatus, errorThrown);
                                return false;
                            }
                        });
                    });
                });

                $('#global_search').on('keyup', function () {
                    if ($(".table")[0]) {
                        table.search(this.value).draw();
                    }
                });

                $('#global_search').on('keyup keypress', function(e) {
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
