<script>
    //stable ajax function start here
    var fnLoadingImg = function (gif) { return '<img class="page-loading" src="' + static_url + 'images/' + gif + '"></img>'; };
    var getDate = function (element) { var date; try { date = $.datepicker.parseDate(dateFormat, element.value); } catch (error) { date = null; } return date; };
    var fnToStr = function (value, key, to) { if (dev_status) { switch (key) { case 'success': toastr.success(value, key, {timeOut: to}); break; case 'warning': toastr.warning(value, key, {timeOut: to}); break; case 'info': toastr.info(value, key, {timeOut: to}); break; case 'error': toastr.error(value, key, {timeOut: to});  break; } } };
    var fnCloseModal = function(){ $(".modal").hide(); $('.modal').modal('hide'); };
    var fnCloseBootbox = function () { App.startPageLoading(); $(".bootbox").hide(); $(".modal-backdrop").hide(); App.stopPageLoading(); };
    var fnResetBtn = function () { App.startPageLoading(); $("#opt_delete").hide(); $("#opt_remove").hide(); $("#opt_add").show(); $("#opt_edit").hide();  App.stopPageLoading(); };
    var fnRefreshDataTable = function () { var tbl = $(".table-scrollable table")[0].id; if (tbl){ $("#"+tbl).DataTable().ajax.reload(); } };
    var fnAjaxPost = function (url_post, formdata, options) { $.ajax({ url: url_post, method: "POST", data: formdata, success: function (response) { if (options) { fnToStr(options + ' is successfully!', 'success'); } else { fnToStr('successfully!', 'success'); } if ($(".table")[0]) { fnRefreshDataTable(); } }, error: function () { if (options) { fnToStr(options + ' is failed, please try again or call superuser to help!', 'error'); } else { fnToStr('failed, please try again or call superuser to help!', 'error'); } if ($(".table")[0]) { fnRefreshDataTable(); } } }); };
    var fnActionId = function (url_post, id, options) { $.ajax({ url: url_post + id, method: "POST", success: function (response) { fnToStr(options + ' is successfully!', 'success'); if ($(".table")[0]){ fnRefreshDataTable(); } }, error: function () { fnToStr(options + ' is failed, please try again or call superuser to help!', 'error'); if ($(".table")[0]){ fnRefreshDataTable(); } } }); return false; };
    var fnResetCheckbox = function(){ $('.select_all').prop('checked', false); $('.select_tr').prop('checked', false); };
    //stable ajax function end here 
    
    //optional ajax function start here 
    var fnCheckResponseBtn = function (id) { var return_val = false; var url_post = base_backend_url + 'tickets/master/check_status_ticket'; var formdata = { id: id }; $.ajax({ url: url_post, method: "POST", data: formdata, success: function (response) { if (response == 'true') { return true; } else { return false; } } }); };
    var fnGetTimtikUser = function () { var url_post = base_backend_url + 'prefferences/user/get_user/1'; $.ajax({ url: url_post, method: "POST", success: function (response) { $('.timtik').html(response); } }); return false; };
    var fnGetVendorUser = function () { var url_post = base_backend_url + 'prefferences/user/get_user/2'; $.ajax({ url: url_post, method: "POST", success: function (response) { $('.vendor').html(response); } }); return false; };
    var fnTicketAuth = function (status) { switch (status) { case 'close': $('#re_open').show(); $('#sbmt_message').attr('disabled', 'disabled'); $('#req_to_close').hide(); $('.caption-helper').css('color:red'); break; case 'progress': $('#re_open').hide(); $('#mark_as_solve').attr('disabled', 'disabled'); break; case 'open': $('#re_open').hide(); break; } };
    var fnInterval = function(){ 
        setInterval(function () { 
            //var href = $('.in').attr('id'); 
            var href = $('#modal_response')[0];
            var open = $(href).hasClass('in');
            if (open == true) { 
                var code = $('input[name="ticket_code_btn_submit_response_modal"]').val(); 
                var formdata = { ticket_code: Base64.encode(code) };
                var url_post = base_backend_url + 'tickets/master/check_ticket_timeout/'; 
                $.ajax({
                    url: url_post, 
                    method: "POST", 
                    data: formdata, 
                    success: function (response) { 
                        if (response == 'false'){ 
                            //console.log('reload page');
                            fnCloseModal(); 
                            window.location.reload(); 
                        } 
                    } 
                }); 
            }
        }, 3000);
    };
    var fnBeforeLoadPage = function (txt) { $(window).bind('beforeunload', function () {  fnCloseTicket(); if (txt) {  return txt; } else { return 'are you sure you want to leave?'; } }); };
    var fnCheckInsertForm = function () { var err = ''; var group = $("#group").val(); if (group == 0) { err += 'Please select group, '; } if (err != '') { fnToStr(err, 'error'); App.stopPageLoading(); return false; } else { return true; } };
    var fnCheckTicketOpen = function (id) { var formdata = { id: (id) }; $.ajax({ url: base_backend_url + 'tickets/master/check_ticket_open/', method: "POST", data: formdata, success: function (response) { if (response == 'false') { fnToStr('Ticket is already open by other user', 'warning'); fnCloseModal(); return false; } }, error: function (response) { return false; } }); };
    //optional ajax function end here 
        
    var sleep = function(seconds){
        var waitUntil = new Date().getTime() + seconds*1000;
        while(new Date().getTime() < waitUntil) true;
    };
    
    var fnSetOpenTicket = function (formdata) {
        $.ajax({
            url: base_backend_url + 'tickets/master/set_open/',
            method: "POST",
            data: formdata,
            success: function (response) {
                console.log(response);
            },
            error: function (response) {
                console.log(response);
            }
        });
        return false;
    };
    
    var fnCloseTicket = function (formdata) {
        window.onbeforeunload = null;
        $.ajax({
            url: base_backend_url + 'tickets/master/set_close/',
            method: "POST",
            data: formdata,
            success: function (response) {
                console.log(response);
            },
            error: function (response) {
                console.log(response);
            }
        });
        return false;
    };
    
    var fnGetDetail = function (id) {
        var formdata = {
            ticket_id: (id)
        };
        $.ajax({
            url: base_backend_url + 'tickets/master/get_ticket_detail/',
            method: "POST",
            data: formdata,
            beforeSend: function () {
                // Statement
                App.startPageLoading();
            },
            success: function (data) {
                var row = JSON.parse(data);
                var status_ = false;
                if (row.is_active == 1) {
                    status_ = true;
                }
                $('input[name="create_date_modal_detail_ticket"]').val(row.create_date);
                $('input[name="code_modal_detail_ticket"]').val(row.code);
                $('input[name="ticket_status_modal_detail_ticket"]').val(row.ticket_status);
                $('input[name="category_name_modal_detail_ticket"]').val(row.category['name_ina']);
                $('input[name="job_category_name_modal_detail_ticket"]').val(row.job['name']);
                $('textarea[name="content_modal_detail_ticket"]').val(row.content);
                $('input[name="problem_impact_modal_detail_ticket"]').val(row.problem_impact);
                $('input[name="create_by_name_detail_ticket"]').val(row.create_by_name);
                $('input[name="recreate_by_name_detail_ticket"]').val(row.recreate_by);
                if (row.branch_id == 0) {
                    $('input[name="branch_name_modal_detail_ticket"]').val("IMI");
                } else {
                    $('input[name="branch_name_modal_detail_ticket"]').val(row.branch['name']);
                }
                if (row.ticket_status == 'transfer') {
                    $('.modal-title').html('This ticket transfer from <b>' + row.ticket_transfer.user_from_name + '</b> to <b>' + row.ticket_transfer.user_to_name + '</b>');
                } else {
                    $('.modal-title').html((row.handle_by != null) ? 'Tiket ditangani oleh <b>' + row.handle_by + '</b>' : 'Tiket ini <b>belum ditangani oleh siapa pun.</b>');
                }
                if (row.files) {
                    var files = row.files;
                    var vl_arr = [];
                    for (i = 0; i < files.length; i++) {
                        vl_arr += '<div class="col-md-2" style="margin-bottom:2px; width:18%;"><div class="dashboard-stat blue"><img style="width:100%" src="' + static_url + 'tickets/' + files[i]['path'] + '" /><a class="more f_attachment" data-toggle="modal" href="#file_attach_mdl" data-path="' + files[i]['path'] + '"  data-id="' + row.id + '" data-code="' + row.code + '" href="javascript:;"> LIHAT DETAIL <i class="m-icon-swapright m-icon-white"></i></a></div></div>';
                    }
                    $('#img_attach').html(vl_arr);
                }
                if (row.ticket_status == 'open' || row.ticket_status == 'close' || row.ticket_status == 'progress' || row.ticket_status == 'transfer') {
                    if(row.ticket_status == 'open'){
                        $('#history').hide();
                        $('#history_chat').hide();
                    }else{
                        if (row.history_chat) {
                            var history_chat = row.history_chat;
                            var vl_arr2 = [];
                            for (i = 0; i < history_chat.length; i++) {
                                if (history_chat[i]['reply_to'] == Base64.decode(user_id)) {
                                    $style = '#d57b6c';
                                } else if (history_chat[i]['created_by'] == Base64.decode(user_id)) {
                                    $style = '#28acb8';
                                } else if (history_chat[i]['reply_to'] != Base64.decode(user_id) && history_chat[i]['created_by'] != Base64.decode(user_id)) {
                                    $style = '#f5f6fa';
                                }
                                vl_arr2 += '<div class="todo-tasklist-item todo-tasklist-item-border-green" style="border-left: '+ $style +' 4px solid;"><div class="todo-tasklist-item-title"><span class="todo-tasklist-badge badge badge-roundless"> '+ history_chat[i]['username'] +' </span></div><div class="todo-tasklist-item-text">' + history_chat[i]['messages'] + '</div><div class="todo-tasklist-controls pull-left"><span class="todo-tasklist-date"><i class="fa fa-calendar"></i>' + row.create_date + '</span></div></div>'; 
                            }
                            $('.history_chat').show();
                            $('.history_chat').html(vl_arr2);
                            $('.history_chat').css('z-index', 99999);
                        }
                    }
                    if (row.history_ticket) {
                        var history_ticket = row.history_ticket;
                        var vl_arr3 = [];
                        for (i = 0; i < history_ticket.length; i++) {
                            vl_arr3 += '<div class="portlet-body"> <div class="timeline"><div class="timeline-item"><div class="timeline-badge"><div class="timeline-icon"></div></div><div class="timeline-body" ><div class="timeline-body-arrow"></div><div class="timeline-body-head"><div class="timeline-body-head-caption"><span class="timeline-body-time font-grey-cascade">'+ row.history_ticket[i].create_date +'</span></div></div><hr style="  border-bottom: 2px solid rgb(185, 179, 179); "><div class="timeline-body-content"> <span class="font-grey-cascade">'+ history_ticket[i]['messages'] +'</span></div></div></div></div></div>';                        }
                        $('.history_ticket').show();
                        $('.history_ticket').html(vl_arr3);
                        $('.history_ticket').css('z-index', 99999);
                    }
                }else{
                    $('#history').hide();
                    $('#history_chat').hide();
                    $('#history_ticket').hide();
                }
            },
            error: function (data) {
                console.log(data);
            },
            complete: function (data) {
                // Hide image container
                App.stopPageLoading();
            }
        });
        return false;
    };

    var fnCheckTicketTransfer = function(id){
        $.post( base_backend_url + 'tickets/master/check_total_transfer_ticket/' + id, function( data ) {
            if(data == 'false'){
                $('.modal').modal('hide');
                console.log('tiket sudah mencapai proses transfer maksimum');
                fnToStr('tiket sudah mencapai proses transfer maksimum','error');
                return false;
            }
        });
    };
    
    var fnGetTransferTicket = function (id) {
        fnCheckTicketTransfer(id);
        var formdata = {
            ticket_id: (id)
        };
        $.ajax({
            url: base_backend_url + 'tickets/master/get_data/',
            method: "POST",
            data: formdata,
            beforeSend: function () {
                // Statement
                App.startPageLoading();
            },
            success: function (data) {
                var row = JSON.parse(data);
                $('input[name="ticket_id_transfer_ticket"]').val(row.id);
                $('input[name="code_transfer_ticket"]').val(row.code);
                $('#ticket_transfer_category').html('<option value="'+row.category.id+'">'+row.category.name_ina+'</option>');
                $('#ticket_transfer_job').html('<option value="'+row.job.id+'">'+row.job.name+'</option>');

                $('#ticket_transfer_category').attr('data-id', row.category.id);
                $('#ticket_transfer_category').attr('data-val', row.category.name_ina);

                $('#ticket_transfer_job').attr('data-id', row.job.id);
                $('#ticket_transfer_job').attr('data-val', row.job.name);
                
            },
            error: function (data) {
                console.log(data);
            },
            complete: function (data) {
                // Hide image container
                App.stopPageLoading();
            }
        });
        return false;
    };
    
    var fnGetCloseTicket = function (ticket_id) {
        var job_id = $('input[name="job_id"]').val();
        var formdata = {
            job_id: (job_id)
        };
        $.ajax({
            url: base_backend_url + 'tickets/master/get_job_desc',
            method: "POST",
            data: formdata,
            beforeSend: function () {
                // Statement
                App.startPageLoading();
            },
            success: function (data) {
                $('input[name="ticket_id_close_ticket"]').val(Base64.encode(ticket_id));
                $('#job_list_').html(data);
            },
            error: function (data) {
                console.log(data);
            },
            complete: function (data) {
                // Hide image container
                App.stopPageLoading();
            }
        });
        return false;
    };
    
    var fnGetReopenTicket = function(id){
        var formdata = {
            ticket_id: Base64.encode(id)
        };
        $.ajax({
            url: base_backend_url + 'tickets/master/get_data/',
            method: "POST",
            data: formdata,
            beforeSend: function () {
                // Statement
                App.startPageLoading();
            },
            success: function (data) {
                var row = JSON.parse(data);
                $('input[name="ticket_id_modal_re_open"]').val(row.id);
                $('input[name="ticket_code_modal_re_open"]').val(row.code);
                $('div#create_date_modal_re_open').html(row.create_date);
                $('div#code_modal_re_open').html(row.code);
                $('div#ticket_status_modal_re_open').html(row.ticket_status);
                $('div#category_name_modal_re_open').html(row.category['name_ina']);
                $('div#job_category_name_modal_re_open').html(row.job['name']);
                $('div#handle_by_modal_re_open').html(row.handle_by);
                $('div#content_modal_re_open').html(row.content).css('text-align', 'justify');
                $('div#previously_solving_modal_re_open').html(row.last_chats.messages);
                $('div#ticket_code_div').html('(' + row.code + ')');
                if (row.files) {
                    var files = row.files;
                    var vl_arr = [];
                    for (i = 0; i < files.length; i++) {
                        vl_arr += '<div class="col-md-2" style="margin-bottom:2px; width:18%;"><div class="dashboard-stat blue"><img style="width:100%" src="' + static_url + 'tickets/' + files[i]['path'] + '" /><a class="more f_attachment" data-toggle="modal" href="#file_attach_mdl" data-path="' + files[i]['path'] + '"  data-id="' + row.id + '" data-code="' + row.code + '" href="javascript:;"> LIHAT DETAIL <i class="m-icon-swapright m-icon-white"></i></a></div></div>';
                    }
                    $('.img_attach_modal_re_open').show();
                    $('.img_attach_modal_re_open').html(vl_arr);
                    $('#file_modal_re_open').css('z-index', 99999);
                }
                if (row.chats) {
                    var chats = row.chats;
                    var vl_arr2 = [];
                    for (i = 0; i < chats.length; i++) {
                        if (chats[i]['reply_to'] == Base64.decode(user_id)) {
                            $style = '#d57b6c';
                        } else if (chats[i]['created_by'] == Base64.decode(user_id)) {
                            $style = '#28acb8';
                        } else if (chats[i]['reply_to'] != Base64.decode(user_id) && chats[i]['created_by'] != Base64.decode(user_id)) {
                            $style = '#f5f6fa';
                        }
                        vl_arr2 += '<div class="todo-tasklist-item todo-tasklist-item-border-green" style="border-left: '+ $style +' 4px solid;"><div class="todo-tasklist-item-title"><span class="todo-tasklist-badge badge badge-roundless"> '+ history_chat[i]['username'] +' </span></div><div class="todo-tasklist-item-text">' + history_chat[i]['messages'] + '</div><div class="todo-tasklist-controls pull-left"><span class="todo-tasklist-date"><i class="fa fa-calendar"></i>' + row.create_date + '</span></div></div>';
                    }
                    $('.history_chat_modal_re_open').show();
                    $('.history_chat_modal_re_open').html(vl_arr2);
                    $('.history_chat_modal_re_open').css('z-index', 99999);
                }
            },
            error: function (data) {
                console.log(data);
            },
            complete: function (data) {
                // Hide image container
                App.stopPageLoading();
            }
        });
        return false;
    };
    
    var fnGetResponseTicket = function (id) {
        var formdata = {
            ticket_id: (id)
        };
        $.ajax({
            url: base_backend_url + 'tickets/master/get_ticket_detail/response',
            method: "POST",
            data: formdata,
            beforeSend: function () {
                // Statement
                App.startPageLoading();
            },
            success: function (data) {
                var row = JSON.parse(data);
                //set ticket open
                fnSetOpenTicket(formdata);
                $('input[name="ticket_id_btn_submit_response_modal"]').val(row.id);
                $('input[name="ticket_code_btn_submit_response_modal"]').val(row.code);
                $('#code').html(row.code);
                $('#impact').html(row.problem_impact);
                $('#category').html(row.category.name_ina);
                $('#category').attr('data-val',row.category.name_ina);
                $('#job').html(row.job.name);
                $('#job').attr('data-val',row.job.name);
                $('#create_date').html(row.create_date);
                $('#content').html(row.content);
                if (row.files) {
                    var files = row.files;
                    var vl_arr = [];
                    for (i = 0; i < files.length; i++) {
                        vl_arr += '<div class="col-md-2" style="margin-bottom:2px; width:18%;"><div class="dashboard-stat blue"><img style="width:100%" src="' + static_url + 'tickets/' + files[i]['path'] + '" /><a class="more f_attachment" data-toggle="modal" href="#file_attach_mdl" data-path="' + files[i]['path'] + '"  data-id="' + row.id + '" data-code="' + row.code + '" href="javascript:;"> LIHAT DETAIL <i class="m-icon-swapright m-icon-white"></i></a></div></div>';
                    }
                    $('.img_attach').show();
                    $('.img_attach').html(vl_arr);
                    $('#file_attach_mdl').css('z-index', 99999);
                }
            },
            error: function (data) {
                console.log(data);
            },
            complete: function (data) {
                // Hide image container
                App.stopPageLoading();
            }
        });
        return false;
    };
    var fnValidateTransferTicketForm = function () {
        $('#frmTransfer').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                group_transfer_ticket: {
                    depends: function (elem) {
                        return $("#group_transfer_ticket").val() == ''
                    },
                    number: true
                },
                timtik_transfer_ticket: {
                    depends: function (elem) {
                        return $("#timtik_transfer_ticket").val() == ''
                    },
                    number: true
                },
                vendor_transfer_ticket: {
                    depends: function (elem) {
                        return $("#vendor_transfer_ticket").val() == ''
                    },
                    number: true
                },
                note_transfer_ticket: {
                    required: true
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                $('.alert-danger', $('#frmTransfer')).show();
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = errors == 1 ? 'You missed 1 field. It has been highlighted' : 'You missed ' + errors + ' fields. They have been highlighted';
                    $(".alert-danger span").html(message);
                    $(".alert-danger").show();
                } else {
                    $(".alert-danger").hide();
                }
            },
            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element.closest('.input-icon'));
            }
        });
        $("#frmTransfer input").keypress(function (e) {
            return 13 == e.which ? ($("#frmTransfer").validate().form() && $("#frmTransfer").submit(), !1) : void 0
        });
    };

    var fnValidateProgressTicketForm = function () {
        $('#frmTransfer').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                group_transfer_ticket: {
                    depends: function (elem) {
                        return $("#group_transfer_ticket").val() == ''
                    },
                    number: true
                },
                timtik_transfer_ticket: {
                    depends: function (elem) {
                        return $("#timtik_transfer_ticket").val() == ''
                    },
                    number: true
                },
                vendor_transfer_ticket: {
                    depends: function (elem) {
                        return $("#vendor_transfer_ticket").val() == ''
                    },
                    number: true
                },
                note_transfer_ticket: {
                    required: true
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                $('.alert-danger', $('#frmTransfer')).show();
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = errors == 1 ? 'You missed 1 field. It has been highlighted' : 'You missed ' + errors + ' fields. They have been highlighted';
                    $(".alert-danger span").html(message);
                    $(".alert-danger").show();
                } else {
                    $(".alert-danger").hide();
                }
            },
            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element.closest('.input-icon'));
            }
        });
        $("#frmTransfer input").keypress(function (e) {
            return 13 == e.which ? ($("#frmTransfer").validate().form() && $("#frmTransfer").submit(), !1) : void 0
        });
    };

    var fnValidateCloseTicketForm = function () {
        $('#frmClose').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                msg_close_ticket: {
                    required: true
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                $('.alert-danger', $('#frmClose')).show();
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = errors == 1 ? 'You missed 1 field. It has been highlighted' : 'You missed ' + errors + ' fields. They have been highlighted';
                    $(".alert-danger span").html(message);
                    $(".alert-danger").show();
                } else {
                    $(".alert-danger").hide();
                }
            },
            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element.closest('.input-icon'));
            }
        });
        $("#frmClose input").keypress(function (e) {
            return 13 == e.which ? ($("#frmClose").validate().form() && $("#frmClose").submit(), !1) : void 0
        });
    };

    var fnCheckTicketOpenStatus = function(id){
        var formdata = {
            id: (id)
        };
        $.ajax({
            url: base_backend_url + 'tickets/master/check_status_ticket/',
            method: "POST",
            data: formdata,
            success: function (data) {
                if(data == 'false'){
                    fnToStr('Maaf, tiket sedang dibuka oleh user lain...','warning');
                    setTimeout(function(){
                        $('#modal_response').modal('hide');
                    },1000);
                }else{
                    window.onbeforeunload = function (res) {
                        fnCloseTicket({ticket_id: id});
                        return "are you sure to reload page?";
                    };
                    fnGetResponseTicket(id);
                }
                console.log('success');
            },
            error: function (data) {
                console.log('error');
            }
        });
    };

    var fnValidateReOpenTicketForm = function () {
        $('#frmReOpen').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                msg_close_ticket: {
                    required: true
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                $('.alert-danger', $('#frmReOpen')).show();
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = errors == 1 ? 'You missed 1 field. It has been highlighted' : 'You missed ' + errors + ' fields. They have been highlighted';
                    $(".alert-danger span").html(message);
                    $(".alert-danger").show();
                } else {
                    $(".alert-danger").hide();
                }
            },
            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element.closest('.input-icon'));
            }
        });
        $("#frmReOpen input").keypress(function (e) {
            return 13 == e.which ? ($("#frmReOpen").validate().form() && $("#frmReOpen").submit(), !1) : void 0
        });
    };
    
    var fnGetCategory = function(){
        $.ajax({
            url: base_backend_url + 'tickets/master/get_category/',
            method: "POST", //First change type to method here
            success: function (response) {
                $('#category').html(response);
                $('#ticket_transfer_category').html(response);
                return false;
            },
            error: function (response) {
                console.log(response);
                return false;
            }
        });
    };
    
    var fnGetJob = function(id, v){
        $.ajax({
            url: base_backend_url + 'tickets/master/get_category/'+id+'/job',
            method: "POST", //First change type to method here
            success: function (response) {
                if(v==2){
                    $('.ticket_transfer_job').html(response);
                }else{
                    $('.response_ticket_change_job').html(response);
                }
                return false;
            },
            error: function () {
                console.log(response);
                return false;
            }

        });
    };
    
    var GlobalAjax = function () {
        return {
            init: function () { 
                //---------------------------------------------------------------------------------------------//
                //manipulate action button (add, edit, delete and refresh) start here
                //---------------------------------------------------------------------------------------------//
                $(document).scroll(function () {
                    if (($(document).height() - $(window).height() - $(document).scrollTop()) < 300) {
                        if (($(document).height() - $(window).height() - $(document).scrollTop()) == 0) {
                            $(".actDatatables").css("position", '');
                            $('.actDatatables').on('scroll').css('z-index', '');
                        } else {
                            $('.actDatatables').on('scroll').css('position', 'fixed');
                            $('.actDatatables').on('scroll').css('right', '0px');
                            $('.actDatatables').on('scroll').css('z-index', '9999');
                        }
                    }
                });
                //---------------------------------------------------------------------------------------------//
                //manipulate action button (add, edit, delete and refresh) end here
                //---------------------------------------------------------------------------------------------//
                //-----------------------------------------------------//
                //interval action to check new message notif from ticket chat
                //-----------------------------------------------------//
//                setInterval(function () {
//                    var url_post = base_url + 'auth/user/ticket_push';
//                    $.ajax({
//                        url: url_post,
//                        method: "POST",
//                        success: function (response) {
//                            if(response){
//                                console.log(response);return false;
//                                var row = JSON.parse(response);
//                                //alert(row);
//                                for (i = 0; i < row.ticket_push.length; i++) {
//                                    var sound = document.getElementById("messageSound");
//                                    sound.play();                  
//                                    $.notific8(row.ticket_push[i], { theme: 'lime', sticky: true, horizontalEdge: 'top', verticalEdge: 'right', zindex: '11100' });
//                                }
//                            }
//                        }
//                    });
//                }, 10000);
                //---------------------------------------------------------------------------------------------//
                //manipulate spab badge at sidebar menu and tab span start here
                //---------------------------------------------------------------------------------------------//
                if(open_total) $('span#Open').html(open_total);
                if(close_total) $('span#Close').html(close_total);
                
                var span_progress1 = '<span class="badge badge-roundless" style="background-color:#ffb136;display:true;" id="Progress">0</span>';
                $('.prog_t').html('<span class="badge badge-roundless" style="background-color:#ffb136;display:true;" id="Progress">0</span>');
                $('.global_reopen').html('<span class="badge badge-roundless" style="background-color:#508fda;display:true;" id="Progress_reopen">0</span>');
                if (progress_total) {
                    span_progress1 = '<span class="badge badge-roundless" style="background-color:#ffb136;display:true;" id="Progress">' + progress_total + '</span>';
                    $('.prog_t').html('<span class="badge badge-roundless" style="background-color:#ffb136;display:true;" id="Progress">' + progress_total + '</span>');
                }
                var span_progress2 = '<span class="badge badge-roundless" style="background-color:#508fda;display:true;" id="Progress_reopen">0</span>';
                if (progress_reopen_total) {
                    span_progress2 = '<span class="badge badge-roundless" style="background-color:#508fda;display:true;" id="Progress_reopen">' + progress_reopen_total + '</span>';
                    $('.global_reopen').html('<span class="badge badge-roundless" style="background-color:#508fda;display:true;" id="Progress_reopen">' + progress_reopen_total + '</span>');
                }
                $('span.bdge_prog').html(span_progress1 + ' ' + span_progress2);
                var span1 = '<span class="badge badge-roundless" style="background-color:#ed6b75;display:true;" id="Transfer">0</span>';
                $('.trf').html('<span class="badge badge-roundless" style="background-color:#ed6b75;display:true;" id="Transfer">0</span>');
                if (transfer_total) {
                    var span1 = '<span class="badge badge-roundless" style="background-color:#ed6b75;display:true;" id="Transfer">' + transfer_total + '</span>';
                    $('.trf').html('<span class="badge badge-roundless" style="background-color:#ed6b75;display:true;" id="Transfer">' + transfer_total + '</span>');
                }
                var span2 = '<span class="badge badge-roundless" style="background-color:#f64444;display:true;" id="Transfer_in">0</span>';
                $('.trf_in').html('<span class="badge badge-roundless" style="background-color:#f64444;display:true;" id="Transfer_in">0</span>');
                if (transfer_in_total) {
                    span2 = '<span class="badge badge-roundless" style="background-color:#f64444;display:true;" id="Transfer_in">' + transfer_in_total + '</span>';
                    $('.trf_in').html('<span class="badge badge-roundless" style="background-color:#f64444;display:true;" id="Transfer_in">' + transfer_in_total + '</span>');
                }
                var span3 = '<span class="badge badge-roundless" style="background-color:#b34300;display:true;" id="Transfer_out">0</span>';
                $('.trf_out').html('<span class="badge badge-roundless" style="background-color:#b34300;display:true;" id="Transfer_out">0</span>');
                if (transfer_out_total) {
                    span3 = '<span class="badge badge-roundless" style="background-color:#b34300;display:true;" id="Transfer_out">' + transfer_out_total + '</span>';
                    $('.trf_out').html('<span class="badge badge-roundless" style="background-color:#b34300;display:true;" id="Transfer_out">' + transfer_out_total + '</span>');
                }
                $('span.bdge').html(span1 + ' ' + span2 + ' ' + span3);
                //---------------------------------------------------------------------------------------------//
                //manipulate spab badge at sidebar menu and tab span end here
                //---------------------------------------------------------------------------------------------//
                
                //---------------------------------------------------------------------------------------------//
                //check ticket timeout with interval time start here
                //---------------------------------------------------------------------------------------------//
                fnInterval();
                //---------------------------------------------------------------------------------------------//
                //check ticket timeout with interval time end here
                //---------------------------------------------------------------------------------------------//
                
                //action from response ticket change category
                $('.modal').on('switchChange.bootstrapSwitch', 'input[name="change_category"]', function (event, state) {
                    if(state == true){
                        fnGetCategory();
                        $('#job').html('<select id="response_ticket_change_job" name="response_ticket_change_job" class="form-control edited response_ticket_change_job"><option>-- select category first --</option></select>');
                    }else{
                        //modal response
                        var val = $('#category').data('val');
                        var val2 = $('#job').data('val');
                        $('#category').html(val);
                        $('#job').html(val2);

                        var vl_id = $('#ticket_transfer_category').data('id');
                        var vl_name = $('#ticket_transfer_category').data('val');

                        var vl2_id = $('#ticket_transfer_job').data('id');
                        var vl2_name = $('#ticket_transfer_job').data('val');

                        $('#ticket_transfer_category').html('<option value="' + vl_id + '">' + vl_name + '</option>');
                        $('#ticket_transfer_job').html('<option value="' + vl2_id + '">' + vl2_name + '</option>');
                    }
                    
                });

                //
                $('.modal').on('change','.response_ticket_change_category', function(){
                    var id = $(this).val();
                    fnGetJob(id);

                });
                $('.modal').on('change','#ticket_transfer_category', function(){
                    var id = $(this).val();
                    fnGetJob(id,2);

                });
                //

                //---------------------------------------------------------------------------------------------//
                //js handler from action a href modal show start here
                //---------------------------------------------------------------------------------------------//
                $(".modal").on("show.bs.modal", function (event) {
                    var button = $(event.relatedTarget);
                    var target = $(this).attr('id');
                    var id = button.data('id');
                    App.startPageLoading();
                    switch (target) {
                        case 'modal_detail':
                            fnGetDetail(id);
                            break;
                        case 'modal_response':
                            console.log(Base64.decode(id));
                            fnCheckTicketOpenStatus(id);
                            break;
                        case 'modal_transfer':
                            fnGetTransferTicket(id);
                            break;
                        case 'modal_close':
                            fnGetCloseTicket(id);
                            break;
                        case 'modal_re_open':
                            fnGetReopenTicket(Base64.decode(id));
                            break;
                    }
                    App.stopPageLoading();
                });
                //---------------------------------------------------------------------------------------------//
                //js handler from action a href modal show end here
                //---------------------------------------------------------------------------------------------//
                
                $(".modal").on("hide.bs.modal", function (event) {
                    var button = $(event.relatedTarget);
                    var target = $(this).attr('id');
                    $(window).unbind('beforeunload');
                    fnResetCheckbox();
                    fnResetBtn();
                    $("form")[0].reset();
                    switch (target) {
                        case 'modal_detail':
                            break;
                        case 'modal_response':
                            var id = $('input[name="ticket_id_btn_submit_response_modal"]').val();
                            console.log(id);
                            var formdata = {
                                ticket_id: Base64.encode(id)
                            };
                            $("#frmResponse")[0].reset();
                            $('input[name="ticket_id_btn_submit_response_modal"]').val('');
                            $('input[name="code_modal_detail_ticket"]').val('');
                            $('#code').html('');
                            $('#create_date').html('');
                            $('#impact').html('');
                            $('#img_attach').html('');
                            $('.img_attach').hide();
                            $('#content').html('');
                            $('textarea[name="message_btn_submit_response_modal"]').val();
                            fnCloseTicket(formdata);
                            break;
                        case 'modal_add_edit':
                            console.log('reset');
                            $("form#add_edit")[0].reset();
                            break;
                    }
                });
                
                //---------------------------------------------------------------------------------------------//
                //button close modal x or close or cancel at modal start here
                //---------------------------------------------------------------------------------------------//
                $('button[type="button"]').on('click', function () {
                    var dismiss = $(this).attr('data-dismiss');
                    var action = $(this).attr('data-action');
                    App.startPageLoading();
                    switch (dismiss) {
                        case 'modal':
                            $('.modal').modal('hide');
                            fnRefreshDataTable();
                            fnResetBtn();
                            $(window).unbind('beforeunload');
                            break;
                    }
                    switch (action) {
                        case 'close-modal':
                            $('.modal').modal('hide');
                            fnResetCheckbox();
                            fnResetBtn();
                            $(window).unbind('beforeunload');
                            break;
                    }
                    App.stopPageLoading();
                });
                //---------------------------------------------------------------------------------------------//
                //button close modal x or close or cancel at modal start here
                //---------------------------------------------------------------------------------------------//

                //---------------------------------------------------------------------------------------------//
                //select on change at group transfer ticket select start here
                //---------------------------------------------------------------------------------------------//
                $('#group_transfer_ticket').on('change', function () {
                    var id = $(this).val();
                    if (id == 1) {
                        $('#timtik_frm').fadeIn();
                        $('#vendor_frm').fadeOut();
                        fnGetTimtikUser();
                        $('#timtik_transfer_ticket').attr('required', true);
                        $('#vendor_transfer_ticket').removeAttr('required');
                    } else if (id == 2) {
                        $('#vendor_frm').fadeIn();
                        $('#timtik_frm').fadeOut();
                        fnGetVendorUser();
                        $('#vendor_transfer_ticket').attr('required', true);
                        $('#timtik_transfer_ticket').removeAttr('required');
                    }
                });
                //---------------------------------------------------------------------------------------------//
                //select on change at group select start here
                //---------------------------------------------------------------------------------------------//

                //---------------------------------------------------------------------------------------------//
                //datatable action for select all start here
                //---------------------------------------------------------------------------------------------//
                 $('table.table').on('click', '#select_all', function () {
                    var is_checked = $(this).is(':checked');
                    if (is_checked == true) {
                        $('input[type="checkbox"]').prop('checked', true);
                    } else {
                        $('input[type="checkbox"]').prop('checked', false);
                        $('input[id="select_all"]').prop('checked', false);
                    }
                });
                //---------------------------------------------------------------------------------------------//
                //datatable action for select all end here
                //---------------------------------------------------------------------------------------------//

                //---------------------------------------------------------------------------------------------//
                //datatable action for select one by one and manipulate button action (add, edit, delete and 
                //refresh) start here
                //---------------------------------------------------------------------------------------------//
                $('table.table').on('click', '.md-check', function () {
                    var id = $(this).attr('data-id');
                    var is_checked = $('input.select_tr').is(':checked');
                    if (is_checked == true) {
                        var count = $('input.select_tr').filter(':checked').length;
                        if (id) {
                            $('input[name="id"]').val(id);
                        }
                        if (count > 1){
                            $("#opt_delete").show();
                            $("#opt_remove").show();
                            $("#opt_add").hide();
                            $("#opt_edit").hide();
                        } else {
                            $("#opt_delete").show();
                            $("#opt_remove").show();
                            $("#opt_add").hide();
                            $("#opt_edit").show();
                        }
                    } else {
                        $("#opt_delete").hide();
                        $("#opt_remove").show();
                        $("#opt_add").show();
                        $("#opt_edit").hide();
                    }
                });
                //---------------------------------------------------------------------------------------------//
                //datatable action for select one by one and manipulate button action (add, edit, delete and 
                //refresh) start here
                //---------------------------------------------------------------------------------------------//

                //---------------------------------------------------------------------------------------------//
                //action button image modal to show start here
                //---------------------------------------------------------------------------------------------//
                //from tab id tab_1_2
                $('#tab_1_2').on('click', '.f_attachment', function () {
                    var id = $(this).data('id');
                    var path = static_url + 'tickets/' + $(this).data('path');
                    $('#media').html('<img style="width:100%; height:100%; margin:10px" src="' + path + '" />');
                });
                //from class tab-pane
                $('.tab-pane').on('click', '.f_attachment', function () {
                    var id = $(this).data('id');
                    var path = static_url + 'tickets/' + $(this).data('path');
                    $('#media').html('<img style="width:100%; height:100%; margin:10px" src="' + path + '" />');
                });
                //not from tab
                $('#modal_response').on('click', '.f_attachment', function () {
                    var id = $(this).data('id');
                    var path = static_url + 'tickets/' + $(this).data('path');
                    $('#media').html('<img style="width:100%; height:100%; margin:10px" src="' + path + '" />');
                });
                //diirect call
                $('.f_attachment').on('click', function () {
                    var id = $(this).data('id');
                    var path = static_url + 'tickets/' + $(this).data('path');
                    $('#media').html('<img style="width:100%; height:100%; margin:10px" src="' + path + '" />');
                });
                //---------------------------------------------------------------------------------------------//
                //action button image modal to show end here
                //---------------------------------------------------------------------------------------------//

                //---------------------------------------------------------------------------------------------//
                //action button checkbox response ticket modal start here
                //---------------------------------------------------------------------------------------------//
                $('input[type="checkbox"][name="agree"]').on('click', function () {
                    var id = $(this).prop("checked");
                    if (id == true) {
                        $('#_btn_submit_response_modal').fadeIn();
                    } else {
                        $('#_btn_submit_response_modal').fadeOut();
                    }
                });
                //---------------------------------------------------------------------------------------------//
                //action button checkbox response ticket modal start here
                //---------------------------------------------------------------------------------------------//

                //---------------------------------------------------------------------------------------------//
                //action to handle from close modal response ticket, start here
                //---------------------------------------------------------------------------------------------//
               
                $("#modal_response").on("hide.bs.modal", function () {
                    var id = $('input[name="ticket_id_btn_submit_response_modal"]').val();
                    if (id) {
                        var formdata = {
                            ticket_id: Base64.encode(id)
                        };
                        $.ajax({
                            url: base_backend_url + 'tickets/master/set_close/',
                            method: "POST", //First change type to method here
                            data: formdata,
                            success: function (response) {
                                $(window).unbind('beforeunload');
                                return false;
                            },
                            error: function (response) {
                                return false;
                            }
                        });
                    }
                });
                //---------------------------------------------------------------------------------------------//
                //action to handle from close modal response ticket, end here
                //---------------------------------------------------------------------------------------------//

                //---------------------------------------------------------------------------------------------//
                //action to handle submit response ticket start here
                //---------------------------------------------------------------------------------------------//
                $('#frmResponse').on('submit', function (e) {
                    e.preventDefault();
                    var uri = base_backend_url + 'tickets/master/response_ticket';
                    var ticket_id = Base64.encode($('input[name="ticket_id_btn_submit_response_modal"]').val());
                    var ticket_code = $('input[name="ticket_code_btn_submit_response_modal"]').val();
                    var new_ticket_category = $('#response_ticket_change_category').val();
                    var new_ticket_job = $('#response_ticket_change_job').val();
                    var formdata = {
                        ticket_id: ticket_id,
                        ticket_code: ticket_code,
                        message: $('textarea[name="message_btn_submit_response_modal"]').val()
                    };
                    if(new_ticket_category && new_ticket_job){
                        formdata = {
                            ticket_id: ticket_id,
                            ticket_code: ticket_code,
                            message: $('textarea[name="message_btn_submit_response_modal"]').val(),
                            new_ticket_category: new_ticket_category,
                            new_ticket_job: new_ticket_job
                        };
                    }
                    fnValidateProgressTicketForm();
                        App.startPageLoading();
                        $.ajax({
                            url: uri,
                            method: "POST", //First change type to method here
                            data: formdata,
                            success: function (response) {
                                App.stopPageLoading(response);
                                fnToStr('Successfully add new ticket data ', 'success');
                                var dialog = bootbox.dialog({
                                    message: "Redirect me to",
                                    title: "Redirecting page",
                                    buttons: {
                                        success: {
                                            label: "Ticket Tracking!",
                                            className: "green",
                                            callback: function () {
                                                window.location.href = base_backend_url + 'tickets/master/tracking/' + Base64.encode(ticket_code);
                                            }
                                        },
                                        danger: {
                                            label: "Ticket List",
                                            className: "grey",
                                            callback: function () {
                                                window.location.href = base_backend_url + 'tickets/master/view/progress';
                                            }
                                        }
                                    }
                                });
                                dialog.init(function () {
                                    var counter = 0;
                                    var max = 3;
                                    setInterval(function () {
                                        counter++;
                                        // Display 'counter' wherever you want to display it.
                                        dialog.find('.bootbox-body').html('This will redirect to ticket list after <b style="color:#000; font-size:12px;">' + max + '</b>');
                                        if (counter == 3) {
                                            // Display a login box
                                            $(window).unbind('beforeunload');
                                            window.onbeforeunload = null;
                                            window.open(base_backend_url + 'tickets/master/tracking/' + Base64.encode(ticket_code), '_blank');
                                            $('.modal').modal('hide');
                                            window.location.href = base_backend_url + 'tickets/master/view/progress';
                                        }
                                        max--;
                                    }, 1000);
                                });
                            },
                            error: function () {
                                App.stopPageLoading();
                                fnToStr('Failed add new ticket data', 'error');
                            }
                        });
                });
                //---------------------------------------------------------------------------------------------//
                //action to handle submit response ticket end here
                //---------------------------------------------------------------------------------------------//

                //---------------------------------------------------------------------------------------------//
                //action for catch user send aggreement at taking a take over ticket when transfer from other 
                //user start here
                //---------------------------------------------------------------------------------------------//                
                $('#opn_agreement_trans_tickt').on('click', function () {
                    var uri = base_backend_url + 'tickets/master/agreement_to_take_over_ticket';
                    var agree = $('#aggree').is(":checked");
                    if (agree == false) {
                        $('span.err').css('color', 'red');
                        $('span.err').html('Please check first agreement checkbox to continue!!!');
                        return false;
                    }
                    var ticket = Base64.encode($('input[name="ticket_id_modal_transfer_open"]').val());
                    var formdata = {ticket_id: ticket};
                    $.ajax({
                        url: uri,
                        type: "post",
                        data: formdata,
                        success: function (response) {
                            App.stopPageLoading();
                            fnToStr('Successfully update ticket status to progress', 'success');
                            $('#modal_transfer_open').modal('hide');
                            $('#modal_transfer_open').hide();
                            window.location.reload();
                            return false;
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            App.stopPageLoading();
                            console.log(textStatus, errorThrown);
                            return false;
                        }
                    });
                });
                //---------------------------------------------------------------------------------------------//
                //action for catch user send aggreement at taking a take over ticket when transfer from other 
                //user end here
                //---------------------------------------------------------------------------------------------//

                //---------------------------------------------------------------------------------------------//
                //action to handle submit transfer ticket start here
                //---------------------------------------------------------------------------------------------//                
                $('#frmTransfer').on('submit', function (e) {
                    var uri = base_backend_url + 'tickets/master/transfer_ticket';
                    var formdata = {
                        ticket_id: $('input[name="ticket_id_transfer_ticket"]').val(),
                        ticket_code: $('input[name="code_transfer_ticket"]').val(),
                        //group: $('#group_transfer_ticket').val(),
                        //timtik: $('#timtik_transfer_ticket').val(),
                        //vendor: $('#vendor_transfer_ticket').val(),
                        note: $('textarea[name="note_transfer_ticket"]').val(),
                        category: $('#ticket_transfer_category').val(),
                        job: $('#ticket_transfer_job').val()
                    };
                    fnValidateTransferTicketForm();
                    bootbox.confirm("Are you sure?", function (result) {
                        if (result == false) {
                            $('.modal-backdrop').hide();
                            $('.bootbox ').hide();
                            return false;
                        }
                        App.startPageLoading();
                        $.ajax({
                            url: uri,
                            type: "post",
                            data: formdata,
                            success: function (response) {
                                //console.log(response);return false;
                                App.stopPageLoading();
                                fnToStr('Successfully transfer ticket.', 'success');
                                 window.location = base_backend_url + 'tickets/master/view/progress';
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                App.stopPageLoading();
                                fnToStr('Failed transfer ticket.', 'error');
                                console.log(textStatus, errorThrown);
                            }
                        });
                    });
                    e.preventDefault();
                });

                //---------------------------------------------------------------------------------------------//
                //action to handle submit transfer ticket end here
                //---------------------------------------------------------------------------------------------//

                //---------------------------------------------------------------------------------------------//
                //action to handle submit close ticket start here
                //---------------------------------------------------------------------------------------------//
                $('#frmClose').on('submit', function (e) {
                    var uri = base_backend_url + 'tickets/master/close_ticket';
                    arr = [];
                    $('.md-check:checked').each(function () {
                        arr.push($(this).data("id"));
                    });
                    var formdata = {
                        ticket_id: $('input[name="ticket_id_close_ticket"]').val(),
                        msg_job_list: arr,
                        message: $('textarea[name="msg_close_ticket"]').val()
                    };
                    fnValidateCloseTicketForm();
                    bootbox.confirm("Are you sure?", function (result) {
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
                                window.location = base_url + 'backend/tickets/master/view/close';
                                return false;
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                App.stopPageLoading();
                                console.log(textStatus, errorThrown);
                                return false;
                            }
                        });
                    });
                    e.preventDefault();
                });
                //---------------------------------------------------------------------------------------------//
                //action to handle submit close ticket end here
                //---------------------------------------------------------------------------------------------//

                //---------------------------------------------------------------------------------------------//
                //action to handle submit reopen ticket start here
                //---------------------------------------------------------------------------------------------//
                $('#btn_sbmt_form_reopen').on('click', function (e) {
                    e.preventDefault();
                    var uri = base_backend_url + 'tickets/master/reopen';
                    var ticket_id = $('input[name="ticket_id_modal_re_open"]').val();
                    var ticket_code = $('input[name="ticket_code_modal_re_open"]').val();
                    var formdata = {
                        ticket_id: Base64.encode(ticket_id),
                        ticket_code: ticket_code,
                        message: $('textarea[name="message_modal_re_open"]').val()
                    };

                    fnValidateReOpenTicketForm();
                    bootbox.confirm("Are you sure?", function (result) {
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
                                fnToStr('Successfully re-open ticket : ' + ticket_code);
                                fnCloseModal();
                                fnRefreshDataTable();
                                return false;
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                                return false;
                            }
                        });
                    });
                });
                //---------------------------------------------------------------------------------------------//
                //action to handle submit reopen ticket end here
                //---------------------------------------------------------------------------------------------//
            }
        };
    }();

    jQuery(document).ready(function () {
        GlobalAjax.init();
    });
</script>