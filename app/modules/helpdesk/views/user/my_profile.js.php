<script>
    var fnGetUserData = function () {
        $.ajax({
            url: base_url + 'helpdesk/user/get_data/',
            method: "POST", //First change type to method here
            success: function (response) {
                // toastr.success('Successfully ');
                var row = JSON.parse(response);
                var status_ = false;
                if (row.act_status == 1) {
                    status_ = true;
                }
                if (row.img) {
                    $('#img_profile').show();
                    $('.thumbnail').html('<img style="height: 140px" src="' + static_url + row.img + '" />');
                } else {
                    $('#img_profile').show();
                }
                $('input[name="id"]').val(row.id);
                $('input[name="username"]').val(row.username);
                $('input[name="first_name"]').val(row.first_name);
                $('input[name="last_name"]').val(row.last_name);
                $('input[name="email"]').val(row.email);
                $('input[name="group_name"]').val(row.group_name);
                $("[name='status']").bootstrapSwitch('state', status_);
                $('textarea[name="description"]').val(row.description);
            },
            error: function () {
                toastr.error('Failed ');
                return false;
            }

        });
    };
	
    var Ajax = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnGetUserData();
                $("#add_edit").submit(function (e) {
                    e.preventDefault();
                    var id = $('input[name="id"]').val();
                    var is_active = $("[name='status']").bootstrapSwitch('state');
                    var uri = base_url + 'helpdesk/user/update/';
                    var pht = {};
                    if ($('#photo')[0].files[0]) {
                        pht = {
                            data: Base64.encode($('#photo')[0].files[0].result)
                        };
                    }
                    var formdata = {
                        id: Base64.encode(id),
                        username: $('input[name="username"]').val(),
                        first_name: $('input[name="first_name"]').val(),
                        last_name: $('input[name="last_name"]').val(),
                        email: $('input[name="email"]').val(),
                        active: is_active,
                        files: pht
                    };
                    $.ajax({
                        url: uri,
                        method: "POST", //First change type to method here
                        data: formdata,
                        success: function (response) {
                            toastr.success('Berhasil ubah data profil');
                            // fnCloseModal();
                            window.location.reload();
                            return false;
                        },
                        error: function () {
                            toastr.error('Failed ' + txt);
                            fnCloseModal();
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
