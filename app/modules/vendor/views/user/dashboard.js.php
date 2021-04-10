<script>
    var Ajax = function () {
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
                    $('#issue_template').prop('selectedIndex', 0);
                });
                $('input[type="checkbox"][name="agree"]').on('click', function () {
                    var id = $(this).prop("checked");
                    if (id == true) {
                        $('#sbmt_form').fadeIn();
                    } else {
                        $('#sbmt_form').fadeOut();
                    }
                });
                var table = $('#ticket_dttable').DataTable({
                    "lengthMenu": [[10, 25, 50], [10, 25, 50]],
                    'createdRow': function (row, data, dataIndex) {
                        $(row).addClass('expiry-row');
                        $(row).addClass('style_no_' + data.create_def);
                        $(row).attr('title', data.create_def_text);
                    },
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
                        url: base_url + 'vendor/ticket/get_list/',
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
                        {"data": "status"},
                        {"data": "create"},
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