<script>
    var fnAutoLoadMessage = function () {
        App.startPageLoading();
        var uri = base_url + 'support/tracking/get_content/';
        var formdata = {
            ticket_id: Base64.encode(ticket_id)
        };
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
        App.stopPageLoading();
    };

    var fnLoadDetailTicket = function () {
        var uri = base_url + 'support/tracking/get_ticket_detail/';
        var formdata = {
            ticket_id: Base64.encode(ticket_id)
        };
        $.ajax({
            url: uri,
            type: "post",
            data: formdata,
            success: function (response) {
                var row = JSON.parse(response);
                $('input[name="create_date"]').val(row.create_date);
                $('input[name="code"]').val(row.code);
                $('input[name="ticketid"]').val(row.id);
                $('input[name="ticket_status"]').val(row.ticket_status);
                $('input[name="problem_impact"]').val(row.problem_impact);
                $('input[name="job_id"]').val(row.job_id);
                $('textarea[name="content"]').val(row.content);
                $('textarea[name="description"]').val(row.description);
                $('.chat_grup').html('Dibuat oleh <b>' + row.chats.creator + '</b>');
                $('.handle_by').html('Tiket ini ditangani oleh <b>' + row.handle_by + '</b>');
                return false;
            },
            error: function (jqXHR, textStatus, errorThrown) {
                App.stopPageLoading();
                console.log(textStatus, errorThrown);
                return false;
            }
        });
    };

    var index = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnLoadDetailTicket();
                var init = false;
                if (init == false) {
                    fnAutoLoadMessage();
                    init = true;
                }
                if (init == true) {
                    setInterval(function () {
                        setTimeout(function () {
                            fnAutoLoadMessage();
                        }, 7000);
                    }, 21000);
                }
                if (ticket_status) {
                    fnTicketAuth(ticket_status);
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

                $('.f_attachment').on('click', function () {
                    var id = $(this).data('id');
                    var path = static_url + 'tickets/' + $(this).data('path');
                    $('#media').html('<img style="width:100%; height:100%; margin:10px" src="' + path + '" />');
                });
                
                $('#message').summernote({
                    onImageUpload: function (files) {
                        that = $(this);
                        var frmdata = {
                            code: Base64.encode(code),
                            ticket_id: Base64.encode(ticket_id)
                        };
                        sendFile(files[0], that, frmdata);
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
                    disableDragAndDrop: false // default false You can disable drag and drop
                });
                
                $('#sbmt_message_chat').on('click', function (e) {
                    var uri = base_url + 'support/tracking/insert_message';
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
