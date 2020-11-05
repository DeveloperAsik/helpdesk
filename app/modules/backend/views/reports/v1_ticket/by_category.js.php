<script>
    var getDate = function (element) {
        var date;
        try {
            date = $.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
            date = null;
        }
        return date;
    };

    var fnReset = function () {
        $("#report_btn_table")[0].reset();
    };

    var fnSetDownloadPDF = function (frmdata) {
        $.ajax({
            url: base_backend_url + 'reports/v1_ticket/gen_to_pdf',
            type: "POST",
            data: frmdata,
            success: function (data) {
                console.log(data);
            },
            error: function (data) {
                console.log('error');
            }
        });
        return false;
    };

    var Ajax = function () {
        return {
            //main function to initiate the module
            init: function () {
                var dateFormat = "mm/dd/yy",
                        from = $("#from")
                        .datepicker({
                            defaultDate: "+1w",
                            changeMonth: true,
                            numberOfMonths: 1
                        })
                        .on("change", function () {
                            to.datepicker("option", "minDate", getDate(this));
                        }),
                        to = $("#to").datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1
                }).on("change", function () {
                    from.datepicker("option", "maxDate", getDate(this));
                });

                $('#ticket_category').on('change', function () {
                    App.startPageLoading();
                    var id = $(this).val();
                    var uri = base_backend_url + 'reports/v1_ticket/get_category_select/';
                    var formdata = {
                        id: Base64.encode(id)
                    };
                    $.ajax({
                        url: uri,
                        type: "post",
                        data: formdata,
                        success: function (response) {
                            App.stopPageLoading();
                            if (response) {
                                $('#problem_subject').html(response);
                            }
                            return false;
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            App.stopPageLoading();
                            console.log(textStatus, errorThrown);
                            return false;
                        }
                    });
                    return false;
                });

                $("#report_btn_table").submit(function () {
                    var from_date = $('#from').val();
                    var to_date = $('#to').val();
                    var ticket_status = $('#ticket_status').val();
                    var ticket_category = $('#ticket_category').val();
                    var problem_subject = $('#problem_subject').val();
                    var formdata = {
                        from_date: from_date,
                        to_date: to_date,
                        ticket_status: ticket_status,
                        ticket_category: ticket_category,
                        problem_subject: problem_subject
                    };
                    $('#datatable_ajax').fadeIn();
                    var table = $('#datatable_ajax').DataTable({
                        "bDestroy": true,
                        "dom": 'Blfrtip',
                        "buttons": [
                            {
                                title: export_file_name,
                                extend: 'print',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                title: export_file_name,
                                // messageTop: 'Ticket Report',
                                extend: 'pdf',
                                orientation: 'landscape',
                                pageSize: 'LEGAL',
                                customize: function (doc) {
                                    doc.content[1].margin = [-10, 0, 0, 0];
                                }, //left, top, right, bottom 
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
//                            {
//                                title: export_file_name,
//                                messageTop: 'Ticket Report',
//                                extend: 'pdf',
//                                exportOptions: {
//                                    columns: ':visible'
//                                }
//                                action: function () {
//                                    fnSetDownloadPDF(formdata);
//                                }
//                            },
                            {
                                title: export_file_name,
                                messageTop: 'Ticket Report',
                                extend: 'excelHtml5',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: 'colvis',
                                collectionLayout: 'fixed two-column'
                            }
                        ],
                        "columnDefs": [{
                                targets: [4, 6, 8],
                                visible: false
                            }],
                        "lengthMenu": [[25, 50, 100, 200, 400, 800, 1000], [25, 50, 100, 200, 400, 800, 1000]],
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
                            url: base_backend_url + 'reports/v1_ticket/get_list/',
                            type: 'POST',
                            data: {
                                "param1": {
                                    "from_date": from_date,
                                    "to_date": to_date,
                                    "ticket_status": ticket_status,
                                    "ticket_category": ticket_category,
                                    "problem_subject": problem_subject
                                }
                            }
                        },
                        "columns": [
                            {"data": "num"},
                            {"data": "code"},
                            {"data": "category_name"},
                            {"data": "priority"},
                            {"data": "content"},
                            {"data": "respon_note"},
                            {"data": "create_by"},
                            {"data": "respon_by"},
                            {"data": "create_tgl"},
                            {"data": "create_time"},
                            {"data": "respon_date"},
                            {"data": "respon_time"},
                            {"data": "closing_date"},
                            {"data": "closing_time"},
                            {"data": "status"}
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