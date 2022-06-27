<script>
    var fnDetailTicket = function () {
        var formdata = {
            ticket_id: Base64.encode(id)
        };
        $.ajax({
            url: base_backend_url + 'tickets/master/get_ticket_detail/',
            method: "POST", //First change type to method here
            data: formdata,
            success: function (data) 
                var row = JSON.parse(data);
                var status_ = false;
                if (row.is_active == 1) {
                    status_ = true;
                }
                //assign into detail view
                $('input[name="create_date"]').val(row.create_date);
                $('input[name="code"]').val(row.code);
                $('input[name="ticket_status"]').val(row.ticket_status);
                $('input[name="category"]').val(row.category_name);
                $('input[name="job_category"]').val(row.job_category_name);
                $('textarea[name="content"]').val(row.content);
                $('textarea[name="description"]').val(row.description);
            },
            error: function (data) {
                toastr.success('Failed response this ticket!');
                return false;
            }
        });
    };

    var Ajax = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnDetailTicket();
                $('.f_attachment').on('click', function () {
                    var id = $(this).data('id');
                    var path = static_url + 'tickets/' + $(this).data('path');
                    $('#media').html('<img style="width:100%; height:100%; margin:10px" src="' + path + '" />');
                });
                $('#mark_as_solve').on('click', function () {
                    App.startPageLoading();
                    bootbox.confirm("Are you sure?", function (result) {
                        if (result == false) {
                            $('.modal-backdrop').hide();
                            $('.bootbox ').hide();
                            return false;
                        }
                        var msg = $('textarea[name="message"]').val();
                        var formdata = {
                            ticket_id: Base64.encode(id),
                            message: msg
                        };
                        $.ajax({
                            url: base_backend_url + 'tickets/master/mark_as_solve/',
                            method: "POST", //First change type to method here
                            data: formdata,
                            success: function (data) {
                                App.stopPageLoading();
                                window.location = base_backend_url + 'dashboard';
                                return false;
                            },
                            error: function (data) {
                                App.stopPageLoading();
                                toastr.success('Failed response this ticket!');
                                return false;
                            }
                        });
                    });
                });
            }
        };
    }();

    jQuery(document).ready(function () {
        Ajax.init();
    });
</script>