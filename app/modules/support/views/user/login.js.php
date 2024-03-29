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
                        required: "Username is required."
                    },
                    password: {
                        required: "Password is required."
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
        }

        var handleForgetPassword = function () {
            $('.forget-form').validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                    email: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    email: {
                        required: "Email is required."
                    }
                },
                invalidHandler: function (event, validator) { //display error alert on form submit

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
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });

            $('.forget-form input').keypress(function (e) {
                if (e.which == 13) {
                    if ($('.forget-form').validate().form()) {
                        $('.forget-form').submit();
                    }
                    return false;
                }
            });

            jQuery('#forget-password').click(function () {
                jQuery('.login-form').hide();
                jQuery('.forget-form').show();
            });

            jQuery('#back-btn').click(function () {
                jQuery('.login-form').show();
                jQuery('.forget-form').hide();
            });

        }

        var handleRegister = function () {
            function format(state) {
                if (!state.id) {
                    return state.text;
                }
                var $state = $( '<span><img src="' + static_url() + 'templates/metronics/assets/global/img/flags/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>' );
                return $state;
            }

            if (jQuery().select2 && $('#country_list').size() > 0) {
                $("#country_list").select2({
                    placeholder: '<i class="fa fa-map-marker"></i>&nbsp;Select a Country',
                    templateResult: format,
                    templateSelection: format,
                    width: 'auto',
                    escapeMarkup: function (m) {
                        return m;
                    }
                });
                $('#country_list').change(function () {
                    $('.register-form').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
                });
            }

            $('.register-form').validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                    fullname: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    address: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    country: {
                        required: true
                    },
                    username: {
                        required: true
                    },
                    password: {
                        required: true
                    },
                    rpassword: {
                        equalTo: "#register_password"
                    },
                    tnc: {
                        required: true
                    }
                },

                messages: {// custom messages for radio buttons and checkboxes
                    tnc: {
                        required: "Please accept TNC first."
                    }
                },
                invalidHandler: function (event, validator) { //display error alert on form submit
                },
                highlight: function (element) { // hightlight error inputs
                    $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
                },
                success: function (label) {
                    label.closest('.form-group').removeClass('has-error');
                    label.remove();
                },
                errorPlacement: function (error, element) {
                    if (element.attr("name") == "tnc") { // insert checkbox errors after the container
                        error.insertAfter($('#register_tnc_error'));
                    } else if (element.closest('.input-icon').size() === 1) {
                        error.insertAfter(element.closest('.input-icon'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });

            $('.register-form input').keypress(function (e) {
                if (e.which == 13) {
                    if ($('.register-form').validate().form()) {
                        $('.register-form').submit();
                    }
                    return false;
                }
            });

            jQuery('#register-btn').click(function () {
                jQuery('.login-form').hide();
                jQuery('.register-form').show();
            });

            jQuery('#register-back-btn').click(function () {
                jQuery('.login-form').show();
                jQuery('.register-form').hide();
            });
        }

        return {
            //main function to initiate the module
            init: function () {
                handleLogin();
                handleForgetPassword();
                handleRegister();
                $.backstretch(
                    [
                        static_url + "templates/metronics/assets/pages/media/bg/1.jpg",
                        static_url + "templates/metronics/assets/pages/media/bg/2.jpg",
                        static_url + "templates/metronics/assets/pages/media/bg/3.jpg",
                        static_url + "templates/metronics/assets/pages/media/bg/4.jpg"
                    ], {
                        fade: 1000,
                        duration: 8000
                    }
                );
                $(".login-form").on('submit', function () {
                    App.startPageLoading();
                    var userid = $('input[name="username"]').val();
                    var userpass = $('input[name="password"]').val();
                    var uri = base_url + 'support/auth-user';
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
                            if (response) {
                                var res = JSON.parse(response);
                                // you will get response from your php page (what you echo or print)
                                if (res.message.login == 'success') {
                                    toastr.success('Successfully login into dashboard...');
                                    setTimeout(function () {
                                        App.stopPageLoading();
                                        window.location = base_url + 'support/dashboard';
                                    }, 2100);
                                } else {
                                    toastr.error('Username/Email or Password did not match or not found at db system!!!')
                                }
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
            }
        };
    }();

    jQuery(document).ready(function () {
        Login.init();
    });
</script>
