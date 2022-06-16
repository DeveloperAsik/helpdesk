<script>
    var fnGrowlNotif = function (text, type_, offset_, width_, align_, delay_, dismiss_) {
        /*
         * type :                offset :            Align :
         * Info                  Top                 Left
         * Danger                Bottom              Right
         * Success                                   Center
         * Warning
         */
        if (text) {
            $.bootstrapGrowl(text, {
                ele: 'body', // which element to append to
                type: type_, // (null, 'info', 'danger', 'success', 'warning')
                offset: {
                    from: offset_,
                    amount: parseInt(offset_)
                }, // 'top', or 'bottom'
                align: align_, // ('left', 'right', or 'center')
                width: parseInt(width_), // (integer, or 'auto')
                delay: delay_, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
                allow_dismiss: dismiss_, // If true then will display a cross to close the popup.
                stackup_spacing: 10 // spacing between consecutively stacked growls.
            });
        }
    };

    var fnGetMonthName = function (i) {
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        return monthNames[i];
    };

    var index = function () {
        return {
            //main function to initiate the module
            init: function () {
                $('.pluginText').on('click', 'a.left_cntrl', function () {
                    $('.pluginText').css('width', '250px');
                    $('.pluginText').css('min-height', '250px');
                    $('.left_cntrl').hide();
                    $('.right_cntrl').show();
                    $('.pluginTextResult').fadeIn();
                    var uri = base_url + 'api/request/get_ajax_text_plugin/';
                    $.ajax({
                        url: uri,
                        method: "POST", //First change type to method here
                        success: function (response) {
                            $('.pluginTextResult').html(response);
                            $('.plugin_ajax_text').attr('data-field_name', name);
                        },
                        error: function () {
                            toastr.error('Failed ' + txt);
                        }
                    });
                    return false;
                });

                $('.pluginText').on('click', 'a.right_cntrl', function () {
                    $('.pluginText').css('width', '3%');
                    $('.pluginText').css('min-height', '5%');
                    $('.right_cntrl').hide();
                    $('.left_cntrl').show();
                    $('.pluginTextResult').hide();
                });

                $('div.pluginTextResult').on('click', 'a.btn', function () {
                    var name = $(this).data('name');
                    var field_name = $(this).data('field_name');
                    switch (name) {
                        case 'add_lorem_ipsum':
                            var uri = base_url + 'api/request/get_content/add_lorem_ipsum';
                            $.ajax({
                                url: uri,
                                method: "POST", //First change type to method here
                                success: function (response) {
                                    console.log('textarea[name="' + field_name + '"]');
                                    $('textarea[name="' + field_name + '"]').val(response);
                                },
                                error: function () {
                                    toastr.error('Failed ' + txt);
                                }
                            });
                            return false;
                            break;

                    }
                });

                $('textarea[class="form-control"]').on('click', function () {
                    var name = $(this).attr('name');
                    $('.plugin_ajax_text').attr('data-field_name', name);
                    $('.plugin_ajax_text').css('border', '1px solid #caf09f');
                });
            }
        };

    }();

    jQuery(document).ready(function () {
        index.init();
    });

</script>