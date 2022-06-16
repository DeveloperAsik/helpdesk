<script>
    var el = '#method';

    var fnAjaxBtn_select_all = function () {
        $(el).multiSelect('select_all');
    };

    var fnAjaxBtn_deselect_all = function () {
        $(el).multiSelect('deselect_all');
    };

    var fnAjaxBtn_refresh = function () {
        $(el).multiSelect('refresh');
    };

    var fnMultiSelect = function () {
        $(el).multiSelect({
            selectableHeader: "<div class='btn-group btn-group-xs btn-group-solid'><button type='button' class='btn green' onclick='fnAjaxBtn_select_all()' id='select-all'>select all</button></div>",
            selectionHeader: "<div class='btn-group btn-group-xs btn-group-solid'><button type='button' class='btn green' onclick='fnAjaxBtn_deselect_all()' id='deselect-all'>deselect all</button></div>",
        });
        return false;
    };

    var fnGetModule = function () {
        $.ajax({
            url: base_backend_url + 'prefferences/group_permission/get_module/',
            method: "POST", //First change type to method here
            success: function (response) {
                $('.module').html(response);
            },
            error: function (response) {
                $('.module').html(response);
            }
        });
        return false;
    };

    var fnGetGroup = function () {
        $.ajax({
            url: base_backend_url + 'prefferences/group_permission/get_group/',
            method: "POST", //First change type to method here
            success: function (response) {
                $('#group').html(response);
            },
            error: function (response) {
                $('#group').html(response);
            }
        });
        return false;
    };

    var fnGetMethod = function () {
        $.ajax({
            url: base_backend_url + 'prefferences/group_permission/get_method/',
            method: "POST", //First change type to method here
            success: function (response) {
                $('#method').html(response);
                fnMultiSelect();
            },
            error: function (response) {
                $('#method').html(response);
            }

        });
    };

    var Ajax = function () {
        return {
            //main function to initiate the module
            init: function () {
                $('.method_exist').on('click', function () {
                    var value = $(this).val();
                    if (value == 1) {
                        $('#frmMltSlctMethod').show();
                        $('#frmMethodSelected').hide();
                    } else {
                        $('#frmMethodSelected').show();
                        $('#frmMltSlctMethod').hide();
                    }
                }); 
                
                var table = $('#datatable_ajax').DataTable({
                    "lengthMenu": [[10, 25, 50], [10, 25, 50]],
                    'processing': true,
                    'language': {
                        'loadingRecords': '',
                        'processing': fnLoadingImg('loading.gif')
                    },
                    "sPaginationType": "bootstrap",
                    "paging": true,
                    "pagingType": "full_numbers",
                    "ordering": false,
                    "serverSide": true,
                    "processing": true,
                    "language": {
                        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                    },
                    "ajax": {
                        url: base_backend_url + 'prefferences/group_permission/get_list/',
                        type: 'POST'
                    },
                    "columns": [
                        {"data": "rowcheck"},
                        {"data": "num"},
                        {"data": "group_name"},
                        {"data": "class"},
                        {"data": "action"},
                        {"data": "allowed"},
                        {"data": "public"},
                        {"data": "active"}
                    ],
                    "drawCallback": function (settings) {
                        $('.make-switch').bootstrapSwitch();
                    }
                });

                $('#datatable_ajax').on('switchChange.bootstrapSwitch', 'input[name="status"]', function (event, state) {
                    bootbox.confirm("Are you sure?", function (result) {
                        if (result == false) {
                            $('.modal-backdrop').hide();
                            $('.bootbox ').hide();
                            return false;
                        }
                        var id = $(this).attr('data-id');
                        var formdata = {
                            id: Base64.encode(id),
                            active: state
                        };
                        $.ajax({
                            url: base_backend_url + 'prefferences/group_permission/update_status/',
                            method: "POST", //First change type to method here
                            data: formdata,
                            success: function (response) {
                                toastr.success('Successfully ' + response);
                                return false;
                            },
                            error: function () {
                                toastr.error('Failed ' + response);
                                return false;
                            }
                        });
                    });
                });

                $('a.btn').on('click', function () {
                    var action = $(this).attr('data-id');
                    var count = $('input.select_tr:checkbox').filter(':checked').length;
                    switch (action) {
                        case 'add':
                            $('.modal-title').html('Insert New Group permission');
                            fnGetModule();
                            fnGetGroup();
                            fnGetMethod();
                            break;

                        case 'edit':
                            $('.modal-title').html('Update Exist Group permission');
                            fnGetModule();
                            fnGetGroup();
                            fnGetMethod();
                            var status_ = $(this).hasClass('disabled');
                            var id = $('input.select_tr:checkbox:checked').attr('data-id');
                            if (status_ == 0) {
                                var formdata = {
                                    id: Base64.encode(id)
                                };
                                $.ajax({
                                    url: base_backend_url + 'prefferences/group_permission/get_data/',
                                    method: "POST", //First change type to method here
                                    data: formdata,
                                    success: function (response) {
                                        var row = JSON.parse(response);
                                        var status_ = false;
                                        if (row.is_active == 1) {
                                            status_ = true;
                                        }

                                        var allowed_ = false;
                                        if (row.is_allowed == 1) {
                                            allowed_ = true;
                                        }
                                        if (row.action) {
                                            $('#frmMethodSelected').fadeIn();
                                            $('#frmMltSlctMethod').fadeOut();
                                            $("input[type=radio] .method_exist").prop("checked", true);
                                            $('input[name="method2"]').val(row.action);
                                        }
                                        $('input[name="id"]').val(row.id);
                                        $('input[name="permission_id"]').val(row.permission_id);
                                        $('input[name="name"]').val(row.name);
                                        $('input[name="class"]').val(row.class);
                                        $("[name='status']").bootstrapSwitch('state', status_);
                                        $("[name='allowed']").bootstrapSwitch('state', allowed_);
                                        $('textarea[name="description"]').val(row.description);
                                        $('#modal_add_edit').modal('show');
                                    },
                                    error: function () {
                                        fnToStr('Error is occured, please contact administrator.', 'error');
                                    }
                                });
                                return false;
                            }
                            break;

                        case 'delete':
                            bootbox.confirm("Are you sure to delete this id?", function (result) {
                                if (result == false) {
                                    $('.modal-backdrop').hide();
                                    $('.bootbox ').hide();
                                    return false;
                                }
                                var uri = base_backend_url + 'prefferences/group_permission/delete/';
                                id = [];
                                $("input.select_tr:checkbox:checked").each(function () {
                                    id.push($(this).data("id"));
                                });
                                fnAjaxPost(uri, {id: id}, 'delete');
                                fnRefreshDataTable();
                                fnResetBtn();
                            });
                            break;

                        case 'refresh':
                            fnRefreshDataTable();
                            break;
                    }
                });

                $("#submit").on('click', function () {
                    var uri = base_backend_url + 'prefferences/group_permission/insert/';
                    var id = $('input[name="id"]').val();
                    var is_active = $('[name="status"]').bootstrapSwitch('state');
                    var is_allowed = $('[name="allowed"]').bootstrapSwitch('state');
                    var is_public = $('[name="ispublic"]').bootstrapSwitch('state');
                    var txt = 'add new group_permission';
                    var method_exist = $("input[name='method_exist']:checked").val();
                    var method = $('#method2').val();
                    if (method_exist == 1) {
                        method = [];
                        $.each($(".multi-select option:selected"), function () {
                            method.push($(this).val());
                        });
                    }
                    var formdata = {
                        module_: $('#module').val(),
                        group_: $('#group').val(),
                        class_: $('input[name="class"]').val(),
                        method_: method,
                        is_active: is_active,
                        is_allowed: is_allowed,
                        is_public: is_public,
                        description: $('textarea[name="description"]').val()
                    };
                    if (id) {
                        uri = base_backend_url + 'prefferences/group_permission/update/';
                        txt = 'update group permission';
                        formdata = {
                            id: Base64.encode(id),
                            permission_id: Base64.encode($('input[name="permission_id"]').val()),
                            module_: $('#module').val(),
                            group_: $('#group').val(),
                            class_: $('input[name="class"]').val(),
                            method_: method,
                            is_active: is_active,
                            is_allowed: is_allowed,
                            is_public: is_public,
                            description: $('textarea[name="description"]').val()
                        };
                    }
                    $.ajax({
                        url: uri,
                        method: "POST", //First change type to method here
                        data: formdata,
                        success: function (response) {
                            toastr.success('Successfully ' + txt);
                            fnCloseModal();
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