<script>
    var fnValidateSubmitTicketForm = function () {
        $('#issue_ticket_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                category_1: {
                    depends: function (elem) {
                        return $("#category_1").val() == '0'
                    },
                    number: true
                },
                category_2: {
                    depends: function (elem) {
                        return $("#category_2").val() == '0'
                    },
                    number: true
                },
                problem_impact: {
                    depends: function (elem) {
                        return $("#problem_impact").val() == '0'
                    },
                    number: true
                },
                issue: {
                    required: true
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                $('.alert-danger', $('#issue_ticket_form')).show();
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
        $("#issue_ticket_form input").keypress(function (e) {
            return 13 == e.which ? ($("#issue_ticket_form").validate().form() && $("#issue_ticket_form").submit(), !1) : void 0
        });
    };

    var Ajax = function () {
        return {
            //main function to initiate the module
            init: function () {
                $("div#droparea").dropzone({
                    addRemoveLinks: true, 
                    dictFallbackText: true, 
                    dictRemoveFile: 'remove', 
                    dictRemoveFileConfirmation: true, 
                    url: base_url + 'helpdesk/ticket/action/upload/' + Base64.encode(code)
                });
                $('#code').html(code);
                $("#droparea").hover(function () {
                    $(this).css("border-color", "#caed90");
                }, function () {
                    $(this).css("border-color", "#ccc");
                });
                if (!jQuery) {
                    $('#err').show();
                } else {
                    $('#err').hide();
                }
                $('select.first_ctg').on('change', function () {
                    App.startPageLoading();
                    var id = $(this).val();
                    var uri = base_url + 'ticket/get_category/';
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
                                $('select.second_ctg').html(response);
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

                $('#frmCreateTicket').on('submit', function (e) {
                    e.preventDefault();
                    App.startPageLoading();
                    var problem_impact = $("#problem_impact").val();
                    var category = $('#category_1').val();
                    var job = $('#category_2').val();
                    var issue = $('textarea[name="issue"]').val();

                    fnValidateSubmitTicketForm();

                    var uri = base_url + 'ticket/insert/';
                    var formdata = {
                        code: code,
                        category: category,
                        job: job,
                        problem_impact: problem_impact,
                        branch: $('#branch').val(),
                        issue: issue
                    };
                    $.ajax({
                        url: uri,
                        type: "post",
                        data: formdata,
                        success: function (response) {
                            App.stopPageLoading();
                            //return false;
                            //toastr.success('Sukses menambahkan tiket baru ');
                            //window.location.href = base_url + 'ticket/view/open';
                             var dialog = bootbox.dialog({
                                 message: "Redirect me to",
                                 title: "Redirecting page",
                                 buttons: {
                                     danger: {
                                         label: "Ticket List",
                                         className: "grey",
                                         callback: function () {
                                             window.location.href = base_url + 'ticket/view/open';
                                         }
                                     },
                                     main: {
                                         label: "Create New Ticket",
                                         className: "blue",
                                         callback: function () {
                                             window.location.href = base_url + 'ticket/create';
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
                                     dialog.find('.bootbox-body').html('This will redirect to ticket list open after <b style="color:#000; font-size:12px;">' + max + '</b>');
                                     if (counter == 3) {
                                         // Display a login box
                                         window.location.href = base_url + 'ticket/view/open';
                                     }
                                     max--;
                                 }, 1000);
                             });
                            return false;
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            App.stopPageLoading();
                            toastr.success('Gagal menambahkan data tiket baru ');
                            return false;
                        }
                    });
                    return false;
                });
            }
        };
    }();

    jQuery(document).ready(function () {
        Ajax.init();
    });
</script>
