<script>
    var Ajax = function () {
        return {
            //main function to initiate the module
            init: function () {
                $(".ulsc").click(function () {
                    App.startPageLoading();
                    var id = $('input[name="id"]').val();
                    var email = $("[name='email']").val();
                    var password = $("[name='password']").val();
                    var uri = base_url + 'unlock-screen';
                    var formdata = {
                        id: id,
                        email: email,
                        password: Base64.encode(password)
                    };
                    $.ajax({
                        url: uri,
                        method: "POST", //First change type to method here
                        data: formdata,
                        success: function (response) {
                            var res = JSON.parse(response);
                            if (res.message.verify) {
                                toastr.success('Successfully unlock screen...');
                                if (res.message.group == '1') {
                                    App.stopPageLoading();
                                    window.location = base_url + 'backend/dashboard';
                                } else if (res.message.group == 2) {
                                    App.stopPageLoading();
                                    window.location = base_url + 'dashboard';
                                } else if (res.message.group == 3) {
                                    App.stopPageLoading();
                                    window.location = base_url + 'support/dashboard';
                                }
                            } else {
                                $('#unlock_screen')[0].reset();
                                toastr.error('Password did not match or not found at db system!!!')
                            }
                        },
                        error: function () {
                            $('#unlock_screen')[0].reset();
                            toastr.error('error has occured, please call programmers')
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
