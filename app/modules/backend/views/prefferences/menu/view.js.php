<script>
    var fnInitTree = function (id, logged, name) {
        $.ajax({
            type: "GET",
            url: base_backend_url + ('prefferences/menu/get_menu/' + id + '/' + logged + '/' + name),
            dataType: "json",
            success: function (json) {
                var el = '#tree_' + id;
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
                        $('#opt_add').attr('data-module_id', data.module_id);
                        $('#opt_add').attr('data-module_name', data.module_name);
                        $('#opt_add').attr('data-parent_id', data.id);
                        $('#opt_add').attr('data-parent_name', data.text);
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
                var module_id_exist = $('li.active a').attr('data-module_id');
                var module_name_exist = $('li.active a').attr('data-module_name');
                fnInitTree(module_id_exist, 1, module_name_exist);
                $('a').on('click', function () {
                    if ($(this).attr('data-type') == 'tab') {
                        var href = $(this).attr('href');
                        var module_id = $(this).attr('data-module_id');
                        var module_name = $(this).attr('data-module_name');
                        fnInitTree(module_id, 1, module_name);
                    }
                });
                $('.btn').on('click', function () {
                    var module_id_exist = $('li.active a').attr('data-module_id');
                    var cls = $(this).attr('id');
                    var id = $(this).attr('data-id');
                    var action = $(this).attr('data-action');
                    if (action == 'close-modal') {
                        $('#add_edit')[0].reset();
                    }
                    switch (cls) {
                        case 'opt_refresh':
                            break;

                        case 'opt_add':
                            $('#title_mdl').html('Add new menu');
                            $('input[name="module_id"]').val($(this).attr('data-module_id'));
                            $('input[name="module_name"]').val($(this).attr('data-module_name'));
                            $('input[name="parent_id"]').val($(this).attr('data-parent_id'));
                            $('input[name="parent_name"]').val($(this).attr('data-parent_name'));
                            $('input[name="level"]').val($(this).attr('data-level'));

                            $('#modal_add_edit').show();
                            break;

                        case 'opt_edit':
                            $('#title_mdl').html('Update exist menu');
                            var formdata = {
                                id: Base64.encode(id)
                            };
                            var uri = base_backend_url + 'prefferences/menu/get_data/';
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
                                        var logged_ = false;
                                        if (row.is_logged_in == 1) {
                                            logged_ = true;
                                        }
                                        $('input[name="id"]').val(row.id);
                                        $('input[name="module_id"]').val(row.module_id);
                                        $('input[name="module_name"]').val(row.module_name);
                                        $('input[name="parent_id"]').val(row.parent_id);
                                        $('input[name="parent_name"]').val(row.parent_name);
                                        $('input[name="rank"]').val(row.rank);
                                        $('input[name="level"]').val(row.level);
                                        $('input[name="name"]').val(row.name);
                                        $('input[name="name_ina"]').val(row.name_ina);
                                        $('input[name="path"]').val(row.path);
                                        document.getElementById("icon").selectedIndex = row.icon_id;
                                        $("[name='status']").bootstrapSwitch('state', status_);
                                        $("[name='logged']").bootstrapSwitch('state', logged_);
                                        $('textarea[name="description"]').val(row.description);
                                        $('#modal_add_edit').show();
                                    }
                                },
                                error: function () {
                                    toastr.error('Failed ' + response);
                                    $('#tree_' + module_id_exist).treeview('remove');
                                }
                            });
                            break;
                        case 'opt_delete':
                            bootbox.confirm("Are you sure?", function (result) {
                                if (result == false) {
                                    $('.modal-backdrop').hide();
                                    $('.bootbox ').hide();
                                    return false;
                                }
                                var formdata = {
                                    id: Base64.encode(id)
                                };
                                var uri = base_backend_url + 'prefferences/menu/delete/';
                                $.ajax({
                                    url: uri,
                                    method: "POST", //First change type to method here
                                    data: formdata,
                                    success: function (response) {
                                        fnToStr('Successfully delete node.', 'success');
                                        $('#tree_' + module_id_exist).treeview('remove');
                                        fnInitTree(module_id_exist, 1, module_name_exist);
                                    },
                                    error: function (response) {
                                        toastr.error('Failed ' + response);
                                        $('#tree_' + module_id_exist).treeview('remove');
                                        fnInitTree(module_id_exist, 1, module_name_exist);
                                    }
                                });
                            });
                            break;
                    }
                });

                $('form#add_edit').on('submit', function () {
                    var id = $('input[name="id"]').val();
                    var parent_id = $('input[name="parent_id"]').val();
                    var level = $('input[name="level"]').val();
                    var path = $('input[name="path"]').val();
                    var rank = $('input[name="rank"]').val();
                    var module = $('input[name="module_id"]').val();
                    var is_active = $('input[name="status"]').bootstrapSwitch('state');
                    var is_logged_in = $('input[name="logged"]').bootstrapSwitch('state');
                    var formdatasubmit = {
                        name: $('input[name="name"]').val(),
                        name_ina: $('input[name="name_ina"]').val(),
                        parent_id: parent_id,
                        level: level,
                        rank: rank,
                        icon: $('#icon').val(),
                        path: path,
                        module: module,
                        description: $('textarea[name="description"]').val(),
                        active: is_active,
                        logged: is_logged_in
                    };
                    var urisubmit = base_backend_url + 'prefferences/menu/insert/';
                    if (id) {
                        urisubmit = base_backend_url + 'prefferences/menu/update/';
                        var formdatasubmit = {
                            id: Base64.encode(id),
                            name: $('input[name="name"]').val(),
                            name_ina: $('input[name="name_ina"]').val(),
                            parent_id: parent_id,
                            level: level,
                            rank: rank,
                            icon: $('#icon').val(),
                            path: path,
                            module: module,
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
                            $('#tree_' + module).treeview('remove');
                            fnInitTree(module, 1, module_name_exist);
                            fnCloseModal();
                        },
                        error: function (response) {
                            toastr.error('Failed ' + response);
                            $('#tree_' + module).treeview('remove');
                            fnInitTree(module, 1, module_name_exist);
                            fnCloseModal();
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