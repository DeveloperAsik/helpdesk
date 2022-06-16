<script>
    var Login = function () {

        var handleLogin = function () {

            $('.login-form').validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {
                    username: {
                        required: true
                    },
                    password: {
                        required: true
                    },
                    remember: {
                        required: false
                    }
                },
                messages: {
                    username: {
                        required: "NIP wajib diisi."
                    },
                    password: {
                        required: "Kata sandi wajib diisi."
                    }
                },
                invalidHandler: function (event, validator) { //display error alert on form submit
                    $('.alert-danger', $('.login-form')).show();
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

            $(".login-form input").keypress(function (e) {
                return 13 == e.which ? ($(".login-form").validate().form() && $(".login-form").submit(), !1) : void 0
            });
        };

        return {
            //main function to initiate the module
            init: function () {
                $('marquee').on('mouseover', function () {
                    this.stop();
                });
                $('marquee').on('mouseout', function () {
                    this.start();
                });
                handleLogin();
                $.backstretch([
                    static_url + "templates/metronics/assets/pages/media/bg/1.jpg",
                    static_url + "templates/metronics/assets/pages/media/bg/2.jpg",
                    static_url + "templates/metronics/assets/pages/media/bg/3.jpg",
                    static_url + "templates/metronics/assets/pages/media/bg/4.jpg"
                ],
                    {
                        fade: 1000,
                        duration: 8000
                    }
                );
                $(".login-form").on('submit', function () {
                    App.startPageLoading();
                    var userid = $('input[name="username"]').val();
                    var userpass = $('input[name="password"]').val();
                    var uri = base_url + 'auth-user';
                    var formdata = {
                        login: {
                            userid: userid,
                            password: Base64.encode(userpass)
                        }
                    };
                    $.ajax({
                        url: uri,
                        type: "post",
                        data: formdata,
                        success: function (response) {
                            if (response != 'failed') {
                                var res = JSON.parse(response);
                                // you will get response from your php page (what you echo or print)
                                if (res.message.login == 'success') {
                                    toastr.success('Successfully login into dashboard...');
                                    if (res.message.group == '1') {
                                        App.stopPageLoading();
                                        window.location = base_url + 'backend/dashboard';
                                    } else if (res.message.group == 2) {
                                        App.stopPageLoading();
                                        window.location = base_url + 'dashboard';
                                    } else if (res.message.group == 3) {
                                        App.stopPageLoading();
                                        window.location = base_url + 'vendor/dashboard';
                                    } else if (res.message.group == 4) {
                                        App.stopPageLoading();
                                        window.location = base_url + 'monitor/dashboard';
                                    }
                                } else {
                                    App.stopPageLoading();
                                    // toastr.error('Username/Email or Password did not match or not found at db system!!!');
                                    toastr.error('NIP atau Kata Sandi tidak cocok atau tidak ditemukan di database !!');
                                }
                            } else {
                                App.stopPageLoading();
                                toastr.error('NIP atau Kata Sandi tidak cocok atau tidak ditemukan di database !!');
                            }
                            return false;
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            App.stopPageLoading();
                            console.log(textStatus, errorThrown);
                            return false;
                        }
                    });
                    App.stopPageLoading();
                    return false;
                });
            }
        };
    }();

    jQuery(document).ready(function () {
        Login.init();
    });
</script>
