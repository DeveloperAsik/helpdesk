<script>
    var fnInitTree = function (id) {
        $.ajax({
            type: "GET",
            url: base_backend_url + ('tickets/category/get_category/'),
            dataType: "json",
            success: function (json) {
                var el = '#tree_';
                $(el).treeview({
                    data: json,
                    showCheckbox: true,
                    onNodeSelected: function (event, data) {
                        $(el).treeview('uncheckAll', {silent: true});
                        $('#opt_add').fadeOut();
                        $('#opt_edit').fadeIn();
                        $('#opt_edit').removeAttr('disabled');
                        $('#opt_edit').removeClass('disabled');
                        $('#opt_delete').fadeIn();
                        $('#opt_delete').removeAttr('disabled');
                        $('#opt_delete').removeClass('disabled');
                        $('#opt_remove').fadeIn();
                        $('#opt_remove').removeAttr('disabled');
                        $('#opt_remove').removeClass('disabled');
                        $('#opt_edit').attr('data-id', data.id);
                        $('#opt_delete').attr('data-id', data.id);
                        $('.actions').show();
                    },
                    onNodeChecked: function (event, data) {
                        $('#add_edit')[0].reset();
                        $(el).treeview('unselectNode', [data.nodeId, {silent: true}]);
                        $('#opt_add').fadeIn();
                        $('#opt_edit').fadeOut();
                        $('#opt_delete').fadeOut();
                        $('#opt_add').attr('data-parent_id', data.id);
                        $('#opt_add').attr('data-parent_name', data.s_text);
                        $('#opt_add').attr('data-level', data.level);
                        $('.actions').show();
                    }
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    };

    var Index = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnInitTree();
                $('.btn').on('click', function () {
                    var cls = $(this).attr('id');
                    var action = $(this).attr('data-action');
                    var id = $(this).attr('data-id');
                    if (action == 'close-modal') {
                        $('#add_edit')[0].reset();
                    }
                    switch (cls) {
                        case 'opt_refresh':
                            break;

                        case 'opt_add':
                            $('#title_mdl').html('Add new menu');
                            $('input[name="parent_id"]').val($(this).attr('data-parent_id'));
                            $('input[name="parent_name"]').val($(this).attr('data-parent_name'));
                            $('input[name="level"]').val($(this).attr('data-level'));
                            $('#modal_add_edit').show();
                            break;

                        case 'opt_edit':
                            $('#title_mdl').html('Update exist menu');
                            var id = $(this).attr('data-id');
                            var formdata = {
                                id: Base64.encode(id)
                            };
                            var uri = base_backend_url + 'tickets/category/get_data/';
                            $.ajax({
                                url: uri,
                                method: "POST", //First change type to method here
                                data: formdata,
                                success: function (response) {
                                    var row = JSON.parse(response);
                                    if (row) {
                                        var status_ = false;
                                        if (row.is_active == 1) {
                                            status_ = true;
                                        }
                                        $('input[name="id"]').val(row.id);
                                        $('input[name="parent_id"]').val(row.parent_id);
                                        $('input[name="parent_name"]').val(row.parent_name);
                                        $('input[name="level"]').val(row.level);
                                        $('input[name="name"]').val(row.name);
                                        $('input[name="name_ina"]').val(row.name_ina);
                                        document.getElementById("icon").selectedIndex = row.icon;
                                        $("[name='status']").bootstrapSwitch('state', status_);
                                        $('textarea[name="description"]').val(row.description);
                                        $('#modal_add_edit').show();
                                    }
                                },
                                error: function () {
                                    toastr.error('Failed ' + response);
                                    $('#tree_').treeview('remove');
                                }
                            });
                            break;

                        case 'opt_delete':
                            bootbox.confirm("Are you sure to delete this id?", function (result) {
                                if (result == false) {
                                    $('.modal-backdrop').hide();
                                    $('.bootbox ').hide();
                                    return false;
                                }
                                var uri = base_backend_url + 'tickets/category/delete/';
                                var frmdata = {
                                    id: Base64.encode(id)
                                };
                                $.ajax({
                                    url: uri,
                                    method: "POST", //First change type to method here
                                    data: frmdata,
                                    success: function (response) {
                                        console.log(response);return false;
                                        toastr.success('success ' + response);
                                        fnResetBtn();
                                        fnInitTree(1);
                                        return false;
                                    },
                                    error: function () {
                                        toastr.error('Failed ' + response);
                                        return false;
                                    }
                                });
                            });
                            break;
                    }
                });

                $('#submit_add_edit').on('click', function () {
                    var id = $('input[name="id"]').val();
                    var parent_id = $('input[name="parent_id"]').val();
                    var level = $('input[name="level"]').val();
                    var is_active = $('input[name="status"]').bootstrapSwitch('state');
                    var formdatasubmit = {
                        name: $('input[name="name"]').val(),
                        name_ina: $('input[name="name_ina"]').val(),
                        parent_id: parent_id,
                        level: level,
                        icon: $('#icon').val(),
                        description: $('textarea[name="description"]').val(),
                        active: is_active,
                        logged: is_logged_in
                    };

                    var urisubmit = base_backend_url + 'tickets/category/insert/';
                    if (id) {
                        urisubmit = base_backend_url + 'tickets/category/update/';
                        var formdatasubmit = {
                            id: Base64.encode(id),
                            name: $('input[name="name"]').val(),
                            name_ina: $('input[name="name_ina"]').val(),
                            parent_id: parent_id,
                            level: level,
                            icon: $('#icon').val(),
                            description: $('textarea[name="description"]').val(),
                            active: is_active,
                            logged: is_logged_in
                        };
                    }

                    $.ajax({
                        url: urisubmit,
                        method: "POST", //First change type to method here
                        data: formdatasubmit,
                        success: function (response) {
                            toastr.success('success ' + response);
                            $('#tree_').treeview('remove');
                            fnInitTree(1);
                            fnCloseModal();
                            return false;
                        },
                        error: function () {
                            toastr.error('Failed ' + response);
                            $('#tree_').treeview('remove');
                            fnInitTree(1);
                            fnCloseModal();
                            return false;
                        }
                    });
                    return false;
                });
            }
        };
    }();

    jQuery(document).ready(function () {
        Index.init();
    });
</script>