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
    var fnForceDownload = function (link) {
        var myForm = '<form id="myForm" method="GET" action = "' + link + '" > ';
        myForm += '<input type="hidden" name="data1" type="hidden" value = "JSON.stringify() data" > ';
        myForm += '</form>';
        $("body").append(myForm); // temporarily appending 
        $("#myData-form").submit(); // submitting form with data
        $("#myData-form").remove(); // remove form after submit
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
                    // alert('test');
                    App.startPageLoading();
                    var id = $(this).val();
                    var uri = base_url + 'vendor/report/ticket/get_category';
                    var formdata = {
                        id: Base64.encode(id)
                    };
                    console.log(formdata);
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
                    if (from_date == '' && to_date == '' && ticket_status == '0' && ticket_category == '0' && problem_subject) {
                        fnToStr('Silahkan pilih parameter pencarian terlebih dahulu', 'warning', 2000);
                        return false;
                    }
                    $('#datatable_ajax').fadeIn();
                    var table = $('#datatable_ajax').DataTable({
                        "bDestroy": true,
                        "dom": 'Bfrtip',
                        "buttons": [
                            {
                                title: export_file_name,
                                text: 'PDF',
                                action: function () {
                                    $.ajax({
                                        url: base_url + 'vendor/report/ticket/gen_to_pdf',
                                        type: "POST",
                                        data: {
                                            "param1": {
                                                "from_date": from_date,
                                                "to_date": to_date,
                                                "ticket_status": ticket_status,
                                                "ticket_category": ticket_category,
                                                "problem_subject": problem_subject
                                            }
                                        },
                                        success: function (data) {
                                            window.open(data, '_blank');
                                        },
                                        error: function (data) {
                                            console.log('error');
                                        }
                                    });
                                }
                            },
                            {
                                title: export_file_name,
                                messageTop: 'Ticket Report',
                                extend: 'excel',
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
                                targets: [-1, 7, 8, 9, 10, 11, 12, 14, 15, 16, 17, 18, 19, 20, 21, 22],
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
                            url: base_url + 'vendor/report/ticket/get_list/',
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
                            {"data": "category"},
                            {"data": "sub_category"},
                            {"data": "priority"},
                            {"data": "content"},
                            {"data": "status"},
                            {"data": "response"},
                            {"data": "vendor"},
                            {"data": "closing"},
                            {"data": "kanim"},
                            {"data": "creator"},
                            {"data": "contact"},
                            {"data": "open_date"},
                            {"data": "open_time"},
                            {"data": "response_date"},
                            {"data": "response_time"},
                            {"data": "closing_date"},
                            {"data": "closing_time"},
                            {"data": "total_response"},
                            {"data": "total_solving"},
                            {"data": "job"},
                            {"data": "status_ticket"},
                            {"data": "active"}
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