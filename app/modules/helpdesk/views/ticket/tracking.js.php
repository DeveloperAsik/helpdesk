<script>
    var fnAutoLoadMessage = function () {
        var uri = base_url + 'helpdesk/ticket/get_content/';
        var formdata = {
            ticket_id: Base64.encode(ticket_id)
        };
        App.startPageLoading();
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
    };

    var fnLoadDetailTicket = function () {
        var formdata = {
            id: Base64.encode(ticket_id)
        };
        $.ajax({
            url: base_url + 'ticket/get_ticket_detail/',
            type: "post",
            data: formdata,
            success: function (response) {
                var row = JSON.parse(response);
                $('input[name="create_date"]').val(row.create_date);
                $('input[name="code"]').val(row.code);
                $('input[name="ticket_status"]').val(row.ticket_status);
                $('input[name="problem_impact"]').val(row.problem_impact);
                $('input[name="category_name"]').val(row.category_name);
                $('input[name="job_category"]').val(row.sub_category);
                $('textarea[name="content"]').val(row.content);
                $('textarea[name="description"]').val(row.description);
                $('.chat_grup').html('Ditangani oleh <b>' + row.handle_by + '</b>');
                return false;
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
                return false;
            }
        });
    };

    var ajax = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnLoadDetailTicket();
                $.ajax({
                    url: fnAutoLoadMessage(),
                    success: function () {
                        setInterval(function () {
                            fnAutoLoadMessage();
                        }, 10000);
                    }
                });

                if (ticket_status) {
                    fnTicketAuth(ticket_status);
                    if (ticket_status == 'close') {
                        $('#message').attr('disabled', 'disabled');
                        $('#mark_as_solve').hide();
                        $('#close_ticket').hide();
                    } else if (ticket_status == 'open') {
                        $('#sbmt_message').attr('disabled', 'disabled');
                        $('#mark_as_solve').hide();
                        $('#message').attr('disabled', 'disabled');
                    } else {
                        $('#mark_as_solve').show();
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
                    disableDragAndDrop: false, // default false You can disable drag and drop					
                });

                $('.f_attachment').on('click', function () {
                    var id = $(this).data('id');
                    var path = static_url + 'tickets/' + $(this).data('path');
                    $('#media').html('<img style="width:100%; height:100%; margin:10px" src="' + path + '" />');
                });

                $('#close_ticket').on('click', function () {
                    var disabled = $(this).attr('disabled');
                    if (disabled) {
                        return false;
                    }
                    var uri = base_url + 'ticket/close_status';
                    var formdata = {
                        ticket_id: Base64.encode($('input[name="ticket_id"]').val())
                    };
                    bootbox.confirm("Apakah anda yakin?", function (result) {
                        if (result == false) {
                            $('.modal-backdrop').hide();
                            $('.bootbox ').hide();
                            return false;
                        }
                        $.ajax({
                            url: uri,
                            type: "post",
                            data: formdata,
                            success: function (response) {
                                App.stopPageLoading();
                                console.log(response);return false;
                                var dialog = bootbox.dialog({
                                    message: "Redirect me to",
                                    title: "Redirecting page",
                                    buttons: {
                                        success: {
                                            label: "Ticket Tracking!",
                                            className: "green",
                                            callback: function () {
                                                window.location.href = base_url + 'helpdesk/ticket/tracking/' + Base64.encode(code);
                                            }
                                        },
                                        danger: {
                                            label: "Ticket List",
                                            className: "grey",
                                            callback: function () {
                                                window.location.href = base_url + 'helpdesk/ticket/view/close';
                                            }
                                        },
                                        main: {
                                            label: "Create New Ticket",
                                            className: "blue",
                                            callback: function () {
                                                window.location.href = base_url + 'helpdesk/ticket/create';
                                            }
                                        }
                                    }
                                });
                                dialog.init(function () {
                                    var counter = 0;
                                    var max = 3;
                                    var interval = setInterval(function () {
                                        counter++;
                                        // Display 'counter' wherever you want to display it.
                                        dialog.find('.bootbox-body').html('This will redirect to ticket list after <b style="color:#000; font-size:12px;">' + max + '</b>');
                                        if (counter == 3) {
                                            // Display a login box
                                            $(window).unbind('beforeunload');
                                            $('.modal').modal('hide');
                                            window.location.href = base_url + 'helpdesk/ticket/view/close';
                                        }
                                        max--;
                                    }, 1000);
                                });
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                App.stopPageLoading();
                                console.log(textStatus, errorThrown);
                                return false;
                            }
                        });

                    });
                });
            }
        };
    }();

    jQuery(document).ready(function () {
        ajax.init();
    });
</script>
