<script>
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
            url: base_backend_url + 'tickets/master/get_list/',
            type: 'POST'
        },
        "columns": [
            {"data": "rowcheck"},
            {"data": "num"},
            {"data": "code"},
            {"data": "content"},
            {"data": "status"},
            {"data": "active"},
            {"data": "description"},
            {"data": "action"}
        ],
        "drawCallback": function (master) {
            $('.make-switch').bootstrapSwitch();
        }
    });

    var fnAutoLoadMessage = function () {
        $.ajaxSetup({cache: false});
        var uri = base_backend_url + 'tickets/master/get_content/';
        var formdata = {
            ticket_id: Base64.encode(ticket_id)
        };
        App.startPageLoading();
        setInterval(function () {
            $.ajax({
                url: uri,
                type: "post",
                data: formdata,
                success: function (response) {
                    App.stopPageLoading();
                    $('.timeline').html(response);
                    return false;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    App.stopPageLoading();
                    console.log(textStatus, errorThrown);
                    return false;
                }
            });
        }, 5000);
    };

    var fnLoadDetailTicket = function () {
        var uri = base_backend_url + 'tickets/master/get_ticket_detail/';
        var formdata = {
            ticket_id: Base64.encode(ticket_id)
        };
        App.startPageLoading();
        $.ajax({
            url: uri,
            type: "post",
            data: formdata,
            success: function (response) {
                var row = JSON.parse(response);
                $('input[name="ticket_id"]').val(row.id);
                $('input[name="create_date"]').val(row.create_date);
                $('input[name="code"]').val(row.code);
                $('input[name="ticket_status"]').val(row.ticket_status);
                $('input[name="job_id"]').val(row.job_id);
                $('input[name="problem_impact"]').val(row.problem_impact);
                $('input[name="create_by"]').val(row.create_by_name);
                $('input[name="category_name"]').val(row.category['name']);
                $('input[name="job_category"]').val(row.job['name']);
                $('textarea[name="content"]').val(row.content);
                $('textarea[name="description"]').val(row.description);

                $('input[name="ticket_code"]').val(row.code);
                $('input[name="ticket_id_close_ticket"]').val(row.id);
                $('input[name="ticket_id_modal_transfer_open"]').val(row.id);
                App.stopPageLoading();
                return false;
            },
            error: function (jqXHR, textStatus, errorThrown) {
                App.stopPageLoading();
                console.log(textStatus, errorThrown);
                return false;
            }
        });
    };

    var sendFile = function (file, that) {
        var data = new FormData();
        data.append('file', file);
        $.ajax({
            data: data,
            type: 'post',
            url: base_backend_url + 'tickets/master/insert_image_summernote',
            cache: false,
            contentType: false,
            processData: false,
            success: function (url) {
                $(that).summernote('insertImage', url, '');
            }
        });
    };

    var index = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnAutoLoadMessage();
                fnLoadDetailTicket();
                if(ticket_creator_id){
                    if(ticket_creator == username){
                        $('#req_to_transfer').hide();
                    }else{
                        $('#req_to_transfer').show();
                    }
                }
                if (ticket_status) {
                    if (ticket_status == 'close' || ticket_status == 'transfer') {
                        $('.modal-backdrop').hide();
                        $('.modal').hide();
                        $('#message').attr('disabled', 'disabled');
                        $('#req_to_close').attr('disabled', 'disabled');
                        $('#sbmt_message').attr('disabled', 'disabled');
                        if (ticket_status == 'transfer') {
                            $('span.ticket_code_sp').html('(<small><b>' + code + '</b></small>)');
                            $('#modal_transfer_open').modal('show');
                            if (ticket_id) {
                                $('input[name="ticket_id_modal_transfer_open"]').val(ticket_id);
                            }
                        }
                    } else {
                        if (ticket_status != 'open' || ticket_status != 'progress') {
                            $('#modal_transfer_open').modal('hide');
                            $('#modal_transfer_open').hide();
                        }
                    }
                }

                $('#message').summernote({
                    onImageUpload: function (files) {
                        that = $(this);
                        sendFile(files[0], that);
                    },
                    popover: {
                        image: [
                            ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                            ['float', ['floatLeft', 'floatRight', 'floatNone']],
                            ['custom', ['imageAttributes', 'imageShape']],
                            ['remove', ['removeMedia']]
                        ]
                    },
                    toolbar: [
                        ['insert', ['link', 'picture']]
                    ],
                    lang: 'zh-CN',
                    minHeight: 300,
                    dialogsFade: true, // Add fade effect on dialogs
                    dialogsInBody: true, // Dialogs can be placed in body, not in
                    disableDragAndDrop: false
                });
                
                $('#sbmt_message_chat').on('click', function (e) {
                    var uri = base_backend_url + 'tickets/master/insert_message';
                    var formdata = {
                        ticket_id: Base64.encode(ticket_id),
                        ticket_code: code,
                        message: $('textarea[name="message"]').val()
                    };
                    if(formdata.message == ''){
                        fnToStr('Isi pesan terlebih dahulu!!!', 'warning', 2000);
                        return false;
                    }
                    App.startPageLoading();
                    $.ajax({
                        url: uri,
                        type: "post",
                        data: formdata,
                        success: function (response) {
                            App.stopPageLoading();
                            fnAutoLoadMessage();
                            $('#message').code('');
                            return false;
                        }
                    });
                    e.preventDefault();
                });
            }
        };
    }();

    jQuery(document).ready(function () {
        index.init();
    });
</script>
