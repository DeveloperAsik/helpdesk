<script>
    var TableDatatablesAjax = function () {
        return {
            //main function to initiate the module
            init: function () {
                toastr.success('lock screen js ready!!!');
                $(".ulsc").click(function () {
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
                          if(res.message.verify){
                            toastr.success('Successfully unlock screen...');
                            setTimeout(function () {
                                window.location = base_url + 'dashboard';
                            }, 1100);
                          }else{
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
        TableDatatablesAjax.init();
    });
</script>
