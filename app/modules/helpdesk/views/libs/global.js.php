<script>
    //stable ajax function start here
    var fnLoadingImg = function (gif) { return '<img class="page-loading" src="' + static_url + 'images/' + gif + '"></img>'; };
    var getDate = function (element) { var date; try { date = $.datepicker.parseDate(dateFormat, element.value); } catch (error) { date = null; } return date; };
    var fnToStr = function (value, key, to) { if (dev_status) { switch (key) { case 'success': toastr.success(value, key, {timeOut: to}); break; case 'warning': toastr.warning(value, key, {timeOut: to}); break; case 'info': toastr.info(value, key, {timeOut: to}); break; case 'error': toastr.error(value, key, {timeOut: to});  break; } } };
    var fnCloseModal = function(){ $(".modal").hide(); $('.modal').modal('hide'); };
    var fnCloseBootbox = function () { App.startPageLoading(); $(".bootbox").hide(); $(".modal-backdrop").hide(); App.stopPageLoading(); };
    var fnResetBtn = function () { App.startPageLoading(); $("#opt_delete").hide(); $("#opt_remove").hide(); $("#opt_add").show(); $("#opt_edit").hide(); App.stopPageLoading(); };
    var fnRefreshDataTable = function () { var tbl = $(".table-scrollable table")[0].id; if (tbl){ $("#tbl").DataTable().ajax.reload(); } };
    var fnAjaxPost = function (url_post, formdata, options) {$.ajax({ url: url_post, method: "POST", data: formdata, success: function (response) { if (options) { fnToStr(options + ' is successfully!', 'success'); } else { fnToStr('successfully!', 'success'); } if ($(".table")[0]) { fnRefreshDataTable(); } }, error: function () { if (options) { fnToStr(options + ' is failed, please try again or call superuser to help!', 'error'); } else { fnToStr('failed, please try again or call superuser to help!', 'error'); } if ($(".table")[0]) { fnRefreshDataTable(); } } });};
    var fnActionId = function (url_post, id, options) { $.ajax({ url: url_post + id, method: "POST", success: function (response) { fnToStr(options + ' is successfully!', 'success'); if ($(".table")[0]){ fnRefreshDataTable(); } }, error: function () { fnToStr(options + ' is failed, please try again or call superuser to help!', 'error'); if ($(".table")[0]){ fnRefreshDataTable(); } } }); return false; };
    var fnResetCheckbox = function(){ $('.select_all').prop('checked', false); $('.select_tr').prop('checked', false); };
    var fnTicketAuth = function (status) { switch (status) { case 'close': $('#modal_re_open').show(); $('#sbmt_message').attr('disabled', 'disabled'); $('#req_to_close').hide(); $('.caption-helper').css('color:red'); break; case 'progress': $('#modal_re_open').hide(); $('#mark_as_solve').attr('disabled', 'disabled'); break; case 'open': $('#modal_re_open').hide(); break; } };
    //stable ajax function end here 

    var sendFile = function (file, that) { var data = new FormData(); data.append('file', file); $.ajax({ data: data, type: 'post', url: base_url + 'helpdesk/ticket/insert_image_summernote', cache: false, contentType: false, processData: false, success: function (url) { $(that).summernote('insertImage', url, ''); } }); };

    var GlobalAjax = function () {
        return {
            //main function to initiate the module
            init: function () {
                //-----------------------------------------------------//
                //action to set total ticket per categories in sidebar menu
                //-----------------------------------------------------//
                $('span#Open').html(open_total);
                $('span#Progress').html(progress_total);
                $('span#Close').html(close_total);
                $('span#Transfer').html(transfer_total);
                
                //-----------------------------------------------------//
                //action to refresh datatable when it exist
                //-----------------------------------------------------//
                $('a#opt_refresh').on('click', function(){
                    $('.sidebar-search')[0].reset();
                    $('.table').dataTable().fnFilter('');
                    fnRefreshDataTable();
                });
                //-----------------------------------------------------//
                //interval action to check new message notif from ticket chat
                //-----------------------------------------------------//
                setInterval(function () {
                    var url_post = base_url + 'auth/user/ticket_push';
                    $.ajax({
                        url: url_post,
                        method: "POST",
                        success: function (response) {
                            var row = JSON.parse(response);
                            for (i = 0; i < row.ticket_push.length; i++) {
                                var sound = document.getElementById("messageSound");
                                sound.play();
                                $.notific8(row.ticket_push[i], { theme: 'lime', sticky: true, horizontalEdge: 'top', verticalEdge: 'right', zindex: '11100' });
                            }
                        }
                    });
                }, 10000);
                //-------------------------------------//
                //action to force close modal when opened
                //-------------------------------------//
                $('button[type="button"]').on('click', function () {
                    var dismiss = $(this).attr('data-dismiss');
                    App.startPageLoading();
                    switch (dismiss) {
                        case 'modal':
                            $('.modal').modal('hide');
                            fnRefreshDataTable();
                            fnResetBtn();
                            break;
                    }
                    App.stopPageLoading();
                });
                
                //-------------------------------------//
                //action for checkbox select all at datatable
                //-------------------------------------//
                $('table#datatable_ajax').on('click', '#select_all', function () {
                    var is_checked = $(this).is(':checked');
                    if (is_checked == true) {
                        $('input[type="checkbox"]').prop('checked', true);
                    } else {
                        $('input[type="checkbox"]').prop('checked', false);
                        $('input[id="select_all"]').prop('checked', false);
                    }
                });

                //-------------------------------------//
                //action for checkbox select at datatable
                //-------------------------------------//
                $('table#datatable_ajax').on('click', '.md-check', function () {
                    var id = $(this).attr('data-id');
                    var is_checked = $('input.select_tr').is(':checked');
                    if (is_checked == true) {
                        var count = $('input.select_tr').filter(':checked').length;
                        if (id) { $('input[name="id"]').val(id); }
                        if (count > 1) {
                            $("#opt_delete").attr("disabled", false);
                            $("#opt_delete").removeClass("disabled");
                            $("#opt_remove").attr("disabled", false);
                            $("#opt_remove").removeClass("disabled");
                            $("#opt_add").attr("disabled", true);
                            $("#opt_add").addClass("disabled");
                            $("#opt_edit").attr("disabled", true);
                            $("#opt_edit").addClass("disabled");
                        } else {
                            $("#opt_delete").attr("disabled", false);
                            $("#opt_delete").removeClass("disabled");
                            $("#opt_remove").attr("disabled", false);
                            $("#opt_remove").removeClass("disabled");
                            $("#opt_add").attr("disabled", true);
                            $("#opt_add").addClass("disabled");
                            $("#opt_edit").attr("disabled", false);
                            $("#opt_edit").removeClass("disabled");
                        }
                    } else {
                        $("#opt_delete").attr("disabled", true);
                        $("#opt_delete").addClass("disabled");
                        $("#opt_remove").attr("disabled", true);
                        $("#opt_remove").addClass("disabled");
                        $("#opt_add").attr("disabled", false);
                        $("#opt_add").removeClass("disabled");
                        $("#opt_edit").attr("disabled", true);
                        $("#opt_edit").addClass("disabled");
                    }
                });

                $('table.table').on('click', 'td a.btn', function () {
                    App.startPageLoading();
                    var id = $(this).attr('data-id');
                    var href = $(this).attr('href');
                    var formdata = {
                        id: Base64.encode(id)
                    };
                    if (href == '#modal_detail' || href == '#modal_re_open') {
                        $.ajax({
                            url: base_url + 'helpdesk/ticket/get_ticket_detail/',
                            method: "POST", //First change type to method here
                            data: formdata,
                            success: function (data) {
                                var row = JSON.parse(data);
                                if (row.ticket_status == 'close' || row.ticket_status == 'progress' || row.ticket_status == 'transfer' || row.ticket_status == 'open') {
                                    if(row.ticket_status == 'open'){
                                        $('#history').hide();
                                        $('#history_chat').hide();
                                    }else{
                                    $('#history').show();
                                    $('#history_chat').show();
                                    $('#history_ticket').show();
                                } 
                                }else {
                                    $('#history').hide();
                                    $('#history_chat').hide();
                                     $('#history_ticket').hide();
                                }
                                var status_ = false;
                                if (row.is_active == 1) {
                                    status_ = true;
                                }
                                if (href == '#modal_detail') {
                                    //assign into detail view
                                    $('input[name="create_date_modal_detail_ticket"]').val(row.create_date);
                                    $('input[name="code_modal_detail_ticket"]').val(row.code);
                                    $('input[name="ticket_status_modal_detail_ticket"]').val(row.ticket_status);
                                    $('input[name="category_name_modal_detail_ticket"]').val(row.category_name);
                                    $('input[name="job_category_name_modal_detail_ticket"]').val(row.job_category_name);
                                    $('input[name="problem_impact_modal_detail_ticket"]').val(row.problem_impact);
                                    $('input[name="create_by_name_detail_ticket"]').val(row.create_by_name);
                                    $('input[name="recreate_by_name_detail_ticket"]').val(row.issued_by_name);
                                    $('textarea[name="content_modal_detail_ticket"]').val(row.content);
                                    $('input[name="branch_name_modal_detail_ticket"]').val(row.branch.name);
                                    if (row.files) {
                                        var files = row.files;
                                        var vl_arr = [];
                                        for (i = 0; i < files.length; i++) {
                                            vl_arr += '<div class="col-md-2" style="margin-bottom:2px; width:18%;"><div class="dashboard-stat blue"><img style="width:100%" src="' +  static_url + 'tickets/' +files[i]['path'] + '" /><a class="more f_attachment" data-toggle="modal" href="#file_attach_mdl" data-path="' + files[i]['path'] + '"  data-id="' + row.id + '" data-code="' + row.code + '" href="javascript:;"> LIHAT DETAIL <i class="m-icon-swapright m-icon-white"></i></a></div></div>';
                                        }
                                        $('.img_attach').show();
                                        $('.img_attach').html(vl_arr);
                                        $('#file_attach_mdl').css('z-index', 99999);
                                    }
                                    if(row.transfer){
                                        $('.modal-title').html('ticket transfer from <b>'+ row.transfer.From_user + '</b>('+row.transfer.From_email+') to <b>' + row.transfer.To_user + '</b>('+row.transfer.To_email+')');
                                    }else{
                                        var txt = '';
                                        if(row.handle_by == null){
                                            txt = 'Tiket ini <b>belum ditangani oleh siapa pun.</b>';
                                        }else{
                                            txt =  'Tiket ditangani oleh <b>' + row.handle_by + '</b>';
                                        }
                                        // console.log(handle_by);
                                    $('.modal-title').html(txt);
                                    }

                                    if (row.ticket_status == 'close' || row.ticket_status == 'progress' || row.ticket_status == 'transfer' || row.ticket_status == 'open') {
                                        if(row.ticket_status == 'open'){
                                            $('#history').hide();
                                            $('#history_chat').hide();
                                        }else{
                                        if (row.history_chat) {
                                            var history_chat = row.history_chat;
                                            var vl_arr2 = [];
                                            for (i = 0; i < history_chat.length; i++) {
                                                 if(history_chat[i]['reply_to'] == Base64.decode(user_id)){
                                                    $style = '#d57b6c' ;
                                                }else if(history_chat[i]['created_by'] == Base64.decode(user_id)){
                                                    $style = '#28acb8';
                                                }else if (history_chat[i]['reply_to'] != Base64.decode(user_id) && history_chat[i]['created_by'] != Base64.decode(user_id)) {
                                                $style = '#f5f6fa';
                                                }
                                                // vl_arr2 += '<div class="well" style="background-color:'+ $style +'"><h4>' + history_chat[i]['username'] + ' (<small>' + row.create_date + '</small>) </h4>' + history_chat[i]['messages'] + '</div>';
                                                vl_arr2 += '<div class="todo-tasklist-item todo-tasklist-item-border-green" style="border-left: '+ $style +' 4px solid;"><div class="todo-tasklist-item-title"><span class="todo-tasklist-badge badge badge-roundless"> '+ history_chat[i]['username'] +' </span></div><div class="todo-tasklist-item-text">' + history_chat[i]['messages'] + '</div><div class="todo-tasklist-controls pull-left"><span class="todo-tasklist-date"><i class="fa fa-calendar"></i>' + row.create_date + '</span></div></div>';

                                            }
                                            $('.history_chat').show();
                                            $('.history_chat').html(vl_arr2);
                                            $('.history_chat').css('z-index', 99999)
                                        }
                                    }
                                        if (row.history_ticket) {
                                        var history_ticket = row.history_ticket;
                                        var vl_arr3 = [];
                                        for (i = 0; i < history_ticket.length; i++) {
                                            vl_arr3 += '<div class="portlet-body"> <div class="timeline"><div class="timeline-item"><div class="timeline-badge"><div class="timeline-icon"></div></div><div class="timeline-body" ><div class="timeline-body-arrow"></div><div class="timeline-body-head"><div class="timeline-body-head-caption"><span class="timeline-body-time font-grey-cascade">'+ row.history_ticket[i].create_date +'</span></div></div><hr style="  border-bottom: 2px solid rgb(185, 179, 179); "><div class="timeline-body-content"> <span class="font-grey-cascade">'+ history_ticket[i]['messages'] +'</span></div></div></div></div></div>';

                                        // vl_arr3 += '<ul class="timeline"><li class="timeline-yellow"><div class="timeline-time"><span class="date">' + row.history_ticket[i].create_date + '</span><span class="time">' + row.history_ticket[i].create_time + '</span></div><div class="timeline-icon"></i></div><div class="timeline-body"><h2>Tiket ' + row.code + '</h2><div class="timeline-content">' + history_ticket[i]['messages'] + '</div></div></li></ul>';
                                        }
                                        $('.history_ticket').show();
                                        $('.history_ticket').html(vl_arr3);
                                        $('.history_ticket').css('z-index', 99999);
                                        }
                                    }
                                } else if (href == '#modal_re_open') {
                                    $('input[name="ticket_id_modal_re_open"]').val(row.id);
                                    $('input[name="ticket_code_modal_re_open"]').val(row.code);
                                    $('div#create_date_modal_re_open').html(row.create_date);
                                    $('div#code_modal_re_open').html(row.code);
                                    $('div#ticket_status_modal_re_open').html(row.ticket_status);
                                    $('div#category_name_modal_re_open').html(row.category_name);
                                    $('div#job_category_name_modal_re_open').html(row.job_category_name);
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
                                            vl_arr2 += '<div class="todo-tasklist-item todo-tasklist-item-border-green" style="border-left: '+ $style +' 4px solid;"><div  class="todo-tasklist-item-title"><span class="todo-tasklist-badge badge badge-roundless"> '+ history_chat[i]['username'] +' </span></div><div class="todo-tasklist-item-text">' + history_chat[i]['messages'] + '</div><div class="todo-tasklist-controls pull-left"><span class="todo-tasklist-date"><i class="fa fa-calendar"></i>' + row.create_date + '</span></div></div>';
                                        }
                                        $('.history_chat_modal_re_open').show();
                                        $('.history_chat_modal_re_open').html(vl_arr2);
                                        $('.history_chat_modal_re_open').css('z-index', 99999);
                                    }
                                }
                                App.stopPageLoading();
                                return false;
                            },
                            error: function (data) {
                                toastr.success('Failed response this ticket!');
                                return false;
                            }
                        });
                    }
                });
                
                $('#tab_1_2').on('click', '.f_attachment', function () {
                    var id = $(this).data('id');
                    var path = static_url + 'tickets/' + $(this).data('path');
                    $('#media').html('<img style="width:100%; height:100%; margin:10px" src="' + path + '" />');
                });
                
                $('.modal').on('click', '.f_attachment', function () {
                    var id = $(this).data('id');
                    var path = static_url + 'tickets/' + $(this).data('path');
                    $('#media').html('<img style="width:100%; height:100%; margin:10px" src="' + path + '" />');
                });
                
                $('.modal').on('shown.bs.modal', function () {
                    $('#message').summernote({
                        dialogsInBody: true,
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
                        lang: 'zh-CN',
                        Height: 500,
                        dialogsFade: true, // Add fade effect on dialogs
                        dialogsInBody: true, // Dialogs can be placed in body, not in
                        disableDragAndDrop: false // default false You can disable drag and drop                        
                    });
                });
				
                $('#sbmt_message').on('click', function (e) {
                    e.preventDefault();
                    var disabled = $(this).attr('disabled');
                    if (disabled) {
                        return false;
                    }
                    var uri = base_url + 'ticket/insert_message';
                    var msg = $('textarea[name="message"]').val();
                    if (!msg || msg == '') {
                        fnToStr('Isi pesan terlebih dahulu!!!', 'warning', 2000);
                        return false;
                    }
                    var formdata = {
                        ticket_id: Base64.encode(ticket_id),
                        ticket_code: code,
                        message: msg
                    };
                    $.ajax({
                        url: uri,
                        type: "post",
                        data: formdata,
                        success: function (response) {
                            fnAutoLoadMessage();
                            $('#message').code('');
                            return false;
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                            return false;
                        }
                    });
                });
                
                $('#btn_sbmt_form_reopen').on('click', function (e) {
                    e.preventDefault();
                    var uri = base_url + 'ticket/reopen';
                    var ticket_id = $('input[name="ticket_id_modal_re_open"]').val();
                    var ticket_code = $('input[name="ticket_code_modal_re_open"]').val();
                    var formdata = {
                        ticket_id: Base64.encode(ticket_id),
                        ticket_code: ticket_code,
                        message: $('textarea[name="message_modal_re_open"]').val()
                    };
                    App.startPageLoading();
                    bootbox.confirm("Are you sure?", function (result) {
                        if(result == false){
                            $('.modal-backdrop').hide();
                            $('.bootbox ').hide();
                            return false;
                        }
                        if (result == true) {
                            $.ajax({
                                url: uri,
                                type: "post",
                                data: formdata,
                                success: function (response) {
                                    App.stopPageLoading();
                                    fnToStr('Successfully re-open ticket : ' + ticket_code);
                                    window.location = base_url + 'helpdesk/ticket/view/progress';
                                    return false;
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    App.stopPageLoading();
                                    console.log(textStatus, errorThrown);
                                    return false;
                                }
                            });
                        }
                    });
                });
            }
        };
    }();

    jQuery(document).ready(function () {
        GlobalAjax.init();
    });
</script>
